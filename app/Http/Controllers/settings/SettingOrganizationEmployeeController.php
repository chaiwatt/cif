<?php

namespace App\Http\Controllers\Settings;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Prefix;
use App\Models\Ethnicity;
use App\Models\Nationality;
use App\Models\SearchField;
use App\Models\EmployeeType;
use App\Models\UserPosition;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use Illuminate\Validation\Rule;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\UserDiligenceAllowance;

class SettingOrganizationEmployeeController extends Controller
{
    private $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->activityLogger = $activityLogger;
    }
    public function index()
    {
        $users = User::paginate(20);
        return view('setting.organization.employee.index',[
            'users' => $users
        ]);
    }

    public function create()
    {
        $prefixes = Prefix::all();  // เรียกข้อมูลคำนำหน้าชื่อทั้งหมดจากตาราง prefixes
        $nationalities = Nationality::all();  // เรียกข้อมูลสัญชาติทั้งหมดจากตาราง nationalities
        $ethnicities = Ethnicity::all();  // เรียกข้อมูลเชื้อชาติทั้งหมดจากตาราง ethnicities
        $employeeTypes = EmployeeType::all();  // เรียกข้อมูลประเภทพนักงานทั้งหมดจากตาราง employee_types
        $userPositions = UserPosition::all();  // เรียกข้อมูลตำแหน่งงานทั้งหมดจากตาราง user_positions
        $companyDepartments = CompanyDepartment::all();  // เรียกข้อมูลแผนกบริษัททั้งหมดจากตาราง company_departments
        
        return view('setting.organization.employee.create',[
            'prefixes' => $prefixes,  // ส่งข้อมูลคำนำหน้าชื่อไปยังหน้าจอสร้างพนักงาน
            'nationalities' => $nationalities,  // ส่งข้อมูลสัญชาติไปยังหน้าจอสร้างพนักงาน
            'ethnicities' => $ethnicities,  // ส่งข้อมูลเชื้อชาติไปยังหน้าจอสร้างพนักงาน
            'employeeTypes' => $employeeTypes,  // ส่งข้อมูลประเภทพนักงานไปยังหน้าจอสร้างพนักงาน
            'userPositions' => $userPositions,  // ส่งข้อมูลตำแหน่งงานไปยังหน้าจอสร้างพนักงาน
            'companyDepartments' => $companyDepartments,  // ส่งข้อมูลแผนกบริษัทไปยังหน้าจอสร้างพนักงาน
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            // การตรวจสอบความถูกต้องล้มเหลว
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $prefix = $request->prefix;  // คำนำหน้าชื่อ
        $name = $request->name;  // ชื่อ
        $lastname = $request->lastname;  // นามสกุล
        $employeeNo = $request->employee_code;  // รหัสพนักงาน
        $hid = preg_replace('/\s+/', '', $request->hid) ?? null;  // รหัส HID (ลบช่องว่าง)
        $nationality = $request->nationality;  // สัญชาติ
        $ethnicity = $request->ethnicity;  // เชื้อชาติ
        $birthDate = !is_null($request->birthDate) ? Carbon::createFromFormat('m/d/Y', $request->birthDate)->format('Y-m-d') : null;  // วันเกิด
        $address = $request->address;  // ที่อยู่
        $phone = preg_replace('/[^0-9]/', '', $request->phone) ?? null;  // เบอร์โทรศัพท์ (ลบช่องว่าง)
        // $educationLevel = $request->educationLevel ?? null;  // ระดับการศึกษา
        // $educationBranch = $request->educationBranch ?? null;  // สาขาวิชาที่ศึกษา
        $employeeType = $request->employeeType;  // ประเภทพนักงาน
        $userPosition = $request->userPosition;  // ตำแหน่งงาน
        $companyDepartment = $request->companyDepartment;  // แผนกบริษัท
        $startWorkDate = Carbon::createFromFormat('m/d/Y', $request->startWorkDate)->format('Y-m-d');  // วันที่เริ่มทำงาน
        $visaExpireDate = !is_null($request->visaExpireDate) ? Carbon::createFromFormat('m/d/Y', $request->visaExpireDate)->format('Y-m-d') : null;  // วันหมดอายุวีซ่า
        $workPermitExpireDate = !is_null($request->workPermitExpireDate) ? Carbon::createFromFormat('m/d/Y', $request->workPermitExpireDate)->format('Y-m-d') : null;  // วันหมดอายุใบอนุญาตทำงาน   
        $bank = $request->bank;  // ธนาคาร
        $bankAccount = $request->bankAccount;  // เลขที่บัญชีธนาคาร
        $passport = $request->passport ?? null;  // พาสพอร์ต
        $workPermit = $request->work_permit ?? null;  // เลขที่ใบอนุญาตทำงาน
        $tax = $request->tax ?? null;  // เลขประจำตัวผู้เสียภาษีอากร
        $timeRecordRequire = $request->timeRecordRequire;

        $user = new User();
        $user->prefix_id = $prefix;  // กำหนดค่าคำนำหน้าชื่อให้กับคอลัมน์ prefix_id
        $user->nationality_id = $nationality;  // กำหนดค่าสัญชาติให้กับคอลัมน์ nationality_id
        $user->ethnicity_id = $ethnicity;  // กำหนดค่าเชื้อชาติให้กับคอลัมน์ ethnicity_id
        $user->user_position_id = $userPosition;  // กำหนดค่าตำแหน่งงานให้กับคอลัมน์ user_position_id
        $user->employee_type_id = $employeeType;  // กำหนดค่าประเภทพนักงานให้กับคอลัมน์ employee_type_id
        $user->company_department_id = $companyDepartment;  // กำหนดค่าแผนกบริษัทให้กับคอลัมน์ company_department_id
        $user->employee_no = $employeeNo;  // กำหนดค่ารหัสพนักงานให้กับคอลัมน์ employee_no
        $user->name = $name;  // กำหนดค่าชื่อให้กับคอลัมน์ name
        $user->lastname = $lastname;  // กำหนดค่านามสกุลให้กับคอลัมน์ lastname
        $user->address = $address;  // กำหนดค่าที่อยู่ให้กับคอลัมน์ address
        $user->phone = $phone;  // กำหนดค่าเบอร์โทรศัพท์ให้กับคอลัมน์ phone
        $user->hid = $hid;  // กำหนดค่ารหัส HID ให้กับคอลัมน์ hid
        $user->passport = null;  // กำหนดค่า null ให้กับคอลัมน์ passport
        $user->birth_date = $birthDate;  // กำหนดค่าวันเกิดให้กับคอลัมน์ birth_date
        $user->visa_expiry_date = $visaExpireDate;  // กำหนดค่าวันหมดอายุวีซ่าให้กับคอลัมน์ visa_expiry_date
        $user->permit_expiry_date = $workPermitExpireDate;  // กำหนดค่าวันหมดอายุใบอนุญาตทำงานให้กับคอลัมน์ permit_expiry_date
        $user->start_work_date = $startWorkDate;  // กำหนดค่าวันที่เริ่มทำงานให้กับคอลัมน์ start_work_date
        $user->bank = $bank;  // กำหนดค่าธนาคารให้กับคอลัมน์ bank
        $user->bank_account = $bankAccount;  // กำหนดค่าเลขที่บัญชีธนาคารให้กับคอลัมน์ bank_account
        // $user->education_level = $educationLevel;  // กำหนดค่าระดับการศึกษาให้กับคอลัมน์ education_level
        // $user->education_branch = $educationBranch;  // กำหนดค่าสาขาวิชาที่ศึกษาให้กับคอลัมน์ education_branch
        $user->email = $employeeNo . '@cif.com';  // กำหนดค่าอีเมลให้กับคอลัมน์ email (รหัสพนักงาน@cif.com)
        $user->password = bcrypt('11111111');  // กำหนดค่ารหัสผ่านให้กับคอลัมน์ password (เข้ารหัสแบบ bcrypt)
        $user->passport = $passport;  
        $user->work_permit = $workPermit;  
        $user->tax = $tax;  
        $user->time_record_require = $timeRecordRequire; 
        
        $user->save();  // บันทึกข้อมูลในฐานข้อมูล

        UserDiligenceAllowance::create([
                'user_id' => $user->id,
                'level' => 1,
                'diligence_allowance_id' => 1,
            ]);

        $this->activityLogger->log('เพิ่ม', $user);

        return redirect()->route('setting.organization.employee.index', [
            'message' => 'นำเข้าข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    public function view($id)
    {
        $user = User::find($id);
        $prefixes = Prefix::all();  // เรียกข้อมูลคำนำหน้าชื่อทั้งหมดจากตาราง prefixes
        $nationalities = Nationality::all();  // เรียกข้อมูลสัญชาติทั้งหมดจากตาราง nationalities
        $ethnicities = Ethnicity::all();  // เรียกข้อมูลเชื้อชาติทั้งหมดจากตาราง ethnicities
        $employeeTypes = EmployeeType::all();  // เรียกข้อมูลประเภทพนักงานทั้งหมดจากตาราง employee_types
        $userPositions = UserPosition::all();  // เรียกข้อมูลตำแหน่งงานทั้งหมดจากตาราง user_positions
        $companyDepartments = CompanyDepartment::all();  // เรียกข้อมูลแผนกบริษัททั้งหมดจากตาราง company_departments

        return view('setting.organization.employee.view',[
            'user' => $user, // ส่งข้อมูล user
            'prefixes' => $prefixes,  // ส่งข้อมูลคำนำหน้าชื่อไปยังหน้าจอสร้างพนักงาน
            'nationalities' => $nationalities,  // ส่งข้อมูลสัญชาติไปยังหน้าจอสร้างพนักงาน
            'ethnicities' => $ethnicities,  // ส่งข้อมูลเชื้อชาติไปยังหน้าจอสร้างพนักงาน
            'employeeTypes' => $employeeTypes,  // ส่งข้อมูลประเภทพนักงานไปยังหน้าจอสร้างพนักงาน
            'userPositions' => $userPositions,  // ส่งข้อมูลตำแหน่งงานไปยังหน้าจอสร้างพนักงาน
            'companyDepartments' => $companyDepartments,  // ส่งข้อมูลแผนกบริษัทไปยังหน้าจอสร้างพนักงาน
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $prefix = $request->prefix;  // คำนำหน้าชื่อ
        $name = $request->name;  // ชื่อ
        $lastname = $request->lastname;  // นามสกุล
        $employeeNo = $request->employee_code;  // รหัสพนักงาน
        $hid = preg_replace('/\s+/', '', $request->hid) ?? null;  // รหัส HID (ลบช่องว่าง)
        $nationality = $request->nationality;  // สัญชาติ
        $ethnicity = $request->ethnicity;  // เชื้อชาติ
        $birthDate = !is_null($request->birthDate) ? Carbon::createFromFormat('m/d/Y', $request->birthDate)->format('Y-m-d') : null;  // วันเกิด
        $address = $request->address;  // ที่อยู่
        $phone = preg_replace('/[^0-9]/', '', $request->phone) ?? null;  // เบอร์โทรศัพท์ (ลบช่องว่าง)
        // $educationLevel = $request->educationLevel ?? null;  // ระดับการศึกษา
        // $educationBranch = $request->educationBranch ?? null;  // สาขาวิชาที่ศึกษา
        $employeeType = $request->employeeType;  // ประเภทพนักงาน
        $userPosition = $request->userPosition;  // ตำแหน่งงาน
        $companyDepartment = $request->companyDepartment;  // แผนกบริษัท
        $startWorkDate = Carbon::createFromFormat('m/d/Y', $request->startWorkDate)->format('Y-m-d');  // วันที่เริ่มทำงาน
        $visaExpireDate = !is_null($request->visaExpireDate) ? Carbon::createFromFormat('m/d/Y', $request->visaExpireDate)->format('Y-m-d') : null;  // วันหมดอายุวีซ่า
        $workPermitExpireDate = !is_null($request->workPermitExpireDate) ? Carbon::createFromFormat('m/d/Y', $request->workPermitExpireDate)->format('Y-m-d') : null;  // วันหมดอายุใบอนุญาตทำงาน   
        $bank = $request->bank;  // ธนาคาร
        $bankAccount = $request->bankAccount;  // เลขที่บัญชีธนาคาร
        $passport = $request->passport ?? null;  // พาสพอร์ต
        $workPermit = $request->work_permit ?? null;  // เลขที่ใบอนุญาตทำงาน
        $tax = $request->tax ?? null;  // เลขประจำตัวผู้เสียภาษีอากร
        $timeRecordRequire = $request->timeRecordRequire;

        $user = User::findOrFail($id);

        $this->activityLogger->log('อัปเดต', $user);

        $user->update([
            'prefix_id' => $prefix,
            'nationality_id' => $nationality,
            'ethnicity_id' => $ethnicity,
            'user_position_id' => $userPosition,
            'employee_type_id' => $employeeType,
            'company_department_id' => $companyDepartment,
            'employee_no' => $employeeNo,
            'name' => $name,
            'lastname' => $lastname,
            'address' => $address,
            'phone' => $phone,
            'hid' => $hid,
            'start_work_date' => $startWorkDate,
            'birth_date' => $birthDate,
            'visa_expiry_date' => $visaExpireDate,
            'permit_expiry_date' => $workPermitExpireDate,
            // 'education_level' => $educationLevel,
            // 'education_branch' => $educationBranch,
            'bank' => $bank,
            'bank_account' => $bankAccount,
            'passport' => $passport,
            'work_permit' => $workPermit,
            'tax' => $tax,
            'time_record_require' => $timeRecordRequire,
        ]);

        return redirect()->route('setting.organization.employee.index', [
            'success' => 'อัปเดตพนักงานเรียบร้อยแล้ว'
        ]);
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);

        $this->activityLogger->log('ลบ', $user);

        $user->delete();

        return response()->json(['message' => 'ผู้ใช้งานได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    public function search(Request $request)
    {
        $queryInput = $request->data;
             
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
        return view('setting.organization.employee.table-render.employee-table',['users' => $users])->render();
    }

    function validateFormData($request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
                'employee_code' => 'required|numeric',
                'prefix' => [
                    'required',
                    Rule::exists(Prefix::class, 'id')
                ],
                'name' => 'required',
                'lastname' => 'required',
                'nationality' => [
                    'required',
                    Rule::exists(Nationality::class, 'id')
                ],
                'ethnicity' => [
                    'required',
                    Rule::exists(Ethnicity::class, 'id')
                ],
                'address' => 'required',
                'employeeType' => [
                    'required',
                    Rule::exists(EmployeeType::class, 'id')
                ],
                'userPosition' => [
                    'required',
                    Rule::exists(UserPosition::class, 'id')
                ],
                'companyDepartment' => [
                    'required',
                    Rule::exists(CompanyDepartment::class, 'id')
                ],
                'startWorkDate' => 'required|date',
                'visaExpireDate' => 'nullable|date|after_or_equal:today', // Add validation for visaExpireDate
                'workPermitExpireDate' => 'nullable|date|after_or_equal:today',
                'timeRecordRequire' => 'required',
            ]);
        return $validator;
    }
}
