<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssessmentCriteriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('assessment_criterias')->insert([
            [
                'name' => 'ปริมาณงาน',
                'description' => 'พิจารณาถึงจำนวนผลงานที่ทำได้สำเร็จเปรียบเทียบกับปริมาณงานที่กำหนด หรือปริมาณงานที่ควรจะได้ในเวลาที่ควรจะเป็น',
            ],
            [
                'name' => 'คุณภาพของงาน',
                'description' => 'พิจารณาถึงความถูกต้อง ครบถ้วน ความรวดเร็วและความประณีตเรียบร้อยของผลงานที่สำเร็จ เปรียบเทียบกับมาตรฐานที่กำหนด',
            ],
            [
                'name' => 'ความรู้เกี่ยวกับงานและความสามารถในการเรียนรู้งาน',
                'description' => 'พิจารณาถึงความรู้ ความเข้าใจ วิธีปฏิบัติงานในหน้าที่และเรื่องที่เกี่ยวข้องกับงาน รวมทั้งความสามารถในการเรียนรู้งาน',
            ],
            [
                'name' => 'ความเชื่อถือไว้วางใจ/ความเอาใจใส่งาน',
                'description' => 'พิจารณาถึงการทำงาน ละเอียดรอบคอบ ความตั้งใจ อุตสาหะ กระตือรือร้นในการทำงาน ผลงานเป็นที่เชื่อถือได้โดยผู้บังคับบัญชาไม่ต้องคอยดูแลอย่างใกล้ชิด',
            ],
            [
                'name' => 'ความสามารถในการใช้วัสดุอุปกรณ์',
                'description' => 'พิจารณาถึงความรู้ความสามารถและความชำนาญในการใช้วัสดุอุปกรณ์หรือเครื่องมือที่เกี่ยวข้องกับการปฏิบัติงาน ตลอดจนรู้จักระมัดระวังและคำนึงถึงความปลอดภัยในการใช้งาน',
            ],
            [
                'name' => 'การคำนึงถึงการใช้ทรัพยากรในบริษัท',
                'description' => 'พิจารณาถึงการประหยัดในการใช้วัสดุอุปกรณ์ในการทำงาน ตลอดจนการจัดเก็บ การดูแลรักษาวัสดุปกรณ์เครื่องมือเครื่องใช้ การประหยัดน้ำ-ไฟฟ้าของบริษัท',
            ],
            [
                'name' => 'การมาทำงานและการตรงต่อเวลา',
                'description' => 'พิจารณาถึงความสม่ำเสมอในการมาทำงานและการตรงต่อเวลา',
            ],
            [
                'name' => 'ความรับผิดชอบ',
                'description' => 'พิจารณาถึงความขยันหมั่นเพียร ความสนใจเอาใจใส่ต่องานรวมทั้งปฎิบัติงานและติดตามงานจนเป็นผลสำเร็จตรวตามเวลาที่กำหนด',
            ],
            [
                'name' => 'การปฏิบัติตามคำสั่งและคำแนะนำของผู้บังคับบัญชา',
                'description' => 'พิจารณาถึงความตั้งใจ ความกระตือรือร้น ความเต็มใจในการปฏิบัติตามคำสั่ง คำแนะนำ รวมทั้งความสามารถในการเข้าใจคำสั่ง คำแนะนำนั้น ๆ',
            ],
            [
                'name' => 'การประพฤติตนตามระเบียบวินัย',
                'description' => 'พิจารณาถึงการปฏิบัติตามระเบียบข้อบังคับของบริษัทฯ และการประพฤติตนเป็นตัวอย่างที่ดีแก่เพื่อนร่วมงาน',
            ],
            [
                'name' => 'ความคิดริเริ่มสร้างสรรค์',
                'description' => 'พิจารณาถึงความสามารถในการคิดปรับปรุงงานให้สำเร็จได้อย่างรวมเร็ว และมีประสิทธิภาพยิ่งขึ้นกว่าที่เป็นอยู่เดิม ความคิดเห็นและข้อเสนอแนะต่างๆเป็นไปอย่างสร้างสรรค์ สามารถนำไปปฏิบัติให้เกิดประโยชน์ต่อบริษัทฯได้',
            ],
            [
                'name' => 'มนุษย์สัมพันธ์',
                'description' => 'พิจารณาถึง ความสัมพันธ์อันดีกับผู้อื่น และความสามารถเข้ากับเพื่อนร่วมงาน ผู้บังคับบัญชา/ผู้ใต้บังคับบัญชาเป็นอย่างดี ตลอดจนความมีน้ำใจเอื้อเฟื้อเผื่อแผ่ เสียสละและช่วยเหลือผู้อื่นด้วยความเต็มใจ',
            ],
            [
                'name' => 'การให้ความร่วมมือและการประสานงาน',
                'description' => 'พิจารณาถึงการให้ความร่วมมือและการประสานงานกับบุคคลอื่นทุกระดับที่เกี่ยวข้องเพื่อให้การปฏิบัติงานบรรลุผลสำเร็จตามเป้าหมาย ',
            ],
            [
                'name' => 'ทักษะในการสื่อสาร',
                'description' => 'พิจารณาถึงความรู้ความสามารถในการติดต่อ การถ่ายทอดความคิด - ข่าวสาร ให้ผู้อื่นรับทราบ และความสามารถในการชี้แจงเรื่องต่างๆ ให้บุคคลทั่วไปเกิดความเข้าใจง่ายและเข้าใจตรงกัน',
            ],
            [
                'name' => 'ความซื่อสัตย์สุจริตและรักองค์กร',
                'description' => 'พิจารณาถึงความซื่อตรงซื่อสัตย์ต่องาน/เพื่อนร่วมงานและองค์กร ตลอดจนการปกป้องเกียรติภูมิของบริษัทฯ',
            ],
            [
                'name' => 'การวางแผนและการจัดระบบงาน',
                'description' => 'พิจารณาถึงความสามารถในการคาดการณ์ และการกำหนดตัวงานได้อย่างถูกต้องเหมาะสมและเป็นไปตามเป้าหมาย รวมทั้งสามารถวางระบบการทำงานได้อย่างสอดคล้องและได้ผลดี',
            ],
            [
                'name' => 'ความสามารถในการแก้ปัญหาและการตัดสินใจ',
                'description' => 'พิจารณาถึงความสามารถในการวิเคราะห์ปัญหาและการตัดสินใจอย่างรอบคอบในงานที่รับผิดชอบอย่างถูกต้อง ทันเหตุการณ์โดยไม่มีปัญหาติดตามมาภายหลัง',
            ],
            [
                'name' => ' พัฒนาตนเอง',
                'description' => 'พิจารณาถึงการรู้จักฝึกฝนหาความรู้ความชำนาญในงานที่รับผิดชอบเพิ่มขึ้นอยู่เสมอและสามารถเห็นผลที่เกิดการฝึกฝนตนเองได้ ',
            ],
            [
                'name' => 'การมอบหมายงาน',
                'description' => 'พิจารณาถึงความสามารถในการมอบหมายงานตามความรู้ ความสามารถ ทักษะและประสบการณ์ของผู้ใต้บังคับบัญชาได้อย่างเหมาะสมทั่วถึงและเป็นธรรม',
            ],
            [
                'name' => 'การควบคุมงาน',
                'description' => 'พิจารณาถึงความสามารถในการติดตามควบคุมการปฏิบัติงานของผู้ใต้บังคับบัญชาให้ได้ผลตามเป้าหมายที่วางไว้',
            ],
            [
                'name' => 'ความเป็นผู้นำและทักษะในการบังคับบัญชา',
                'description' => 'พิจารณาถึงความสามารถในการวางตน การปกครองและการโน้มน้าวให้ผู้ใต้บังคับบัญชา ตั้งใจ/เต็มใจร่วมมือกันเพื่อปฏิบัติงานตามที่ต้องการ',
            ],
            [
                'name' => 'การสร้างขวัญและกำลังใจ',
                'description' => 'พิจารณาถึงการให้ความสนใจการดูแลเอาใจใส่ผู้ใต้บังคับบัญชาและมีความสามัคคี',
            ],
            [
                'name' => 'การพัฒนาผู้ใต้บังคับบัญชา',
                'description' => 'พิจารณาถึงความสามารถในการถ่ายทอดความรู้/ประสบการณ์แก่ผู้ใต้บังคับบัญชา ตลอดจนการกระตุ้นและดำเนินการให้ผู้ใต้บังคับบัญชา เพิ่มสมรรถภาพในการปฏิบัติงาน เพิ่มความรับผิดชอบมากขึ้น',
            ]
        ]);
    }
}