<?php

namespace App\Exports;

use App\Models\User;
use App\Models\ReportField;
use App\Models\SearchField;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

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
        $excludedComments = ['อีเมล'];
        $this->selectedComments = $reportFields
                ->pluck('comment')
                ->reject(function ($comment) use ($excludedComments) {
                    return in_array($comment, $excludedComments);
                })
                ->toArray();
        $this->selectedFields = $reportFields->pluck('field')->toArray();
    }
    public function collection()
    {
        $employeeTypeIds = $this->employeeTypeIds;
        $departmentIds = $this->companyDepartmentIds;
        $queryInput = $this->searchQuery;
 
        $employees = User::where(function ($query) use ($queryInput) {
        $query->where('employee_no', 'like', '%' . $queryInput . '%')
            ->orWhere('name', 'like', '%' . $queryInput . '%')
            ->orWhere('lastname', 'like', '%' . $queryInput . '%')
            ->orWhere('passport', 'like', '%' . $queryInput . '%')
            ->orWhere('hid', 'like', '%' . $queryInput . '%')
            ->orWhereHas('user_position', function ($query) use ($queryInput) {
                $query->where('name', 'like', '%' . $queryInput . '%');
            })
            ->orWhereHas('ethnicity', function ($query) use ($queryInput) {
                $query->where('name', 'like', '%' . $queryInput . '%');
            })
            ->orWhereHas('nationality', function ($query) use ($queryInput) {
                $query->where('name', 'like', '%' . $queryInput . '%');
            });
        })->get();

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
                    $data['Prefix'] = $employee->prefix->name;
                } elseif ($field === 'nationality') {
                    $data['Nationality'] = $employee->nationality->name;
                } elseif ($field === 'ethnicity') {
                    $data['Ethnicity'] = $employee->ethnicity->name;
                } elseif ($field === 'user_position') {
                    $data['UserPosition'] = $employee->user_position->name;
                } elseif ($field === 'employee_type') {
                    $data['EmployeeType'] = $employee->employee_type->name;
                } elseif ($field === 'company_department') {
                    $data['CompanyDepartment'] = $employee->company_department->name;
                } elseif ($field === 'employee_no') {
                    $data['EmployeeNo'] = "\t" . $employee->employee_no;
                } elseif ($field === 'name') {
                    $data['Name'] = $employee->name;
                } elseif ($field === 'lastname') {
                    $data['Lastname'] = $employee->lastname;
                } elseif ($field === 'address') {
                    $data['Address'] = $employee->address;
                } elseif ($field === 'phone') {
                    $data['Phone'] = "\t" . $employee->phone;
                } elseif ($field === 'hid') {
                    $data['Hid'] = "\t" .$employee->hid;
                } elseif ($field === 'passport') {
                    $data['Passport'] = $employee->passport;
                } elseif ($field === 'work_permit') {
                    $data['WorkPermit'] = "\t" . $employee->work_permit;
                } elseif ($field === 'start_work_date') {
                    $data['StartWorkDate'] = "\t" .$employee->start_work_date;
                } elseif ($field === 'birth_date') {
                    $data['BirthDate'] = "\t" .$employee->birth_date;
                } elseif ($field === 'visa_expiry_date') {
                    $data['VisaExpiryDate'] = "\t" .$employee->visa_expiry_date;
                } elseif ($field === 'permit_expiry_date') {
                    $data['PermitExpiryDate'] = "\t" .$employee->permit_expiry_date;
                // } elseif ($field === 'education_level') {
                //     $data['EducationLevel'] = $employee->education_level;
                // } elseif ($field === 'education_branch') {
                //     $data['EducationBranch'] = $employee->education_branch;
                } elseif ($field === 'bank') {
                    $data['Bank'] = $employee->bank;
                } elseif ($field === 'bank_account') {
                    $data['BankAccount'] = "\t" . $employee->bank_account;
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