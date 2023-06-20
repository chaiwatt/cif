<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanyDepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultCompanyDepatments();
    }
     public function createDefaultCompanyDepatments()
    {
        $departments = [
            [
                'name' => 'วิศวกรรม',
                'eng_name' => 'Engineering',
                'code' => 'ENG'
            ],
            [
                'name' => 'เทคนิค',
                'eng_name' => 'Technical',
                'code' => 'TD'
            ],
            [
                'name' => 'ธุรการ',
                'eng_name' => 'Administrative',
                'code' => 'AD'
            ],
            [
                'name' => 'บัญชี',
                'eng_name' => 'Account',
                'code' => 'ACC'
            ],
            [
                'name' => 'บุคคล',
                'eng_name' => 'Personal',
                'code' => 'PS'
            ],
            [
                'name' => 'ควบคุมคุณภาพ',
                'eng_name' => 'Quality Control',
                'code' => 'QC'
            ],
            [
                'name' => 'โรงงานอาหารสุก',
                'eng_name' => 'Production cooked Plant',
                'code' => 'PDC'
            ],
            [
                'name' => 'วิจัยและพัฒนาผลิตภัณฑ์',
                'eng_name' => 'Research and Development',
                'code' => 'RD'
            ],
            [
                'name' => 'จัดซื้อ',
                'eng_name' => 'Purchase',
                'code' => 'PC'
            ],
            [
                'name' => 'คลังสินค้า',
                'eng_name' => 'Warehouse',
                'code' => 'WH'
            ],
            [
                'name' => 'ส่งออก',
                'eng_name' => 'Export',
                'code' => 'EX'
            ],
            [
                'name' => 'ความปลอดภัยอาชีวอนามัยและสภาพแวดล้อมในการทำงาน',
                'eng_name' => 'Health and Safety',
                'code' => 'HS'
            ],
            [
                'name' => 'โรงงานแปรรูป(ผลิตดิบ)',
                'eng_name' => 'Production Raw  Plant',
                'code' => 'PDR'
            ],
            [
                'name' => 'อนามัย',
                'eng_name' => 'Sanitation',
                'code' => 'CS'
            ],
            [
                'name' => 'สิ่งแวดล้อม',
                'eng_name' => 'Environment',
                'code' => 'ENV'
            ],
            [
                'name' => 'การตลาด',
                'eng_name' => 'Marketing',
                'code' => 'MK'
            ],
            [
                'name' => 'บริหาร',
                'eng_name' => 'Management',
                'code' => 'MG'
            ],
        ];

        foreach ($departments as $department) {
            $companyDepartment = new CompanyDepartment();
            $companyDepartment->name = $department['name'];
            $companyDepartment->eng_name = $department['eng_name'];
            $companyDepartment->code = $department['code'];
            $companyDepartment->save();
        }
    }
}
