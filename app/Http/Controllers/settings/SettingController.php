<?php

namespace App\Http\Controllers\Settings;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use App\Services\AccessGroupService;

class SettingController extends Controller
{
    /**
     * แสดงหน้าดูข้อมูลระบบ
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // ดึงข้อมูลแผนกของบริษัททั้งหมด
        $companyDepartments = CompanyDepartment::all();

        $colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de','#3c8dbc','#00c0ef','#f39c12','#f56954','#f56954','#39CCCC','#605ca8','#D81B60','#2ab7ca','#f6abb6','#011f4b','#851e3e'];

        // สร้างข้อมูลสำหรับแสดงกราฟดวงกลมจำนวนพนักงานในแต่ละแผนก
        $employeeDatapackages = [];
        foreach ($companyDepartments as $index => $companyDepartment) {
            $employeeDatapackages[] = [
                'label' => $companyDepartment->name,
                'value' => $companyDepartment->users_belong->count(),
                'color' => $colors[$index % count($colors)],
            ];
        }

        $employeeDonutData = [
            'labels' => array_column($employeeDatapackages, 'label'),
            'datasets' => [
                [
                    'data' => array_column($employeeDatapackages, 'value'),
                    'backgroundColor' => array_column($employeeDatapackages, 'color')
                ]
            ]
        ];

        // ดึงข้อมูลบทบาททั้งหมด
        $roles = Role::all();
        $roleDatapackages = [];
        foreach ($roles as $index => $role) {
            $roleDatapackages[] = [
                'label' => $role->name,
                'value' => $role->users->count(),
                'color' => $colors[$index % count($colors)],
            ];
        }

        $roleDonutData = [
            'labels' => array_column($roleDatapackages, 'label'),
            'datasets' => [
                [
                    'data' => array_column($roleDatapackages, 'value'),
                    'backgroundColor' => array_column($roleDatapackages, 'color')
                ]
            ]
        ];

        // แบ่งหน้าแสดงผลข้อมูลแผนกบริษัท
        $companyDepartments = CompanyDepartment::paginate(7);

        $users = User::all();
        // ส่งข้อมูลไปยังหน้าแสดงผล
        return view('dashboard.system.index', [
            'companyDepartments' => $companyDepartments,
            'employeeDonutData' => $employeeDonutData,
            'roleDonutData' => $roleDonutData,
            'roles' => $roles,
            'users' => $users
        ]);
    }

}
