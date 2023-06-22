<?php

namespace App\Exports;

use App\Models\User;
use App\Models\ReportField;
use App\Models\SearchField;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class EmployeeExport implements FromCollection, WithHeadings
{
    use Exportable;
    protected $companyDepartmentIds;
    protected $employeeTypeIds;
    protected $searchQuery;
    protected $selectedComments;
    protected $selectedFields;

    public function __construct($companyDepartmentIds, $employeeTypeIds, $searchQuery)
    {
        $this->companyDepartmentIds = $companyDepartmentIds;
        $this->employeeTypeIds = $employeeTypeIds;
        $this->searchQuery = $searchQuery;
        $reportFields = ReportField::where('status', 1)->get();
        $this->selectedComments = $reportFields->pluck('comment')->toArray();
        $this->selectedFields = $reportFields->pluck('field')->toArray();
    }
    public function collection()
    {
        // Retrieve the data you want to export and transform if needed
        $employeeTypeIds = $this->employeeTypeIds;
        $departmentIds = $this->companyDepartmentIds;
        $queryInput = $this->searchQuery;
        $searchFields = SearchField::where('table', 'report_fields')->where('status', 1)->get();
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

        $employees = $query->get();

        if (!empty($employeeTypeIds) && !empty($departmentIds)) {
            $employees = $employees->whereIn('employee_type_id', $employeeTypeIds)
                        ->whereIn('company_department_id', $departmentIds);
        } elseif (!empty($employeeTypeIds)) {
            $employees = $employees->whereIn('employee_type_id', $employeeTypeIds);
        } elseif (!empty($departmentIds)) {
            $employees = $employees->whereIn('company_department_id', $departmentIds);
        }

        $employees = $employees->sortBy('company_department_id'); // Add this line

        $selectedFields = $this->selectedFields;
        
        $data = $employees->map(function ($employee) use ($selectedFields) {
            $data = [];

            foreach ($selectedFields as $field) {
                if ($field === 'prefix') {
                    $data['Prefix'] = (string) $employee->prefix->name;
                } elseif ($field === 'nationality') {
                    $data['Nationality'] = (string) $employee->nationality->name;
                } elseif ($field === 'ethnicity') {
                    $data['Ethnicity'] = (string) $employee->ethnicity->name;
                } elseif ($field === 'user_position') {
                    $data['UserPosition'] = (string) $employee->user_position->name;
                } elseif ($field === 'employee_type') {
                    $data['EmployeeType'] = (string) $employee->employee_type->name;
                } elseif ($field === 'company_department') {
                    $data['CompanyDepartment'] = (string) $employee->company_department->name;
                } elseif ($field === 'employee_no') {
                    $data['EmployeeNo'] = (string) $employee->employee_no;
                } elseif ($field === 'name') {
                    $data['Name'] = (string) $employee->name;
                } elseif ($field === 'lastname') {
                    $data['Lastname'] = (string) $employee->lastname;
                } elseif ($field === 'address') {
                    $data['Address'] = (string) $employee->address;
                } elseif ($field === 'phone') {
                    $data['Phone'] = (string) $employee->phone;
                } elseif ($field === 'hid') {
                    $data['Hid'] = (string) $employee->hid;
                } elseif ($field === 'passport') {
                    $data['Passport'] = (string) $employee->passport;
                } elseif ($field === 'work_permit') {
                    $data['WorkPermit'] = (string) $employee->work_permit;
                } elseif ($field === 'start_work_date') {
                    $data['StartWorkDate'] = (string) $employee->StartWorkDate;
                } elseif ($field === 'birth_date') {
                    $data['BirthDate'] = (string) $employee->BirthDate;
                } elseif ($field === 'visa_expiry_date') {
                    $data['VisaExpiryDate'] = (string) $employee->VisaExpiryDate;
                } elseif ($field === 'permit_expiry_date') {
                    $data['PermitExpiryDate'] = (string) $employee->PermitExpiryDate;
                } elseif ($field === 'education_level') {
                    $data['EducationLevel'] = (string) $employee->education_level;
                } elseif ($field === 'education_branch') {
                    $data['EducationBranch'] = (string) $employee->education_branch;
                } elseif ($field === 'bank') {
                    $data['Bank'] = (string) $employee->bank;
                } elseif ($field === 'bank_account') {
                    $data['BankAccount'] = (string) $employee->bank_account;
                }
            }

            return $data;
        });

        return $data;
    }

    public function headings(): array
    {
        // Define the headings for the Excel file
        return $this->selectedComments;
    }

}