<?php

namespace App\Http\Controllers\Settings;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SettingAccessRoleController extends Controller
{
    /**
     * แสดงหน้าสำหรับแสดงรายการบทบาททั้งหมด
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // ดึงข้อมูลรายการบทบาททั้งหมด
        $roles = Role::all();

        // ส่งข้อมูลรายการบทบาทไปยังหน้าวิวเพื่อแสดงผล
        return view('dashboard.access.role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * แสดงหน้าสำหรับสร้างบทบาทใหม่
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // แสดงหน้าสร้างบทบาท
        return view('dashboard.access.role.create');
    }

    /**
     * เก็บข้อมูลบทบาทที่สร้างขึ้นใหม่ในฐานข้อมูล
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            // หากการตรวจสอบไม่ผ่าน ให้เปลี่ยนเส้นทางกลับไปที่หน้าฟอร์มพร้อมกับแสดงข้อผิดพลาดที่ตรวจพบและข้อมูลที่กรอกไว้ก่อนหน้า
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ดึงชื่อบทบาทจากคำขอ
        $name = $request->name;

        // สร้างอินสแตนซ์ของคลาส Role
        $role = new Role();
        $role->name = $name;
        $role->save();

        // เปลี่ยนเส้นทางไปยังหน้ารายการบทบาทพร้อมกับข้อความสำเร็จ
        return redirect()->route('setting.access.role.index')->with('message', 'นำเข้าข้อมูลเรียบร้อยแล้ว');
    }


    /**
     * แสดงรายละเอียดของบทบาท
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        // ค้นหาบทบาทโดยใช้รหัสบทบาท
        $role = Role::findOrFail($id);
        return view('dashboard.access.role.view', [
            'role' => $role
        ]);
    }

    /**
     * อัปเดตข้อมูลบทบาท
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = $this->validateFormData($request);

        if ($validator->fails()) {
            // หากการตรวจสอบไม่ผ่าน ให้เปลี่ยนเส้นทางกลับไปที่หน้าฟอร์มพร้อมกับแสดงข้อผิดพลาดที่ตรวจพบและข้อมูลที่กรอกไว้ก่อนหน้า
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ค้นหาบทบาทที่ต้องการอัปเดตโดยใช้รหัสบทบาท
        $role = Role::findOrFail($id);

        // อัปเดตข้อมูลบทบาท
        $role->update($validator->validated());

        // เปลี่ยนเส้นทางไปยังหน้ารายการบทบาทพร้อมกับข้อความสำเร็จ
        return redirect()->route('setting.access.role.index')->with('success', 'อัปเดต Role เรียบร้อยแล้ว');
    }

    /**
     * ลบบทบาท
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        // ค้นหาบทบาทที่ต้องการลบโดยใช้รหัสบทบาท
        $role = Role::findOrFail($id);

        if ($role->users()->exists()) {
            // หากมีผู้ใช้งานที่ใช้บทบาทนี้อยู่ ไม่สามารถลบได้
            return response()->json(['error' => 'Role นี้ถูกใช้งานอยู่ในปัจจุบันและไม่สามารถลบได้'], 422);
        }

        // ลบบทบาท
        $role->delete();

        // ส่งคำตอบเป็น JSON แสดงว่าลบบทบาทเรียบร้อยแล้ว
        return response()->json(['message' => 'Role ได้ถูกลบออกเรียบร้อยแล้ว']);
    }

    /**
     * ตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateFormData($request)
    {
        // สร้างตัวตรวจสอบความถูกต้องของข้อมูลในฟอร์ม
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        // ส่งกลับตัวตรวจสอบ
        return $validator;
    }

}
