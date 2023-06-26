<?php

namespace App\Http\Controllers\Settings;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SettingGeneralCompanyDepartmentController extends Controller
{
    private $activityLogger;

    public function __construct(ActivityLogger $activityLogger)
    {
        $this->activityLogger = $activityLogger;
    }
    /**
     * แสดงรายการแผนกของบริษัททั้งหมด
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ดึงข้อมูลแผนกของบริษัททั้งหมดจากฐานข้อมูล
        $companyDepartments = CompanyDepartment::all();

        // ส่งข้อมูลแผนกไปยังวิวเพื่อแสดงผล
        return view('dashboard.general.companydepartment.index', [
            'companyDepartments' => $companyDepartments
        ]);
    }

    /**
     * แสดงแบบฟอร์มสร้างแผนกใหม่
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ส่งวิวสำหรับสร้างแผนกใหม่
        return view('dashboard.general.companydepartment.create');
    }

    /**
     * แสดงข้อมูลแผนกที่ระบุ
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        // ค้นหาแผนกโดยใช้รหัสแผนก
        $companyDepartment = CompanyDepartment::findOrFail($id);

        // ส่งข้อมูลแผนกไปยังวิวเพื่อแสดงผล
        return view('dashboard.general.companydepartment.view', [
            'companyDepartment' => $companyDepartment
        ]);
    }

    /**
     * เก็บข้อมูลแผนกใหม่ลงในฐานข้อมูล
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            // ในกรณีที่ข้อมูลไม่ถูกต้อง กลับไปยังหน้าก่อนหน้าพร้อมแสดงข้อผิดพลาดและข้อมูลที่กรอก
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงข้อมูลจากแบบฟอร์ม
        $name = $request->name;
        $code = $request->code ?? null;
        $description = $request->description ?? null;

        // สร้างแผนกใหม่
        $companyDepartment = new CompanyDepartment();
        $companyDepartment->name = $name;
        $companyDepartment->code = $code;
        $companyDepartment->description = $description;
        $companyDepartment->save();

        $this->activityLogger->log('เพิ่ม', $companyDepartment);

        // ส่ง redirect ไปยังหน้าแสดงรายการแผนกพร้อมกับข้อความแจ้งเตือน
        return redirect()->route('setting.general.companydepartment.index', [
            'message' => 'นำเข้าข้อมูลเรียบร้อยแล้ว'
        ]);
    }

    /**
     * อัปเดตข้อมูลแผนกที่ระบุในฐานข้อมูล
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            // ในกรณีที่ข้อมูลไม่ถูกต้อง กลับไปยังหน้าก่อนหน้าพร้อมแสดงข้อผิดพลาดและข้อมูลที่กรอก
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ค้นหาแผนกที่ต้องการอัปเดตโดยใช้รหัสแผนก
        $companyDepartment = CompanyDepartment::findOrFail($id);

        $this->activityLogger->log('อัปเดต', $companyDepartment);

        // อัปเดตข้อมูลแผนกด้วยข้อมูลที่ผ่านการตรวจสอบแล้ว
        $companyDepartment->update($validator->validated());

        // ส่ง redirect ไปยังหน้าแสดงรายการแผนกพร้อมกับข้อความแจ้งเตือน
        return redirect()->route('setting.general.companydepartment.index', [
            'success' => 'อัปเดตแผนกบริษัทเรียบร้อยแล้ว'
        ]);
    }

    /**
     * ลบแผนกที่ระบุจากฐานข้อมูล
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        // Find the company department by its ID
        $companyDepartment = CompanyDepartment::findOrFail($id);

        // Check if the department is in use by any user
        $usersWithDepartment = User::where('company_department_id', $id)->exists();
        if ($usersWithDepartment) {
            // Return an error response indicating that the department is in use
            return response()->json(['error' => 'แผนกนี้ถูกใช้งานอยู่ในปัจจุบันและไม่สามารถลบได้'], 422);
        }

        $this->activityLogger->log('ลบ', $companyDepartment);
        // Perform the deletion
        $companyDepartment->delete();

        // Return a response indicating the success of the deletion
        return response()->json(['message' => 'แผนกได้ถูกลบออกเรียบร้อยแล้ว']);
    }


    /**
     * ตรวจสอบความถูกต้องของข้อมูลแบบฟอร์ม
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateFormData($request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'eng_name' => 'nullable|max:255',
            'code' => 'nullable'
        ]);

        // ส่งกลับตัว validator
        return $validator;
    }
}
