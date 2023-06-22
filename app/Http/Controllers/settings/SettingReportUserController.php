<?php

namespace App\Http\Controllers\settings;

use PDF;
use App\Models\User;
use App\Models\SearchField;
use App\Models\EmployeeType;
use App\Models\UserPosition;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use App\Models\ReportField;
use Maatwebsite\Excel\Facades\Excel;

class SettingReportUserController extends Controller
{
    /**
     * แสดงหน้าตารางสำหรับการออกรายงาน
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = ['title' => 'ตัวอย่าง', 'body' => 'test'];
        // $pdf = PDF::loadView('dashboard.report.user.user-report', $data);
        // return $pdf->stream('document.pdf');
        $employeeTypes = EmployeeType::all();  // เรียกข้อมูลประเภทพนักงานทั้งหมดจากตาราง employee_types
        $companyDepartments = CompanyDepartment::all();  // เรียกข้อมูลแผนกบริษัททั้งหมดจากตาราง company_departments
        $users = User::paginate(20);
        return view('dashboard.report.user.index',[
            'users' => $users,
            'employeeTypes' => $employeeTypes,
            'companyDepartments' => $companyDepartments,
        ]);
    }

    public function export(Request $request)
    {
        $companyDepartmentIds = $request->selectedDepartments;
        $employeeTypeIds = $request->selectedEmployeeTypes;
        $searchQuery = $request->searchString;
        $fileName = 'employees.xlsx';

        $export = new EmployeeExport($companyDepartmentIds, $employeeTypeIds, $searchQuery);

        return Excel::download($export, $fileName);
    }

    public function search(Request $request)
    {
        $queryInput = $request->searchInput;
             
        $searchFields = SearchField::where('table','users')->where('status',1)->get();

        $query = User::query();
        
        foreach ($searchFields as $field) {
            $fieldName = $field['field'];
            $fieldType = $field['type'];
            
            if ($fieldType === 'foreign') {
                $query->orWhereHas($fieldName, function ($query) use ($fieldName, $queryInput) {
                    $query->where('name', 'like', "%{$queryInput}%");
                });
            } else {
                $query->orWhere($fieldName, 'like', "%{$queryInput}%");
            }
        }

        $users = $query->paginate(20);
        return view('dashboard.report.user.table-render.employee-table',['users' => $users])->render();
    }

    public function getReportField(Request $request)
    {
        $reportFields = ReportField::where('table','report_fields')->get();
        return view('dashboard.report.user.table-render.report-field-table',['reportFields' => $reportFields])->render();
    }

    public function updateReportField(Request $request)
    {
        $updateReportFieldIds = $request->updateReportFields;
        // Update the ReportField records
        ReportField::where('table', 'report_fields')
            ->whereNotIn('id', $updateReportFieldIds)
            ->update(['status' => 0]);

        ReportField::where('table', 'report_fields')
            ->whereIn('id', $updateReportFieldIds)
            ->update(['status' => 1]);
        $reportFields = ReportField::where('table','report_fields')->get();
        return view('dashboard.report.user.table-render.report-field-table',['reportFields' => $reportFields])->render();
    }
}
