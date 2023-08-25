<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Prefix;
use App\Models\Ethnicity;
use App\Models\Nationality;
use App\Models\EmployeeType;
use App\Models\UserPosition;
use Illuminate\Validation\Rule;
use App\Models\CompanyDepartment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\UserDiligenceAllowance;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToCollection, WithHeadingRow
{
    private $successCount = 0;
    private $errorCount = 0;
    private $errorRows = [];
    private $errorMessages = [];

    public function collection(Collection $rows)
    {
        // ตรวจสอบส่วนหัวของไฟล์
        $requiredHeaders = ['code','department','prefix','name','lastname','nationality','ethnicity','address','province','amphur','tambol','phone','birth','position','employee_type','hid','work_permit','passport','visa_expire','work_permitted_expire','start_work_date','tax','bank_account','bank'];
        $fileHeaders = $rows->first();
        // dd($rows);
        if (!$fileHeaders || !$this->validateHeaders($fileHeaders, $requiredHeaders)) {
            // จัดการกรณีที่ไฟล์ไม่มีส่วนหัวที่จำเป็น
            $this->errorCount++;
            $this->errorMessages[] = 'รูปแบบไฟล์ไม่ถูกต้อง';
            return;
        }

        // ดำเนินการตรวจสอบข้อมูล
        foreach ($rows as $index => $row) {
            if ($row->filter(function ($value) {
                return $value !== null && $value !== '';
            })->isEmpty()) {
                continue; // ข้ามการทำซ้ำถ้าแถวว่างเปล่า
            }
            $validator = Validator::make($row->toArray(), [
                'code' => 'required',
                'department' => [
                    'required',
                    Rule::exists(CompanyDepartment::class, 'name')
                ],
                'prefix' => [
                    'required',
                    Rule::exists(Prefix::class, 'name')
                ],
                'name' => 'required',
                // 'lastname' => 'required',
                'nationality' => [
                    'required',
                    Rule::exists(Nationality::class, 'name')
                ],
                'ethnicity' => [
                    'required',
                    Rule::exists(Ethnicity::class, 'name')
                ],
                'address' => 'required',
                'province' => 'required',
                'amphur' => 'required',
                'tambol' => 'required',
                'position' => [
                    'required',
                    Rule::exists(UserPosition::class, 'name')
                ],
                'employee_type' => [
                    'required',
                    Rule::exists(EmployeeType::class, 'name')
                ],
                'start_work_date' => 'required',
                
                // ใส่กฎการตรวจสอบเพิ่มเติมสำหรับคอลัมน์อื่น ๆ ตามต้องการ
            ]);
            
            if ($validator->fails()) {
                $this->errorCount++;
                $this->errorRows[] = $row;
                $this->errorMessages[] = $validator->errors()->first();
            } else {
                $this->successCount++;
            }
        }

        if ($this->errorCount === 0) {
            // บันทึกแถวที่ถูกต้องลงในโมเดล
            $users = [];
         
            foreach ($rows as $row) {
                if ($row->filter(function ($value) {
                    return $value !== null && $value !== '';
                })->isEmpty()) {
                    continue;
                }

                $row = $row->map(function ($value) {
                    return $value === '-' ? null : $value;
                });

                $employeeNo = $row['code'];
                $companyDepartmentName = $row['department'];
                $prefixName = $row['prefix'];
                $nationalityName = $row['nationality'];
                $ethnicityName = $row['ethnicity'];
                $positionName = $row['position'];
                $employeeTypeName = $row['employee_type'];

                $companyDepartmentId = CompanyDepartment::where('name', $companyDepartmentName)->value('id');
                $prefixId = Prefix::where('name', $prefixName)->value('id');
                $nationalityId = Nationality::where('name', $nationalityName)->value('id');
                $ethnicityId = Ethnicity::where('name', $ethnicityName)->value('id');
                $positionId = UserPosition::where('name', $positionName)->value('id');
                $employeeTypeId = EmployeeType::where('name', $employeeTypeName)->value('id');
                $address = $row['address'] . ' ตำบล' . $row['tambol'] . ' อำเภอ' . $row['amphur'] . ' จังหวัด' . $row['province'] ;
                $visaExpire = $row['visa_expire'] != '' ? Carbon::createFromTimestamp((($row['visa_expire'] - 25569) * 86400))->format('Y-m-d') : null;
                $workPermittedExpire = $row['work_permitted_expire'] != '' ? Carbon::createFromTimestamp((($row['work_permitted_expire'] - 25569) * 86400))->format('Y-m-d') : null;
                $startWorkDate = $row['start_work_date'] != '' ? Carbon::createFromTimestamp((($row['start_work_date'] - 25569) * 86400))->format('Y-m-d') : null;

                $user = User::where('employee_no', $employeeNo)->first();
                if (!$user) {
                    $user = [
                        'prefix_id' => $prefixId,
                        'nationality_id' => $nationalityId,
                        'ethnicity_id' => $ethnicityId,
                        'user_position_id' => $positionId,
                        'employee_type_id' => $employeeTypeId,
                        'company_department_id' => $companyDepartmentId,
                        'employee_no' => $employeeNo,
                        'name' => $row['name'],
                        'lastname' => $row['lastname'] ?? null,
                        'address' => $address,
                        'phone' => $row['phone'] ?? null,
                        'hid' => $row['hid'] ?? null,
                        'passport' => $row['passport'] ?? null,
                        'work_permit' => $row['work_permit'] ?? null,
                        'birth_date' => Carbon::createFromTimestamp((($row['birth'] - 25569) * 86400))->format('Y-m-d'),
                        'visa_expiry_date' => $visaExpire,
                        'permit_expiry_date' => $workPermittedExpire,
                        'start_work_date' => $startWorkDate,
                        // 'education_level' => $row['education_level'] ?? null,
                        // 'education_branch' => $row['education_branch'] ?? null,
                        'tax' => $row['tax'] ?? null,
                        'bank_account' => $row['bank_account'] ?? null,
                        'bank' => $row['bank'] ?? null,
                        'email' => $employeeNo . '@cif.com',
                        'password' => bcrypt('11111111'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    

                    // Add the user record to the array
                    $users[] = $user;
                }
            }
            DB::table('users')->insert($users);
            foreach (User::all() as $user) {
                UserDiligenceAllowance::create([
                    'user_id' => $user->id,
                    'level' => 1,
                    'diligence_allowance_id' => 1,
                ]);
            }
        }
    }


    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }

    public function getErrorRows()
    {
        return $this->errorRows;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    // ฟังก์ชันสำหรับตรวจสอบส่วนหัว
    private function validateHeaders($headers, $requiredHeaders)
    {
        $fileHeaders = $headers->keys()->toArray();
        sort($fileHeaders);
        sort($requiredHeaders);
        return $fileHeaders === $requiredHeaders;
    }

}
