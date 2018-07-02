<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Model\Appointment;
use App\Model\Event;
use App\Model\Patient;
use App\Model\Role;
use App\Model\Absent;
use App\Model\Staff;
use App\Model\Step;
use App\Model\TreatmentDetail;
use App\Model\TreatmentDetailStep;
use App\Model\TreatmentHistory;
use App\Model\TreatmentStep;
use App\Model\User;
use App\Model\UserHasRole;
use App\Model\Treatment;
use App\Model\RequestAbsent;
use App\Model\TreatmentCategory;
use App\Model\Tooth;
use App\Model\News;
use App\Model\Payment;
use App\Model\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    use UserBusinessFunction;
    use PatientBusinessFunction;

    //




    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    public function initStep(){

            Step::create([
                'name' => 'Khám và tư vấn',
                'description' => 'Bác sĩ sẽ khám tổng quát để đánh giá tình hình sức khỏe răng miệng cũng như tình hình trạng răng miệng của bệnh nhân.Sau đó, tư vấn phương pháp điều trị cụ thể.',

            ]);

    }
    public function initData()
    {
        DB::beginTransaction();
        try {
            User::create([
                'phone' => '01279011096',
                'password' => Hash::make('#2017#'),
            ]);
            UserHasRole::create([
                'phone' => '01279011096',
                'role_id' => 1,
                'start_time' => Carbon::now(),
                'end_time' => null
            ]);
            Role::create([
                'id' => '1',
                'name' => 'Administrator',
                'description' => 'Administrator of all system',
            ]);
            User::create([
                'phone' => '01279011099',
                'password' => Hash::make('#2017#'),
            ]);
            UserHasRole::create([
                'phone' => '01279011099',
                'role_id' => 4,
                'start_time' => Carbon::now(),
                'end_time' => null
            ]);
            Role::create([
                'id' => '4',
                'name' => 'Patient',
                'description' => 'Patient',
            ]);
            User::create([
                'phone' => '01279011097',
                'password' => Hash::make('#2017#'),
            ]);
            UserHasRole::create([
                'phone' => '01279011097',
                'role_id' => 2,
                'start_time' => Carbon::now(),
                'end_time' => null
            ]);
            Role::create([
                'id' => '2',
                'name' => 'Doctor',
                'description' => 'Doctor of dental Clinic',
            ]);
            User::create([
                'phone' => '01279011098',
                'password' => Hash::make('#2017#'),
            ]);
            UserHasRole::create([
                'phone' => '01279011098',
                'role_id' => 3,
                'start_time' => Carbon::now(),
                'end_time' => null
            ]);
            Role::create([
                'id' => '3',
                'name' => 'Receptionist',
                'description' => 'Receptionist of dental Clinic',
            ]);

            Treatment::create([
                'name' => 'Cạo vôi',
                'description' => 'Cạo vôi răng',
                'treatment_category_id' => '1',
                'min_price' => '250000',
                'max_price' => '350000',
            ]);
            Treatment::create([
                'name' => 'Cạo vôi dưới nướu ',
                'description' => 'Cạo vôi dưới nướu ',
                'treatment_category_id' => '1',
                'min_price' => '500000',
                'max_price' => '1000000',
            ]);
            Treatment::create([
                'name' => 'Cắt Nướu ',
                'description' => ' Cắt Nướu',
                'treatment_category_id' => '1',
                'min_price' => '1000000',
                'max_price' => '1000000',
            ]);
            Treatment::create([
                'name' => 'Phẫu Thuật Nha Chu răng ',
                'description' => 'Phẫu Thuật Nha Chu răng ',
                'treatment_category_id' => '1',
                'min_price' => '2000000',
                'max_price' => '2000000',
            ]);
            Treatment::create([
                'name' => 'Nạo Túi Nha Chu ',
                'description' => 'Nạo Túi Nha Chu ',
                'treatment_category_id' => '1',
                'min_price' => '200000',
                'max_price' => '200000',
            ]);
            Treatment::create([
                'name' => 'TRÁM RĂNG COMPOSITE XOANG I VÀ V',
                'description' => 'XOANG I VÀ V',
                'treatment_category_id' => '2',
                'min_price' => '300000',
                'max_price' => '500000',
            ]);
            Treatment::create([
                'name' => 'TRÁM RĂNG COMPOSITE XOANG II ,III VÀ IV hay Đắt mặt',
                'description' => 'XOANG I VÀ V',
                'treatment_category_id' => '2',
                'min_price' => '500000',
                'max_price' => '1000000',
            ]);
            Treatment::create([
                'name' => 'TẨY TRẮNG TẠI PHÒNG KHÁM ',
                'description' => 'TẨY TRẮNG TẠI PHÒNG KHÁM',
                'treatment_category_id' => '2',
                'min_price' => '2000000',
                'max_price' => '2000000',
            ]);
            Treatment::create([
                'name' => 'TẨY TRẮNG TẠI PHÒNG Nhà ',
                'description' => 'TẨY TRẮNG TẠI PHÒNG Nhà',
                'treatment_category_id' => '2',
                'min_price' => '1000000',
                'max_price' => '1000000',
            ]);
            Treatment::create([
                'name' => 'POST TRÁM - POST SỢI',
                'description' => 'POST TRÁM - POST SỢI',
                'treatment_category_id' => '2',
                'min_price' => '1000000',
                'max_price' => '1000000',
            ]);
            Treatment::create([
                'name' => 'POST TRÁM - POST KIM LOẠI',
                'description' => 'POST TRÁM - POST KIM LOẠI',
                'treatment_category_id' => '2',
                'min_price' => '300000',
                'max_price' => '500000',
            ]);
            Treatment::create([
                'name' => 'RĂNG CỬA',
                'description' => 'RĂNG CỬA',
                'treatment_category_id' => '3',
                'min_price' => '700000 ',
                'max_price' => '700000',
            ]);
            Treatment::create([
                'name' => 'RĂNG CỐI NHỎ VÀ RĂNG NANH',
                'description' => 'RĂNG CỐI NHỎ VÀ RĂNG NANH',
                'treatment_category_id' => '3',
                'min_price' => '900000',
                'max_price' => '900000',
            ]);
            Treatment::create([
                'name' => 'RĂNG CỐI LỚN',
                'description' => 'RĂNG CỐI LỚN',
                'treatment_category_id' => '3',
                'min_price' => '1100000',
                'max_price' => '1100000',
            ]);
            Treatment::create([
                'name' => 'LẤY TỦY LẠI',
                'description' => 'LẤY TỦY LẠI',
                'treatment_category_id' => '3',
                'min_price' => '300000',
                'max_price' => '300000',
            ]);
            Treatment::create([
                'name' => 'NHỔ RĂNG SỮA',
                'description' => 'NHỔ RĂNG SỮA',
                'treatment_category_id' => '4',
                'min_price' => '0',
                'max_price' => '0',
            ]);
            Treatment::create([
                'name' => 'NHỔ RĂNG CỬA',
                'description' => 'NHỔ RĂNG CỬA',
                'treatment_category_id' => '4',
                'min_price' => '500000',
                'max_price' => '500000',
            ]);
            Treatment::create([
                'name' => 'NHỔ RĂNG CỐI NHỎ',
                'description' => 'NHỔ RĂNG CỐI NHỎ',
                'treatment_category_id' => '4',
                'min_price' => '700000',
                'max_price' => '700000',
            ]);
            Treatment::create([
                'name' => 'NHỔ RĂNG CỐI LỚN HOẶC RĂNG KHÔN HÀM TRÊN',
                'description' => 'NHỔ RĂNG CỐI LỚN HOẶC RĂNG KHÔN HÀM TRÊN',
                'treatment_category_id' => '4',
                'min_price' => '1000000',
                'max_price' => '1500000',
            ]);
            Treatment::create([
                'name' => 'NHỔ RĂNG TIỂU PHẨU',
                'description' => 'NHỔ RĂNG TIỂU PHẨU',
                'treatment_category_id' => '4',
                'min_price' => '1500000',
                'max_price' => '2000000',
            ]);
            Treatment::create([
                'name' => 'MÃO SỨ KL THƯỜNG',
                'description' => 'MÃO SỨ KL THƯỜNG',
                'treatment_category_id' => '5',
                'min_price' => '1500000',
                'max_price' => '1500000',
            ]);
            Treatment::create([
                'name' => 'MÃO SỨ TITAN',
                'description' => 'MÃO SỨ TITAN',
                'treatment_category_id' => '5',
                'min_price' => '2500000',
                'max_price' => '2500000',
            ]);
            Treatment::create([
                'name' => 'MÃO SỨ ZIRCONIA',
                'description' => 'MÃO SỨ ZIRCONIA',
                'treatment_category_id' => '5',
                'min_price' => '4000000',
                'max_price' => '4000000',
            ]);
            Treatment::create([
                'name' => 'MÃO SỨ LAVA',
                'description' => 'MÃO SỨ LAVA',
                'treatment_category_id' => '5',
                'min_price' => '7000000',
                'max_price' => '7000000',
            ]);
            Treatment::create([
                'name' => 'VENEER',
                'description' => 'VENEER',
                'treatment_category_id' => '5',
                'min_price' => '6000000',
                'max_price' => '8000000',
            ]);
            Treatment::create([
                'name' => 'MÃO SỨ CERCON',
                'description' => 'MÃO SỨ CERCON',
                'treatment_category_id' => '5',
                'min_price' => '5000000',
                'max_price' => '5000000',
            ]);
            Treatment::create([
                'name' => 'CÙI GIẢ KIM LOẠI',
                'description' => 'CÙI GIẢ KIM LOẠI',
                'treatment_category_id' => '5',
                'min_price' => '500000',
                'max_price' => '500000',
            ]);
            Treatment::create([
                'name' => 'CÙI GIẢ SỨ',
                'description' => 'CÙI GIẢ SỨ',
                'treatment_category_id' => '5',
                'min_price' => '1500000',
                'max_price' => '1500000',
            ]);
            Treatment::create([
                'name' => 'HÀM NHỰA - RĂNG NHỰA VIỆT NAM',
                'description' => 'HÀM NHỰA RĂNG NHỰA VIỆT NAM',
                'treatment_category_id' => '6',
                'min_price' => '300000',
                'max_price' => '300000',
            ]);
            Treatment::create([
                'name' => 'HÀM NHỰA -RĂNG COMPOSITE',
                'description' => 'HÀM NHỰA - RĂNG COMPOSITE',
                'treatment_category_id' => '6',
                'min_price' => '500000',
                'max_price' => '500000',
            ]);
            Treatment::create([
                'name' => 'HÀM NHỰA -RĂNG SỨ',
                'description' => 'HÀM NHỰA - RĂNG SỨ',
                'treatment_category_id' => '6',
                'min_price' => '600000',
                'max_price' => '600000',
            ]);

            Treatment::create([
                'name' => 'DENTIUM HÀN QUỐC',
                'description' => 'DENTIUM HÀN QUỐC',
                'treatment_category_id' => '7',
                'min_price' => '15400000',
                'max_price' => '15400000',
            ]);
            Treatment::create([
                'name' => 'DENTIUM MỸ',
                'description' => 'DENTIUM MỸ',
                'treatment_category_id' => '7',
                'min_price' => '19800000',
                'max_price' => '19800000',
            ]);
            Treatment::create([
                'name' => 'NOBEL HAY STRAUMAN',
                'description' => 'NOBEL HAY STRAUMAN',
                'treatment_category_id' => '7',
                'min_price' => '28600000',
                'max_price' => '28600000',
            ]);

            Treatment::create([
                'name' => 'MẮC CÀI KIM LOẠI',
                'description' => 'MẮC CÀI KIM LOẠI',
                'treatment_category_id' => '8',
                'min_price' => '30000000',
                'max_price' => '35000000',
            ]);
            Treatment::create([
                'name' => 'MẮC CÀI SỨ',
                'description' => 'MẮC CÀI SỨ',
                'treatment_category_id' => '8',
                'min_price' => '40000000',
                'max_price' => '45000000',
            ]);
            Treatment::create([
                'name' => 'MẮC CÀI KIM LOẠI TỰ KHÓA',
                'description' => 'MẮC CÀI KIM LOẠI TỰ KHÓA',
                'treatment_category_id' => '8',
                'min_price' => '40000000',
                'max_price' => '45000000',
            ]);
            Treatment::create([
                'name' => 'MẮC CÀI SỨ',
                'description' => 'MẮC CÀI SỨ',
                'treatment_category_id' => '8',
                'min_price' => '55000000',
                'max_price' => '60000000',
            ]);
            Treatment::create([
                'name' => 'INVISALIGN( KHÔNG MẮC CÀI)',
                'description' => 'INVISALIGN( KHÔNG MẮC CÀI)',
                'treatment_category_id' => '8',
                'min_price' => '88000000',
                'max_price' => '115000000',
            ]);

            TreatmentCategory::create([
                'name' => 'Nha Chu',
                'description' => 'Nha chu là tổ chức xung quanh răng, chức năng chính là chống đỡ và giữ răng trong xương hàm. Răng khỏe mạnh được giữ trong xương hàm bởi xương ổ răng, dây chằng và nướu răng.',
                'icon_link' => '/assets/images/icon/bocrangsu.png',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'Trám Răng',
                'description' => ' XXX',
                'icon_link' => '/assets/images/icon/tramrangthammy.png',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'Nội Nha ',
                'description' => 'phương pháp điều trị ở bên trong của răng. Bên trong răng, dưới men trắng và một lớp cứng gọi là ngà răng, là một mô mềm gọi là tủy răng. Tủy răng chứa các mạch máu, dây thần kinh, và mô liên kết  ',
                'icon_link' => '/assets/images/icon/caovoirang.png',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => ' Nhổ Răng',
                'description' => 'Nhổ răng khó là những răng mọc lệch, răng ngầm, răng khôn bị tai biến, răng bị gẫy chân, răng dính khớp..',
                'icon_link' => '/assets/images/icon/nhorang.png',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'PHỤC HÌNH CỐ ĐỊNH',
                'description' => 'Phục hình cố định (răng giả cố định) là các loại phục hình – răng giả (mão – cầu răng sứ, mão – cầu răng kim loại…) được gắn cố định vào hàm, miệng người mang.  ',
                'icon_link' => '/assets/images/icon/ranggiathaolap.png',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'PHỤC HÌNH THÁO LẮP ',
                'description' => 'Phục hình tháo lắp, cụ thể là phục hình tháo lắp răng là phương pháp phục hồi các răng hư tổn, để tái tạo các chức năng của răng. Hay phục hình tháo lắp có thể hiểu là sử dụng răng giả để tháo lắp. Bạn có thể cho răng vào và lấy ra dễ dàng để vệ sinh răng',
                'icon_link' => '/assets/images/icon/taytrangrang.png',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'IMPLANT (BAO GỒM PHỤC HÌNH) ',
                'description' => 'Cấy ghép răng Implant nha khoa là phương pháp phục hình răng tốt nhất cho người bị mất răng, đảm bảo khả năng ăn nhai giống hoàn toàn như một chiếc răng bình thường.',
                'icon_link' => '/assets/images/icon/trongimplent.png',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'CHỈNH NHA',
                'description' => 'Chỉnh nha là một nhánh của ngành nha khoa giúp điều chỉnh vị trí của hàm và những răng sai lệch. Những răng bị lệch lạc và những răng không vừa khít với khuôn miệng. ',
                'icon_link' => '/assets/images/icon/danmatsuVENNER.png',
                'estimate_time' => '3'
            ]);


            Tooth::create([
                'tooth_number' => '11',
                'tooth_name' => 'Răng số 1 hàm trên phải - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '12',
                'tooth_name' => 'Răng số 2 hàm trên phải - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '13',
                'tooth_name' => 'Răng số 3 hàm trên phải - Răng Nanh'
            ]);
            Tooth::create([
                'tooth_number' => '14',
                'tooth_name' => 'Răng số 4 hàm trên phải - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '15',
                'tooth_name' => 'Răng số 5 hàm trên phải - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '16',
                'tooth_name' => 'Răng số 6 hàm trên phải - Răng cối lớn'
            ]);
            Tooth::create([
                'tooth_number' => '17',
                'tooth_name' => 'Răng số 7 hàm trên phải - Răng cối lớn'
            ]);
            Tooth::create([
                'tooth_number' => '18',
                'tooth_name' => 'Răng số 8 hàm trên phải - Răng cối lớn'
            ]);
            //end trên phải
            // dưới trái
            Tooth::create([
                'tooth_number' => '21',
                'tooth_name' => 'Răng số 1 hàm trên trái - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '22',
                'tooth_name' => 'Răng số 2 hàm trên trái - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '23',
                'tooth_name' => 'Răng số 3 hàm trên trái - Răng Nanh'
            ]);
            Tooth::create([
                'tooth_number' => '24',
                'tooth_name' => 'Răng số 4 hàm trên trái - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '25',
                'tooth_name' => 'Răng số 5 hàm trên trái - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '26',
                'tooth_name' => 'Răng số 6 hàm trên trái - Răng cối lớn'
            ]);
            Tooth::create([
                'tooth_number' => '27',
                'tooth_name' => 'Răng số 7 hàm trên trái - Răng cối lớn'
            ]);
            Tooth::create([
                'tooth_number' => '28',
                'tooth_name' => 'Răng số 8 hàm trên trái - Răng cối lớn'
            ]);
            //endham dưới trái
            Tooth::create([
                'tooth_number' => '41',
                'tooth_name' => 'Răng số 1 hàm dưới phải - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '42',
                'tooth_name' => 'Răng số 2 hàm dưới phải - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '43',
                'tooth_name' => 'Răng số 3 hàm dưới phải - Răng Nanh'
            ]);
            Tooth::create([
                'tooth_number' => '44',
                'tooth_name' => 'Răng số 4 hàm dưới phải - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '45',
                'tooth_name' => 'Răng số 5 hàm dưới phải - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '46',
                'tooth_name' => 'Răng số 6 hàm dưới phải - Răng cối lớn'
            ]);
            Tooth::create([
                'tooth_number' => '47',
                'tooth_name' => 'Răng số 7 hàm dưới phải - Răng cối lớn'
            ]);
            Tooth::create([
                'tooth_number' => '48',
                'tooth_name' => 'Răng số 8 hàm dưới phải - Răng cối lớn'
            ]);
            //end dưới phải
            // dưới trái
            Tooth::create([
                'tooth_number' => '31',
                'tooth_name' => 'Răng số 1 hàm dưới trái - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '32',
                'tooth_name' => 'Răng số 2 hàm dưới trái - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '33',
                'tooth_name' => 'Răng số 3 hàm dưới trái - Răng Nanh'
            ]);
            Tooth::create([
                'tooth_number' => '34',
                'tooth_name' => 'Răng số 4 hàm dưới trái - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '35',
                'tooth_name' => 'Răng số 5 hàm dưới trái - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '36',
                'tooth_name' => 'Răng số 6 hàm dưới trái - Răng cối lớn'
            ]);
            Tooth::create([
                'tooth_number' => '37',
                'tooth_name' => 'Răng số 7 hàm dưới trái - Răng cối lớn'
            ]);
            Tooth::create([
                'tooth_number' => '38',
                'tooth_name' => 'Răng số 8 hàm dưới trái - Răng cối lớn'
            ]);
            //endham dưới trái
            //rang tre con
            // tren phải
            Tooth::create([
                'tooth_number' => '51',
                'tooth_name' => 'Răng số 1 hàm trên phải (Trẻ em) - Răng cửa giữa'
            ]);
            Tooth::create([
                'tooth_number' => '52',
                'tooth_name' => 'Răng số 1 hàm trên phải (Trẻ em) - Răng cửa bên'
            ]);
            Tooth::create([
                'tooth_number' => '53',
                'tooth_name' => 'Răng số 3 hàm trên phải - Răng nanh sữa'
            ]);
            Tooth::create([
                'tooth_number' => '54',
                'tooth_name' => 'Răng số 4 hàm trên phải - Răng cối sữa 1'
            ]);
            Tooth::create([
                'tooth_number' => '55',
                'tooth_name' => 'Răng số 5 hàm trên phải - Răng cối sữa 2'
            ]);
            //end tren phai
            // tren trái
            Tooth::create([
                'tooth_number' => '61',
                'tooth_name' => 'Răng số 1 hàm trên trái (Trẻ em) - Răng cửa giữa'
            ]);
            Tooth::create([
                'tooth_number' => '62',
                'tooth_name' => 'Răng số 1 hàm trên trái (Trẻ em) - Răng cửa bên'
            ]);
            Tooth::create([
                'tooth_number' => '63',
                'tooth_name' => 'Răng số 3 hàm trên trái - Răng nanh sữa'
            ]);
            Tooth::create([
                'tooth_number' => '64',
                'tooth_name' => 'Răng số 4 hàm trên trái - Răng cối sữa 1'
            ]);
            Tooth::create([
                'tooth_number' => '65',
                'tooth_name' => 'Răng số 5 hàm trên trái - Răng cối sữa 2'
            ]);
            //end tren trái
            // dưới phải
            Tooth::create([
                'tooth_number' => '81',
                'tooth_name' => 'Răng số 1 hàm dưới phải (Trẻ em) - Răng cửa giữa'
            ]);
            Tooth::create([
                'tooth_number' => '82',
                'tooth_name' => 'Răng số 1 hàm dưới phải (Trẻ em) - Răng cửa bên'
            ]);
            Tooth::create([
                'tooth_number' => '83',
                'tooth_name' => 'Răng số 3 hàm dưới phải  - Răng nanh sữa'
            ]);
            Tooth::create([
                'tooth_number' => '84',
                'tooth_name' => 'Răng số 4 hàm dưới phải  - Răng cối sữa 1'
            ]);
            Tooth::create([
                'tooth_number' => '85',
                'tooth_name' => 'Răng số 5 hàm dưới phải - Răng cối sữa 2'
            ]);
            //end dưới phải
            // dưới trái
            Tooth::create([
                'tooth_number' => '71',
                'tooth_name' => 'Răng số 1 hàm dưới trái (Trẻ em) - Răng cửa giữa'
            ]);
            Tooth::create([
                'tooth_number' => '72',
                'tooth_name' => 'Răng số 1 hàm dưới trái (Trẻ em) - Răng cửa bên'
            ]);
            Tooth::create([
                'tooth_number' => '73',
                'tooth_name' => 'Răng số 3 hàm dưới trái - Răng nanh sữa'
            ]);
            Tooth::create([
                'tooth_number' => '74',
                'tooth_name' => 'Răng số 4 hàm dưới trái - Răng cối sữa 1'
            ]);
            Tooth::create([
                'tooth_number' => '75',
                'tooth_name' => 'Răng số 5 hàm dưới trái - Răng cối sữa 2'
            ]);
            //end dưới trái


            Appointment::create([
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'staff_id' => 1,
                'start_time' => '2018-07-21 10:05:42',
            ]);
            Appointment::create([
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'staff_id' => 1,
                'start_time' => '2018-06-22 10:05:42',
            ]);
            Appointment::create([
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'staff_id' => 1,
                'start_time' => '2018-06-24 12:05:42',
            ]);
            Appointment::create([
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'staff_id' => 1,
                'start_time' => '2018-06-28 10:05:42',
            ]);
            Appointment::create([
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'staff_id' => 1,
                'start_time' => '2018-06-27 10:05:42',
            ]);
            Appointment::create([
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'staff_id' => 1,
                'start_time' => '2018-06-26 11:05:42',
            ]);
            Appointment::create([
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'staff_id' => 1,
                'start_time' => '2018-06-22 19:05:42',
            ]);
            Appointment::create([
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'staff_id' => 1,
                'start_time' => '2018-06-27 16:05:42',
            ]);



            Patient::create([
                'name' => 'Nguyễn Huỳnh Tài',
                'address' => '188 Nguyễn xí',
                'phone' => '01279011096',
                'date_of_birth' => '1996-10-01',
                'gender' => 'MALE',
                'district_id' => 1,
            ]);

            Patient::create([
                'name' => 'Huỳnh Võ Thiên Phúc',
                'address' => '188 Cầu xí',
                'phone' => '01279011096',
                'date_of_birth' => '1996-10-02',
                'gender' => 'FEMALE',
                'district_id' => 1,
                'is_parent' => 0
            ]);

            Patient::create([
                'name' => 'Nhiêu Sĩ Lực',
                'address' => '188 Cầu Đường',
                'phone' => '01279011097',
                'date_of_birth' => '1996-10-03',
                'gender' => 'FEMALE',
                'district_id' => 1,
            ]);
            TreatmentHistory::create([
                'treatment_id' => 1,
                'patient_id' => 1,
                'description' => 'ABC',
                'create_date' => Carbon::now(),
                'finish_date' => Carbon::now(),
                'tooth_number' => '11',
                'price' => 1000000,
                'total_price' => 900000,
                'payment_id' => 1,
            ]);
            TreatmentDetail::create([
                'treatment_history_id' => 1,
                'staff_id' => 1,
                'create_date' => Carbon::now(),
                'note' => 'DEF'
            ]);
            TreatmentDetailStep::create([
                'treatment_detail_id' => 1,
                'step_id' => 1,
                'description' => 'cho phuc'
            ]);

            TreatmentDetail::create([
                'treatment_history_id' => 1,
                'staff_id' => 1,
                'create_date' => Carbon::now(),
                'note' => 'DEF'
            ]);
            TreatmentDetailStep::create([
                'treatment_detail_id' => 2,
                'step_id' => 2,
                'description' => 'cho phuc'
            ]);

            TreatmentHistory::create([
                'treatment_id' => 1,
                'patient_id' => 2,
                'description' => 'ABC',
                'create_date' => Carbon::now(),
                'finish_date' => Carbon::now(),
                'tooth_number' => '11',
                'price' => 1000000,
                'total_price' => 900000,
                'payment_id' => 1,
            ]);
            TreatmentDetail::create([
                'treatment_history_id' => 2,
                'staff_id' => 2,
                'create_date' => Carbon::now(),
                'note' => 'DEF'
            ]);
            TreatmentDetailStep::create([
                'treatment_detail_id' => 3,
                'step_id' => 1,
                'description' => 'cho phuc'
            ]);

            TreatmentDetail::create([
                'treatment_history_id' => 2,
                'staff_id' => 1,
                'create_date' => Carbon::now(),
                'note' => 'DEF'
            ]);
            TreatmentDetailStep::create([
                'treatment_detail_id' => 4,
                'step_id' => 2,
                'description' => 'cho phuc'
            ]);

            Staff::create([
                'name' => 'Nguyễn Huỳnh Tài Dentist',
                'degree' => 'Chịch',
                'address' => '188 Nguyễn xí',
                'district_id' => 1,
                'phone' => '01279011097',
                'date_of_birth' => '1996-10-01',
                'gender' => 'MALE',
            ]);
            Staff::create([
                'name' => 'Nguyễn Huỳnh Tài Administrator',
                'degree' => 'Chịch',
                'address' => '188 Nguyễn xí',
                'district_id' => 1,
                'phone' => '01279011096',
                'date_of_birth' => '1996-10-01',
                'gender' => 'MALE',
            ]);
            Staff::create([
                'name' => 'Nguyễn Huỳnh Tài Reception',
                'degree' => 'Chịch',
                'address' => '188 Nguyễn xí',
                'district_id' => 1,
                'phone' => '01279011098',
                'date_of_birth' => '1996-10-01',
                'gender' => 'MALE',
            ]);

            Appointment::create([
                'start_time' => Carbon::now(),
                'note' => 'dume lo di kham di',
                'phone' => '01279011096',
                'staff_id' => 1,
                'numerical_order' => '1',
                'estimated_time' => '30'
            ]);

            Absent::create([
               'staff_approve_id' => 2,
               'request_absent_id' =>  1,
                'message_from_staff' => 'deoo cho',
            ]);
            Absent::create([
                'staff_approve_id' => 2,
                'request_absent_id' =>  2,
                'message_from_staff' => 'okie cho',
            ]);
            RequestAbsent::create([
                'staff_id' => 2,
                'start_date' => '2018-06-26',
                'end_date' => '2018-06-28',
                'reason' =>  'tao thich',
            ]);
            RequestAbsent::create([
                'staff_id' => 1,
                'start_date' => '2018-06-25',
                'end_date' => '2018-07-01',
                'reason' =>  'tao thich',
            ]);
            News::create([
                'image_header' => 'http://150.95.104.237/photos/shares/implant-1.png',
                'content' => '<h2 style="color: blue;">TRỒNG RĂNG IMPLANT</h2>
<p><strong>Với sự ph&aacute;t triển của nha khoa hiện nay th&igrave; c&aacute;c bạn sẽ kh&ocirc;ng c&ograve;n lo ngại v&agrave; xấu hổ với những chiếc răng bị mất của m&igrave;nh nữa. Đến với nha khoa của ch&uacute;ng t&ocirc;i c&aacute;c bạn sẽ được tư vấn miễn ph&iacute; bởi c&aacute;c b&aacute;c sĩ c&oacute; nhiều năm kinh nghiệm trong việc&rdquo; trồng răng Implant&rdquo; để c&oacute; được một h&agrave;m răng chắc, khỏe v&agrave; đẹp.</strong></p>
<p><strong>Tuy nhi&ecirc;n, kh&aacute;i niệm &ldquo;trồng răng Implant&rdquo; c&ograve;n rất &iacute;t người biết đến. Vậy trồng răng Implant l&agrave; g&igrave;? Kĩ thuật trồng răng Implant&nbsp;l&agrave; việc phục hồi răng bị mất bằng việc cắm v&iacute;t Implant v&agrave;o trong xương h&agrave;m l&agrave;m trụ sau đ&oacute; sẽ phục h&igrave;nh m&atilde;o sứ ở tr&ecirc;n để gi&uacute;p lấy lại n&eacute;t thẩm mĩ cũng như giữ vững cấu tr&uacute;c của h&agrave;m răng.T&ugrave;y&nbsp;v&agrave;o t&igrave;nh trạng răng h&agrave;m v&agrave; nhu cầu của mỗi kh&aacute;ch h&agrave;ng, c&aacute;c b&aacute;c sĩ sẽ tư vấn số lượng cũng như vị tr&iacute; cấy gh&eacute;p răng Implant ph&ugrave; hợp cho từng đối tượng. Vậy việc trồng răng Implant sẽ cho bạn những lợi &iacute;ch g&igrave;?</strong></p>
<p><strong>&ndash; Chiếc răng chắc chắn nhất.</strong></p>
<p><strong>&ndash; Chiếc răng bền nhất.</strong></p>
<p><strong>&ndash; Bảo vệ sức khỏe răng miệng triệt để nhất.</strong></p>
<p><strong>&ndash; Phục hồi ho&agrave;n hảo chức năng của một chiếc răng.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Trồng răng Implant</figcaption>
</figure>
<p><strong>Tuy nhi&ecirc;n, muốn c&oacute; một h&agrave;m răng như thế th&igrave; việc đầu ti&ecirc;n bạn cần l&agrave;m đ&oacute; l&agrave; chọn một nha khoa cực k&igrave; uy t&iacute;n. Vậy c&aacute;c bạn sẽ được g&igrave; khi đến với nha khoa của ch&uacute;ng t&ocirc;i?</strong></p>
<ul>
<li><strong>Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm:</strong></li>
</ul>
<p><strong>C&oacute; thể n&oacute;i để nhận x&eacute;t hay đ&aacute;nh gi&aacute; một nha khoa n&agrave;o đ&oacute; th&igrave; việc đầu ti&ecirc;n ta cần quan t&acirc;m đến đ&oacute; l&agrave; yếu tố đội ngũ b&aacute;c sĩ. C&aacute;c b&aacute;c sĩ ở nha khoa ở WeCare đều đ&atilde; c&oacute; rất nhiều kinh nghiệm trong việc phục hồi răng từ đơn giản đến phức tạp v&agrave; hầu như mọi trường hợp cấy gh&eacute;p răng Implant đều th&agrave;nh c&ocirc;ng.</strong></p>
<figure id="attachment_156" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-156 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-768x512.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-1024x682.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-600x400.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2.jpg 1280w" alt="" width="300" height="200" />
<figcaption class="wp-caption-text">Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm</figcaption>
</figure>
<ul>
<li><strong>100% vật liệu được nhập khẩu v&agrave; trải qua kiểm định khắt khe:</strong></li>
</ul>
<p><strong>Nha khoa WeCare c&oacute; khả năng nhập khẩu trực tiếp trụ răng nh&acirc;n tạo Implant ch&iacute;nh h&atilde;ng n&ecirc;n đảm bảo chất lượng răng tốt nhất.</strong></p>
<figure id="attachment_155" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-155 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-768x576.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-600x450.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png.jpg 950w" alt="" width="300" height="225" />
<figcaption class="wp-caption-text"><strong>Vật liệu được nhập khẩu</strong></figcaption>
</figure>
<ul>
<li><strong>M&aacute;y m&oacute;c v&agrave; trang thiết bị hiện đại:</strong></li>
</ul>
<p><strong>Để qu&aacute; tr&igrave;nh trồng răng Implant đạt được kết quả tốt nhất th&igrave; thiết bị hỗ trợ cấy gh&eacute;p răng Implant hiện đại cũng g&oacute;p một phần đ&aacute;ng kể để gi&uacute;p c&aacute;c b&aacute;c sĩ tối ưu được trong thao t&aacute;c, linh hoạt v&agrave; c&oacute; độ t&ugrave;y chỉnh lớn. Trang thiết bị hỗ trợ gh&eacute;p răng ở nha khoa ch&uacute;ng t&ocirc;i rất hiện đại, đ&atilde; được kiểm định kĩ về t&iacute;nh năng hoạt động v&agrave; chất lượng kĩ thuật n&ecirc;n đảm bảo cấy gh&eacute;p an to&agrave;n tuyệt đối, tối ưu ho&agrave;n hảo nhất.</strong></p>
<p><strong>Nhưng để c&oacute; một h&agrave;m răng đẹp v&agrave; chắc khỏe như mong muốn th&igrave; bạn phải trải qua c&aacute;c bước sau đ&acirc;y với c&aacute;c nha sĩ ở WeCare ch&uacute;ng t&ocirc;i:</strong></p>
<ol>
<li>
<h4><strong>Thăm kh&aacute;m v&agrave; chụp phim bằng m&aacute;y X quang:</strong></h4>
</li>
</ol>
<p><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng, t&igrave;nh trạng răng, nướu v&agrave; sức khỏe tổng thể bằng c&aacute;c thao t&aacute;c chụp X-quang, kiểm tra mật độ xương, độ d&agrave;y xương h&agrave;m.</strong></p>
<p><strong>Dựa tr&ecirc;n kết quả khảo s&aacute;t đ&oacute; , b&aacute;c sĩ sẽ t&iacute;nh to&aacute;n được ch&iacute;nh x&aacute;c độ d&agrave;i, k&iacute;ch cỡ, đường k&iacute;nh v&agrave; số ren cho trụ Implant tương th&iacute;ch với đặc điểm cấu tạo xương h&agrave;m bị mất răng. Đ&acirc;y sẽ l&agrave; cơ sở để b&aacute;c sĩ x&aacute;c định x&aacute;c định hướng đi của trụ nh&acirc;n tạo v&agrave; độ n&ocirc;ng s&acirc;u khi cấy gh&eacute;p.</strong></p>
<figure id="attachment_306" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-306 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-768x511.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-1024x681.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-600x399.jpg 600w" alt="" width="300" height="199" />
<figcaption class="wp-caption-text"><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng</strong></figcaption>
</figure>
<ol start="2">
<li>
<h4><strong>B&aacute;c sĩ l&ecirc;n kế hoạch điều trị v&agrave; cấy gh&eacute;p Implant cho răng:</strong></h4>
</li>
</ol>
<p><strong>Khi đ&atilde; c&oacute; đầy đủ những th&ocirc;ng số cơ bản b&aacute;c sĩ sẽ l&ecirc;n kế hoạch điều trị cụ thể với &nbsp;&nbsp;kh&aacute;ch h&agrave;ng. C&ugrave;ng với đ&oacute;, họ sẽ tư vấn về c&aacute;c điều kiện cấy gh&eacute;p Implant v&agrave; mức chi ph&iacute; để kh&aacute;ch h&agrave;ng biết r&otilde;, nếu kh&ocirc;ng c&oacute; vấn đề g&igrave; kh&aacute;c th&igrave; b&aacute;c sĩ sẽ đặt lịch hẹn để cấy gh&eacute;p Implant.</strong></p>
<ol start="3">
<li>
<h4><strong>Thực hiện cấy gh&eacute;p Implant:</strong></h4>
</li>
</ol>
<p><strong>Đến ng&agrave;y hẹn cấy gh&eacute;p bạn phải để t&acirc;m trạng m&igrave;nh thoải m&aacute;i, ăn uống đầy đủ v&agrave; chắc chắn sức khỏe tốt. B&aacute;c sĩ sẽ g&acirc;y t&ecirc; v&ugrave;ng cấy gh&eacute;p cho n&ecirc;n trong thời gian cấy gh&eacute;p bạn sẽ kh&ocirc;ng cảm thấy đau hay kh&oacute; chịu nữa. Sau đ&oacute;, b&aacute;c sĩ sẽ b&oacute;c t&aacute;ch nướu, khoan lỗ tr&ecirc;n xương h&agrave;m để cắm trụ Implant v&agrave;o.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Thực hiện cấy gh&eacute;p Implant</figcaption>
</figure>
<ol start="4">
<li>
<h4><strong>Lấy dấu mẫu h&agrave;m v&agrave; thiết kế răng sứ:</strong></h4>
</li>
</ol>
<p><strong>Bạn lo sợ rằng h&agrave;m răng của bạn sẽ bị trống sau khi cắm trụ Implant v&agrave;o? Kh&ocirc;ng,đừng lo, v&igrave; trước khi cắm trụ Implant v&agrave;o, họ đ&atilde; chuẩn bị răng tạm thời cho bạn, thường l&agrave; h&agrave;m th&aacute;o lắp. Sau một thời gian khi trụ Implant t&iacute;ch hợp trong xương h&agrave;m, b&aacute;c sĩ sẽ phục h&igrave;nh răng sứ l&ecirc;n tr&ecirc;n. Răng tạm sẽ gi&uacute;p bạn ăn nhai, đ&aacute;p ứng việc giao tiếp, sinh hoạt trong qu&aacute; tr&igrave;nh chờ trụ Implant t&iacute;ch hợp với xương h&agrave;m.</strong></p>
<ol start="5">
<li>
<h4><strong>T&aacute;i kh&aacute;m sau khi cấy gh&eacute;p implant:</strong></h4>
</li>
</ol>
<p><strong>Sau khi cấy gh&eacute;p Implant xong, khoảng một tuần- 10 ng&agrave;y sau bạn phải gặp b&aacute;c sĩ để kiểm tra c&aacute;c m&ocirc; nướu xung quanh xem c&oacute; l&agrave;nh lại chưa. B&aacute;c sĩ sẽ chụp phim để kiểm tra khả năng t&iacute;ch hợp Implant v&agrave;o xương như thế n&agrave;o.</strong></p>
<ol start="6">
<li>
<h4><strong>Phục h&igrave;nh răng sứ tr&ecirc;n trụ implant</strong>:</h4>
</li>
</ol>
<p><strong>Thời điểm n&agrave;y l&agrave; sau 3-6 th&aacute;ng cấy gh&eacute;p trụ implant. C&ocirc;ng việc tương tự như khi bọc m&atilde;o răng sứ hay cầu răng th&ocirc;ng thường. B&aacute;c sĩ sẽ tư vấn cho m&igrave;nh loại răng sứ ph&ugrave; hợp như cercon, titan&hellip;T&ugrave;y theo nhu cầu thẩm mĩ v&agrave; chi ph&iacute; của từng người m&agrave; bạn chọn loại răng sứ th&iacute;ch hợp cho m&igrave;nh. Bạn c&oacute; thể đến nha khoa trong 2-4 lần hẹn, t&ugrave;y v&agrave;o số lượng răng sứ m&agrave; thời gian sẽ ch&ecirc;nh lệch.</strong></p>',
                'title' => 'TRỒNG RĂNG IMPLANT – GIẢI PHÁP PHỤC HÌNH RĂNG BỊ MẤT HOÀN HẢO',
                'staff_id' => '1',
                'create_date' => '2018-06-19 04:31:27',
            ]);
            News::create([
                'image_header' => 'http://150.95.104.237/photos/shares/implant-1.png',
                'content' => '<h2 style="color: blue;">TRỒNG RĂNG IMPLANT</h2>
<p><strong>Với sự ph&aacute;t triển của nha khoa hiện nay th&igrave; c&aacute;c bạn sẽ kh&ocirc;ng c&ograve;n lo ngại v&agrave; xấu hổ với những chiếc răng bị mất của m&igrave;nh nữa. Đến với nha khoa của ch&uacute;ng t&ocirc;i c&aacute;c bạn sẽ được tư vấn miễn ph&iacute; bởi c&aacute;c b&aacute;c sĩ c&oacute; nhiều năm kinh nghiệm trong việc&rdquo; trồng răng Implant&rdquo; để c&oacute; được một h&agrave;m răng chắc, khỏe v&agrave; đẹp.</strong></p>
<p><strong>Tuy nhi&ecirc;n, kh&aacute;i niệm &ldquo;trồng răng Implant&rdquo; c&ograve;n rất &iacute;t người biết đến. Vậy trồng răng Implant l&agrave; g&igrave;? Kĩ thuật trồng răng Implant&nbsp;l&agrave; việc phục hồi răng bị mất bằng việc cắm v&iacute;t Implant v&agrave;o trong xương h&agrave;m l&agrave;m trụ sau đ&oacute; sẽ phục h&igrave;nh m&atilde;o sứ ở tr&ecirc;n để gi&uacute;p lấy lại n&eacute;t thẩm mĩ cũng như giữ vững cấu tr&uacute;c của h&agrave;m răng.T&ugrave;y&nbsp;v&agrave;o t&igrave;nh trạng răng h&agrave;m v&agrave; nhu cầu của mỗi kh&aacute;ch h&agrave;ng, c&aacute;c b&aacute;c sĩ sẽ tư vấn số lượng cũng như vị tr&iacute; cấy gh&eacute;p răng Implant ph&ugrave; hợp cho từng đối tượng. Vậy việc trồng răng Implant sẽ cho bạn những lợi &iacute;ch g&igrave;?</strong></p>
<p><strong>&ndash; Chiếc răng chắc chắn nhất.</strong></p>
<p><strong>&ndash; Chiếc răng bền nhất.</strong></p>
<p><strong>&ndash; Bảo vệ sức khỏe răng miệng triệt để nhất.</strong></p>
<p><strong>&ndash; Phục hồi ho&agrave;n hảo chức năng của một chiếc răng.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Trồng răng Implant</figcaption>
</figure>
<p><strong>Tuy nhi&ecirc;n, muốn c&oacute; một h&agrave;m răng như thế th&igrave; việc đầu ti&ecirc;n bạn cần l&agrave;m đ&oacute; l&agrave; chọn một nha khoa cực k&igrave; uy t&iacute;n. Vậy c&aacute;c bạn sẽ được g&igrave; khi đến với nha khoa của ch&uacute;ng t&ocirc;i?</strong></p>
<ul>
<li><strong>Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm:</strong></li>
</ul>
<p><strong>C&oacute; thể n&oacute;i để nhận x&eacute;t hay đ&aacute;nh gi&aacute; một nha khoa n&agrave;o đ&oacute; th&igrave; việc đầu ti&ecirc;n ta cần quan t&acirc;m đến đ&oacute; l&agrave; yếu tố đội ngũ b&aacute;c sĩ. C&aacute;c b&aacute;c sĩ ở nha khoa ở WeCare đều đ&atilde; c&oacute; rất nhiều kinh nghiệm trong việc phục hồi răng từ đơn giản đến phức tạp v&agrave; hầu như mọi trường hợp cấy gh&eacute;p răng Implant đều th&agrave;nh c&ocirc;ng.</strong></p>
<figure id="attachment_156" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-156 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-768x512.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-1024x682.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-600x400.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2.jpg 1280w" alt="" width="300" height="200" />
<figcaption class="wp-caption-text">Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm</figcaption>
</figure>
<ul>
<li><strong>100% vật liệu được nhập khẩu v&agrave; trải qua kiểm định khắt khe:</strong></li>
</ul>
<p><strong>Nha khoa WeCare c&oacute; khả năng nhập khẩu trực tiếp trụ răng nh&acirc;n tạo Implant ch&iacute;nh h&atilde;ng n&ecirc;n đảm bảo chất lượng răng tốt nhất.</strong></p>
<figure id="attachment_155" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-155 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-768x576.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-600x450.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png.jpg 950w" alt="" width="300" height="225" />
<figcaption class="wp-caption-text"><strong>Vật liệu được nhập khẩu</strong></figcaption>
</figure>
<ul>
<li><strong>M&aacute;y m&oacute;c v&agrave; trang thiết bị hiện đại:</strong></li>
</ul>
<p><strong>Để qu&aacute; tr&igrave;nh trồng răng Implant đạt được kết quả tốt nhất th&igrave; thiết bị hỗ trợ cấy gh&eacute;p răng Implant hiện đại cũng g&oacute;p một phần đ&aacute;ng kể để gi&uacute;p c&aacute;c b&aacute;c sĩ tối ưu được trong thao t&aacute;c, linh hoạt v&agrave; c&oacute; độ t&ugrave;y chỉnh lớn. Trang thiết bị hỗ trợ gh&eacute;p răng ở nha khoa ch&uacute;ng t&ocirc;i rất hiện đại, đ&atilde; được kiểm định kĩ về t&iacute;nh năng hoạt động v&agrave; chất lượng kĩ thuật n&ecirc;n đảm bảo cấy gh&eacute;p an to&agrave;n tuyệt đối, tối ưu ho&agrave;n hảo nhất.</strong></p>
<p><strong>Nhưng để c&oacute; một h&agrave;m răng đẹp v&agrave; chắc khỏe như mong muốn th&igrave; bạn phải trải qua c&aacute;c bước sau đ&acirc;y với c&aacute;c nha sĩ ở WeCare ch&uacute;ng t&ocirc;i:</strong></p>
<ol>
<li>
<h4><strong>Thăm kh&aacute;m v&agrave; chụp phim bằng m&aacute;y X quang:</strong></h4>
</li>
</ol>
<p><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng, t&igrave;nh trạng răng, nướu v&agrave; sức khỏe tổng thể bằng c&aacute;c thao t&aacute;c chụp X-quang, kiểm tra mật độ xương, độ d&agrave;y xương h&agrave;m.</strong></p>
<p><strong>Dựa tr&ecirc;n kết quả khảo s&aacute;t đ&oacute; , b&aacute;c sĩ sẽ t&iacute;nh to&aacute;n được ch&iacute;nh x&aacute;c độ d&agrave;i, k&iacute;ch cỡ, đường k&iacute;nh v&agrave; số ren cho trụ Implant tương th&iacute;ch với đặc điểm cấu tạo xương h&agrave;m bị mất răng. Đ&acirc;y sẽ l&agrave; cơ sở để b&aacute;c sĩ x&aacute;c định x&aacute;c định hướng đi của trụ nh&acirc;n tạo v&agrave; độ n&ocirc;ng s&acirc;u khi cấy gh&eacute;p.</strong></p>
<figure id="attachment_306" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-306 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-768x511.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-1024x681.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-600x399.jpg 600w" alt="" width="300" height="199" />
<figcaption class="wp-caption-text"><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng</strong></figcaption>
</figure>
<ol start="2">
<li>
<h4><strong>B&aacute;c sĩ l&ecirc;n kế hoạch điều trị v&agrave; cấy gh&eacute;p Implant cho răng:</strong></h4>
</li>
</ol>
<p><strong>Khi đ&atilde; c&oacute; đầy đủ những th&ocirc;ng số cơ bản b&aacute;c sĩ sẽ l&ecirc;n kế hoạch điều trị cụ thể với &nbsp;&nbsp;kh&aacute;ch h&agrave;ng. C&ugrave;ng với đ&oacute;, họ sẽ tư vấn về c&aacute;c điều kiện cấy gh&eacute;p Implant v&agrave; mức chi ph&iacute; để kh&aacute;ch h&agrave;ng biết r&otilde;, nếu kh&ocirc;ng c&oacute; vấn đề g&igrave; kh&aacute;c th&igrave; b&aacute;c sĩ sẽ đặt lịch hẹn để cấy gh&eacute;p Implant.</strong></p>
<ol start="3">
<li>
<h4><strong>Thực hiện cấy gh&eacute;p Implant:</strong></h4>
</li>
</ol>
<p><strong>Đến ng&agrave;y hẹn cấy gh&eacute;p bạn phải để t&acirc;m trạng m&igrave;nh thoải m&aacute;i, ăn uống đầy đủ v&agrave; chắc chắn sức khỏe tốt. B&aacute;c sĩ sẽ g&acirc;y t&ecirc; v&ugrave;ng cấy gh&eacute;p cho n&ecirc;n trong thời gian cấy gh&eacute;p bạn sẽ kh&ocirc;ng cảm thấy đau hay kh&oacute; chịu nữa. Sau đ&oacute;, b&aacute;c sĩ sẽ b&oacute;c t&aacute;ch nướu, khoan lỗ tr&ecirc;n xương h&agrave;m để cắm trụ Implant v&agrave;o.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Thực hiện cấy gh&eacute;p Implant</figcaption>
</figure>
<ol start="4">
<li>
<h4><strong>Lấy dấu mẫu h&agrave;m v&agrave; thiết kế răng sứ:</strong></h4>
</li>
</ol>
<p><strong>Bạn lo sợ rằng h&agrave;m răng của bạn sẽ bị trống sau khi cắm trụ Implant v&agrave;o? Kh&ocirc;ng,đừng lo, v&igrave; trước khi cắm trụ Implant v&agrave;o, họ đ&atilde; chuẩn bị răng tạm thời cho bạn, thường l&agrave; h&agrave;m th&aacute;o lắp. Sau một thời gian khi trụ Implant t&iacute;ch hợp trong xương h&agrave;m, b&aacute;c sĩ sẽ phục h&igrave;nh răng sứ l&ecirc;n tr&ecirc;n. Răng tạm sẽ gi&uacute;p bạn ăn nhai, đ&aacute;p ứng việc giao tiếp, sinh hoạt trong qu&aacute; tr&igrave;nh chờ trụ Implant t&iacute;ch hợp với xương h&agrave;m.</strong></p>
<ol start="5">
<li>
<h4><strong>T&aacute;i kh&aacute;m sau khi cấy gh&eacute;p implant:</strong></h4>
</li>
</ol>
<p><strong>Sau khi cấy gh&eacute;p Implant xong, khoảng một tuần- 10 ng&agrave;y sau bạn phải gặp b&aacute;c sĩ để kiểm tra c&aacute;c m&ocirc; nướu xung quanh xem c&oacute; l&agrave;nh lại chưa. B&aacute;c sĩ sẽ chụp phim để kiểm tra khả năng t&iacute;ch hợp Implant v&agrave;o xương như thế n&agrave;o.</strong></p>
<ol start="6">
<li>
<h4><strong>Phục h&igrave;nh răng sứ tr&ecirc;n trụ implant</strong>:</h4>
</li>
</ol>
<p><strong>Thời điểm n&agrave;y l&agrave; sau 3-6 th&aacute;ng cấy gh&eacute;p trụ implant. C&ocirc;ng việc tương tự như khi bọc m&atilde;o răng sứ hay cầu răng th&ocirc;ng thường. B&aacute;c sĩ sẽ tư vấn cho m&igrave;nh loại răng sứ ph&ugrave; hợp như cercon, titan&hellip;T&ugrave;y theo nhu cầu thẩm mĩ v&agrave; chi ph&iacute; của từng người m&agrave; bạn chọn loại răng sứ th&iacute;ch hợp cho m&igrave;nh. Bạn c&oacute; thể đến nha khoa trong 2-4 lần hẹn, t&ugrave;y v&agrave;o số lượng răng sứ m&agrave; thời gian sẽ ch&ecirc;nh lệch.</strong></p>',
                'title' => 'Trám răng đẹp như thủy tiên',
                'staff_id' => '1',
                'create_date' => '2018-06-19 04:31:27',
            ]);
            News::create([
                'image_header' => 'http://150.95.104.237/photos/shares/veneer-su-gia-bao-nhieu-1.jpg',
                'content' => '<p>iện nay, tại c&aacute;c trung t&acirc;m nha khoa lớn thường &aacute;p dụng phổ biến phương ph&aacute;p n&agrave;y cho một số trường hợp dưới đ&acirc;y:</p>
<p><img class="alignnone size-full wp-image-2953" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" alt="" width="30" height="30" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" />Răng bị nhiễm m&agrave;u do nhiễm thuốc kh&aacute;ng sinh m&agrave; tẩy trắng răng kh&ocirc;ng thể mang lại hiệu quả</p>
<p><img class="alignnone size-full wp-image-2953" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" alt="" width="30" height="30" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" />&nbsp;Răng bị thưa,&nbsp;hai răng cửa c&oacute; k&iacute;ch thước to hơn c&aacute;c răng c&ograve;n lại</p>
<p><img class="alignnone size-full wp-image-2953" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" alt="" width="30" height="30" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" />&nbsp;Răng bị sứt mẻ,&nbsp;bể vỡ</p>
<p><img class="alignnone size-full wp-image-2953" src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" alt="" width="30" height="30" data-lazy-src="https://nhakhoakim.com/wp-content/uploads/2016/11/tick-1.png" />&nbsp;Răng cửa bị tổn thương&hellip;</p>
<p><strong>Tại sao mặt d&aacute;n sứ Veneer lại được nhiều người y&ecirc;u th&iacute;ch?</strong></p>
<p>Mặc d&ugrave; vẫn c&ograve;n l&agrave; một phương ph&aacute;p kh&aacute; mới mẻ nhưng mặt d&aacute;n sứ veneer lại thu h&uacute;t được sự quan t&acirc;m của rất nhiều người v&agrave; nhanh ch&oacute;ng chiếm trọn sự tin y&ecirc;u của đ&ocirc;ng đảo kh&aacute;ch h&agrave;ng tr&ecirc;n khắp thế giới nhờ v&agrave;o những ưu điểm nổi trội như:</p>
<p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Hạn chế m&agrave;i răng, bảo tồn răng thật tối đa</strong></p>
<p>Thay v&igrave; phải m&agrave;i xung quanh răng như c&aacute;c phương ph&aacute;p bọc răng sứ kh&aacute;c, mặt d&aacute;n&nbsp;răng&nbsp;sứ Veneer chỉ cần thực hiện m&agrave;i một phần men răng ở mặt trước của răng v&agrave; tỷ lệ m&agrave;i rất &iacute;t, khoảng 1/2 so với l&agrave;m răng th&ocirc;ng thường n&ecirc;n c&oacute; thể gi&uacute;p&nbsp;hỗ trợ bảo tồn răng thật tối đa,&nbsp;kh&ocirc;ng cần phải lấy tủy, kh&ocirc;ng&nbsp;l&agrave;m răng bị &ecirc; buốt cả trong v&agrave; sau khi&nbsp;l&agrave;m.</p>
<p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Đảm bảo t&iacute;nh thẩm mỹ cao</strong></p>
<p>Mặt d&aacute;n sứ Veneer được cấu tạo từ chất liệu sứ nguy&ecirc;n chất, v&igrave; vậy c&oacute; thể gi&uacute;p khắc phục hiệu quả c&aacute;c khiếm khuyết tr&ecirc;n răng như: Răng bị mất men, sứt mẻ, m&eacute;o , vẹo, thiếu c&acirc;n đối&hellip; đặc biệt l&agrave; đối với răng cửa.</p>
<p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Kh&ocirc;ng g&acirc;y ảnh hưởng đến răng thật</strong></p>
<p>&nbsp;Kh&aacute;c với c&aacute;c phương ph&aacute;p bọc răng sứ th&ocirc;ng thường, mặt d&aacute;n sứ Veneer c&oacute; thể bảo tồn được tối đa răng thật , nhờ đ&oacute; gi&uacute;p giảm thiểu tối đa t&igrave;nh trạng m&agrave;i răng, cũng như kh&ocirc;ng g&acirc;y ảnh hưởng đến c&aacute;c răng kế cận.</p>
<p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Kh&ocirc;ng g&acirc;y kh&oacute; khăn khi ăn nhai&nbsp;</strong></p>
<p>Mặt d&aacute;n&nbsp;răng&nbsp;sứ Veneer được thiết kế kh&aacute; mỏng, chỉ khoảng từ 0,5 &ndash; 0,6 mm, do đ&oacute; khi được gắn v&agrave;o răng sẽ kh&ocirc;ng l&agrave;m bạn cảm thấy vướng v&iacute;u, cộm cấn hay kh&oacute; chịu.Thoải m&aacute;i ăn nhai v&agrave; giao tiếp m&agrave; kh&ocirc;ng sợ bị người kh&aacute;c ph&aacute;t hiện.</p>
<p><img src="/photos/shares/veneer-su-gia-bao-nhieu-1.jpg" alt="" width="600" height="437" /></p>
<p><em>Mặt d&aacute;n&nbsp;răng&nbsp;sứ Veneer được thiết kế kh&aacute; mỏng n&ecirc;n kh&aacute; thoải m&aacute;i khi ăn nhai, kh&ocirc;ng lo cộm cấn</em></p>
<p><strong><img class="alignnone size-full wp-image-26933 lazyloaded" src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" alt="tick-3" width="22" height="24" data-lazy-src="https://benhvienranghammat.com.vn/wp-content/uploads/2016/06/tick-3.jpg" />&nbsp;Tuổi thọ cao</strong></p>
<p>Tuổi thọ của mặt d&aacute;n sứ Veneer c&oacute; thể k&eacute;o d&agrave;i từ 10 &ndash; 15 năm nếu được chăm s&oacute;c v&agrave; bảo vệ đ&uacute;ng c&aacute;ch.&nbsp; B&ecirc;n cạnh đ&oacute;, mặt d&aacute;n sứ c&ograve;n b&aacute;m&nbsp;chắc tr&ecirc;n th&acirc;n răng, kh&ocirc;ng bị k&ecirc;nh hở, kh&ocirc;ng dễ bị bong, bật khi nhai gắn, chải răng nhờ chất liệu kết d&iacute;nh đặc biệt, kh&ocirc;ng dễ bị h&oacute;a lỏng l&agrave;m rơi miếng d&aacute;n n&ecirc;n bạn c&oacute; thể y&ecirc;n t&acirc;m khi sử dụng.</p>',
                'title' => 'LÀM RĂNG SỨ MẶT DÁN SỨ VENEER – ĐẢM BẢO TÍNH THẨM MỸ CAO',
                'staff_id' => '1',
                'create_date' => '2018-06-19 04:31:27',
            ]);
            News::create([
                'image_header' => 'http://150.95.104.237/assets/images/TreatmentCateImg/TrongImplent.jpg',
                'content' => '<h2 style="color: blue;">TRỒNG RĂNG IMPLANT</h2>
<p><strong>Với sự ph&aacute;t triển của nha khoa hiện nay th&igrave; c&aacute;c bạn sẽ kh&ocirc;ng c&ograve;n lo ngại v&agrave; xấu hổ với những chiếc răng bị mất của m&igrave;nh nữa. Đến với nha khoa của ch&uacute;ng t&ocirc;i c&aacute;c bạn sẽ được tư vấn miễn ph&iacute; bởi c&aacute;c b&aacute;c sĩ c&oacute; nhiều năm kinh nghiệm trong việc&rdquo; trồng răng Implant&rdquo; để c&oacute; được một h&agrave;m răng chắc, khỏe v&agrave; đẹp.</strong></p>
<p><strong>Tuy nhi&ecirc;n, kh&aacute;i niệm &ldquo;trồng răng Implant&rdquo; c&ograve;n rất &iacute;t người biết đến. Vậy trồng răng Implant l&agrave; g&igrave;? Kĩ thuật trồng răng Implant&nbsp;l&agrave; việc phục hồi răng bị mất bằng việc cắm v&iacute;t Implant v&agrave;o trong xương h&agrave;m l&agrave;m trụ sau đ&oacute; sẽ phục h&igrave;nh m&atilde;o sứ ở tr&ecirc;n để gi&uacute;p lấy lại n&eacute;t thẩm mĩ cũng như giữ vững cấu tr&uacute;c của h&agrave;m răng.T&ugrave;y&nbsp;v&agrave;o t&igrave;nh trạng răng h&agrave;m v&agrave; nhu cầu của mỗi kh&aacute;ch h&agrave;ng, c&aacute;c b&aacute;c sĩ sẽ tư vấn số lượng cũng như vị tr&iacute; cấy gh&eacute;p răng Implant ph&ugrave; hợp cho từng đối tượng. Vậy việc trồng răng Implant sẽ cho bạn những lợi &iacute;ch g&igrave;?</strong></p>
<p><strong>&ndash; Chiếc răng chắc chắn nhất.</strong></p>
<p><strong>&ndash; Chiếc răng bền nhất.</strong></p>
<p><strong>&ndash; Bảo vệ sức khỏe răng miệng triệt để nhất.</strong></p>
<p><strong>&ndash; Phục hồi ho&agrave;n hảo chức năng của một chiếc răng.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Trồng răng Implant</figcaption>
</figure>
<p><strong>Tuy nhi&ecirc;n, muốn c&oacute; một h&agrave;m răng như thế th&igrave; việc đầu ti&ecirc;n bạn cần l&agrave;m đ&oacute; l&agrave; chọn một nha khoa cực k&igrave; uy t&iacute;n. Vậy c&aacute;c bạn sẽ được g&igrave; khi đến với nha khoa của ch&uacute;ng t&ocirc;i?</strong></p>
<ul>
<li><strong>Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm:</strong></li>
</ul>
<p><strong>C&oacute; thể n&oacute;i để nhận x&eacute;t hay đ&aacute;nh gi&aacute; một nha khoa n&agrave;o đ&oacute; th&igrave; việc đầu ti&ecirc;n ta cần quan t&acirc;m đến đ&oacute; l&agrave; yếu tố đội ngũ b&aacute;c sĩ. C&aacute;c b&aacute;c sĩ ở nha khoa ở WeCare đều đ&atilde; c&oacute; rất nhiều kinh nghiệm trong việc phục hồi răng từ đơn giản đến phức tạp v&agrave; hầu như mọi trường hợp cấy gh&eacute;p răng Implant đều th&agrave;nh c&ocirc;ng.</strong></p>
<figure id="attachment_156" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-156 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-768x512.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-1024x682.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-600x400.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2.jpg 1280w" alt="" width="300" height="200" />
<figcaption class="wp-caption-text">Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm</figcaption>
</figure>
<ul>
<li><strong>100% vật liệu được nhập khẩu v&agrave; trải qua kiểm định khắt khe:</strong></li>
</ul>
<p><strong>Nha khoa WeCare c&oacute; khả năng nhập khẩu trực tiếp trụ răng nh&acirc;n tạo Implant ch&iacute;nh h&atilde;ng n&ecirc;n đảm bảo chất lượng răng tốt nhất.</strong></p>
<figure id="attachment_155" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-155 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-768x576.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-600x450.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png.jpg 950w" alt="" width="300" height="225" />
<figcaption class="wp-caption-text"><strong>Vật liệu được nhập khẩu</strong></figcaption>
</figure>
<ul>
<li><strong>M&aacute;y m&oacute;c v&agrave; trang thiết bị hiện đại:</strong></li>
</ul>
<p><strong>Để qu&aacute; tr&igrave;nh trồng răng Implant đạt được kết quả tốt nhất th&igrave; thiết bị hỗ trợ cấy gh&eacute;p răng Implant hiện đại cũng g&oacute;p một phần đ&aacute;ng kể để gi&uacute;p c&aacute;c b&aacute;c sĩ tối ưu được trong thao t&aacute;c, linh hoạt v&agrave; c&oacute; độ t&ugrave;y chỉnh lớn. Trang thiết bị hỗ trợ gh&eacute;p răng ở nha khoa ch&uacute;ng t&ocirc;i rất hiện đại, đ&atilde; được kiểm định kĩ về t&iacute;nh năng hoạt động v&agrave; chất lượng kĩ thuật n&ecirc;n đảm bảo cấy gh&eacute;p an to&agrave;n tuyệt đối, tối ưu ho&agrave;n hảo nhất.</strong></p>
<p><strong>Nhưng để c&oacute; một h&agrave;m răng đẹp v&agrave; chắc khỏe như mong muốn th&igrave; bạn phải trải qua c&aacute;c bước sau đ&acirc;y với c&aacute;c nha sĩ ở WeCare ch&uacute;ng t&ocirc;i:</strong></p>
<ol>
<li>
<h4><strong>Thăm kh&aacute;m v&agrave; chụp phim bằng m&aacute;y X quang:</strong></h4>
</li>
</ol>
<p><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng, t&igrave;nh trạng răng, nướu v&agrave; sức khỏe tổng thể bằng c&aacute;c thao t&aacute;c chụp X-quang, kiểm tra mật độ xương, độ d&agrave;y xương h&agrave;m.</strong></p>
<p><strong>Dựa tr&ecirc;n kết quả khảo s&aacute;t đ&oacute; , b&aacute;c sĩ sẽ t&iacute;nh to&aacute;n được ch&iacute;nh x&aacute;c độ d&agrave;i, k&iacute;ch cỡ, đường k&iacute;nh v&agrave; số ren cho trụ Implant tương th&iacute;ch với đặc điểm cấu tạo xương h&agrave;m bị mất răng. Đ&acirc;y sẽ l&agrave; cơ sở để b&aacute;c sĩ x&aacute;c định x&aacute;c định hướng đi của trụ nh&acirc;n tạo v&agrave; độ n&ocirc;ng s&acirc;u khi cấy gh&eacute;p.</strong></p>
<figure id="attachment_306" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-306 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-768x511.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-1024x681.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-600x399.jpg 600w" alt="" width="300" height="199" />
<figcaption class="wp-caption-text"><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng</strong></figcaption>
</figure>
<ol start="2">
<li>
<h4><strong>B&aacute;c sĩ l&ecirc;n kế hoạch điều trị v&agrave; cấy gh&eacute;p Implant cho răng:</strong></h4>
</li>
</ol>
<p><strong>Khi đ&atilde; c&oacute; đầy đủ những th&ocirc;ng số cơ bản b&aacute;c sĩ sẽ l&ecirc;n kế hoạch điều trị cụ thể với &nbsp;&nbsp;kh&aacute;ch h&agrave;ng. C&ugrave;ng với đ&oacute;, họ sẽ tư vấn về c&aacute;c điều kiện cấy gh&eacute;p Implant v&agrave; mức chi ph&iacute; để kh&aacute;ch h&agrave;ng biết r&otilde;, nếu kh&ocirc;ng c&oacute; vấn đề g&igrave; kh&aacute;c th&igrave; b&aacute;c sĩ sẽ đặt lịch hẹn để cấy gh&eacute;p Implant.</strong></p>
<ol start="3">
<li>
<h4><strong>Thực hiện cấy gh&eacute;p Implant:</strong></h4>
</li>
</ol>
<p><strong>Đến ng&agrave;y hẹn cấy gh&eacute;p bạn phải để t&acirc;m trạng m&igrave;nh thoải m&aacute;i, ăn uống đầy đủ v&agrave; chắc chắn sức khỏe tốt. B&aacute;c sĩ sẽ g&acirc;y t&ecirc; v&ugrave;ng cấy gh&eacute;p cho n&ecirc;n trong thời gian cấy gh&eacute;p bạn sẽ kh&ocirc;ng cảm thấy đau hay kh&oacute; chịu nữa. Sau đ&oacute;, b&aacute;c sĩ sẽ b&oacute;c t&aacute;ch nướu, khoan lỗ tr&ecirc;n xương h&agrave;m để cắm trụ Implant v&agrave;o.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Thực hiện cấy gh&eacute;p Implant</figcaption>
</figure>
<ol start="4">
<li>
<h4><strong>Lấy dấu mẫu h&agrave;m v&agrave; thiết kế răng sứ:</strong></h4>
</li>
</ol>
<p><strong>Bạn lo sợ rằng h&agrave;m răng của bạn sẽ bị trống sau khi cắm trụ Implant v&agrave;o? Kh&ocirc;ng,đừng lo, v&igrave; trước khi cắm trụ Implant v&agrave;o, họ đ&atilde; chuẩn bị răng tạm thời cho bạn, thường l&agrave; h&agrave;m th&aacute;o lắp. Sau một thời gian khi trụ Implant t&iacute;ch hợp trong xương h&agrave;m, b&aacute;c sĩ sẽ phục h&igrave;nh răng sứ l&ecirc;n tr&ecirc;n. Răng tạm sẽ gi&uacute;p bạn ăn nhai, đ&aacute;p ứng việc giao tiếp, sinh hoạt trong qu&aacute; tr&igrave;nh chờ trụ Implant t&iacute;ch hợp với xương h&agrave;m.</strong></p>
<ol start="5">
<li>
<h4><strong>T&aacute;i kh&aacute;m sau khi cấy gh&eacute;p implant:</strong></h4>
</li>
</ol>
<p><strong>Sau khi cấy gh&eacute;p Implant xong, khoảng một tuần- 10 ng&agrave;y sau bạn phải gặp b&aacute;c sĩ để kiểm tra c&aacute;c m&ocirc; nướu xung quanh xem c&oacute; l&agrave;nh lại chưa. B&aacute;c sĩ sẽ chụp phim để kiểm tra khả năng t&iacute;ch hợp Implant v&agrave;o xương như thế n&agrave;o.</strong></p>
<ol start="6">
<li>
<h4><strong>Phục h&igrave;nh răng sứ tr&ecirc;n trụ implant</strong>:</h4>
</li>
</ol>
<p><strong>Thời điểm n&agrave;y l&agrave; sau 3-6 th&aacute;ng cấy gh&eacute;p trụ implant. C&ocirc;ng việc tương tự như khi bọc m&atilde;o răng sứ hay cầu răng th&ocirc;ng thường. B&aacute;c sĩ sẽ tư vấn cho m&igrave;nh loại răng sứ ph&ugrave; hợp như cercon, titan&hellip;T&ugrave;y theo nhu cầu thẩm mĩ v&agrave; chi ph&iacute; của từng người m&agrave; bạn chọn loại răng sứ th&iacute;ch hợp cho m&igrave;nh. Bạn c&oacute; thể đến nha khoa trong 2-4 lần hẹn, t&ugrave;y v&agrave;o số lượng răng sứ m&agrave; thời gian sẽ ch&ecirc;nh lệch.</strong></p>',
                'title' => 'Nghệ thuật tẩy trắng răng công nghệ Úc',
                'staff_id' => '1',
                'create_date' => '2018-06-19 04:31:27',
            ]);
            News::create([
                'image_header' => 'http://150.95.104.237/assets/images/TreatmentCateImg/TayTrangRang.jpg',
                'content' => '<h2 style="color: blue;">TRỒNG RĂNG IMPLANT</h2>
<p><strong>Với sự ph&aacute;t triển của nha khoa hiện nay th&igrave; c&aacute;c bạn sẽ kh&ocirc;ng c&ograve;n lo ngại v&agrave; xấu hổ với những chiếc răng bị mất của m&igrave;nh nữa. Đến với nha khoa của ch&uacute;ng t&ocirc;i c&aacute;c bạn sẽ được tư vấn miễn ph&iacute; bởi c&aacute;c b&aacute;c sĩ c&oacute; nhiều năm kinh nghiệm trong việc&rdquo; trồng răng Implant&rdquo; để c&oacute; được một h&agrave;m răng chắc, khỏe v&agrave; đẹp.</strong></p>
<p><strong>Tuy nhi&ecirc;n, kh&aacute;i niệm &ldquo;trồng răng Implant&rdquo; c&ograve;n rất &iacute;t người biết đến. Vậy trồng răng Implant l&agrave; g&igrave;? Kĩ thuật trồng răng Implant&nbsp;l&agrave; việc phục hồi răng bị mất bằng việc cắm v&iacute;t Implant v&agrave;o trong xương h&agrave;m l&agrave;m trụ sau đ&oacute; sẽ phục h&igrave;nh m&atilde;o sứ ở tr&ecirc;n để gi&uacute;p lấy lại n&eacute;t thẩm mĩ cũng như giữ vững cấu tr&uacute;c của h&agrave;m răng.T&ugrave;y&nbsp;v&agrave;o t&igrave;nh trạng răng h&agrave;m v&agrave; nhu cầu của mỗi kh&aacute;ch h&agrave;ng, c&aacute;c b&aacute;c sĩ sẽ tư vấn số lượng cũng như vị tr&iacute; cấy gh&eacute;p răng Implant ph&ugrave; hợp cho từng đối tượng. Vậy việc trồng răng Implant sẽ cho bạn những lợi &iacute;ch g&igrave;?</strong></p>
<p><strong>&ndash; Chiếc răng chắc chắn nhất.</strong></p>
<p><strong>&ndash; Chiếc răng bền nhất.</strong></p>
<p><strong>&ndash; Bảo vệ sức khỏe răng miệng triệt để nhất.</strong></p>
<p><strong>&ndash; Phục hồi ho&agrave;n hảo chức năng của một chiếc răng.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Trồng răng Implant</figcaption>
</figure>
<p><strong>Tuy nhi&ecirc;n, muốn c&oacute; một h&agrave;m răng như thế th&igrave; việc đầu ti&ecirc;n bạn cần l&agrave;m đ&oacute; l&agrave; chọn một nha khoa cực k&igrave; uy t&iacute;n. Vậy c&aacute;c bạn sẽ được g&igrave; khi đến với nha khoa của ch&uacute;ng t&ocirc;i?</strong></p>
<ul>
<li><strong>Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm:</strong></li>
</ul>
<p><strong>C&oacute; thể n&oacute;i để nhận x&eacute;t hay đ&aacute;nh gi&aacute; một nha khoa n&agrave;o đ&oacute; th&igrave; việc đầu ti&ecirc;n ta cần quan t&acirc;m đến đ&oacute; l&agrave; yếu tố đội ngũ b&aacute;c sĩ. C&aacute;c b&aacute;c sĩ ở nha khoa ở WeCare đều đ&atilde; c&oacute; rất nhiều kinh nghiệm trong việc phục hồi răng từ đơn giản đến phức tạp v&agrave; hầu như mọi trường hợp cấy gh&eacute;p răng Implant đều th&agrave;nh c&ocirc;ng.</strong></p>
<figure id="attachment_156" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-156 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-768x512.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-1024x682.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-600x400.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2.jpg 1280w" alt="" width="300" height="200" />
<figcaption class="wp-caption-text">Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm</figcaption>
</figure>
<ul>
<li><strong>100% vật liệu được nhập khẩu v&agrave; trải qua kiểm định khắt khe:</strong></li>
</ul>
<p><strong>Nha khoa WeCare c&oacute; khả năng nhập khẩu trực tiếp trụ răng nh&acirc;n tạo Implant ch&iacute;nh h&atilde;ng n&ecirc;n đảm bảo chất lượng răng tốt nhất.</strong></p>
<figure id="attachment_155" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-155 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-768x576.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-600x450.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png.jpg 950w" alt="" width="300" height="225" />
<figcaption class="wp-caption-text"><strong>Vật liệu được nhập khẩu</strong></figcaption>
</figure>
<ul>
<li><strong>M&aacute;y m&oacute;c v&agrave; trang thiết bị hiện đại:</strong></li>
</ul>
<p><strong>Để qu&aacute; tr&igrave;nh trồng răng Implant đạt được kết quả tốt nhất th&igrave; thiết bị hỗ trợ cấy gh&eacute;p răng Implant hiện đại cũng g&oacute;p một phần đ&aacute;ng kể để gi&uacute;p c&aacute;c b&aacute;c sĩ tối ưu được trong thao t&aacute;c, linh hoạt v&agrave; c&oacute; độ t&ugrave;y chỉnh lớn. Trang thiết bị hỗ trợ gh&eacute;p răng ở nha khoa ch&uacute;ng t&ocirc;i rất hiện đại, đ&atilde; được kiểm định kĩ về t&iacute;nh năng hoạt động v&agrave; chất lượng kĩ thuật n&ecirc;n đảm bảo cấy gh&eacute;p an to&agrave;n tuyệt đối, tối ưu ho&agrave;n hảo nhất.</strong></p>
<p><strong>Nhưng để c&oacute; một h&agrave;m răng đẹp v&agrave; chắc khỏe như mong muốn th&igrave; bạn phải trải qua c&aacute;c bước sau đ&acirc;y với c&aacute;c nha sĩ ở WeCare ch&uacute;ng t&ocirc;i:</strong></p>
<ol>
<li>
<h4><strong>Thăm kh&aacute;m v&agrave; chụp phim bằng m&aacute;y X quang:</strong></h4>
</li>
</ol>
<p><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng, t&igrave;nh trạng răng, nướu v&agrave; sức khỏe tổng thể bằng c&aacute;c thao t&aacute;c chụp X-quang, kiểm tra mật độ xương, độ d&agrave;y xương h&agrave;m.</strong></p>
<p><strong>Dựa tr&ecirc;n kết quả khảo s&aacute;t đ&oacute; , b&aacute;c sĩ sẽ t&iacute;nh to&aacute;n được ch&iacute;nh x&aacute;c độ d&agrave;i, k&iacute;ch cỡ, đường k&iacute;nh v&agrave; số ren cho trụ Implant tương th&iacute;ch với đặc điểm cấu tạo xương h&agrave;m bị mất răng. Đ&acirc;y sẽ l&agrave; cơ sở để b&aacute;c sĩ x&aacute;c định x&aacute;c định hướng đi của trụ nh&acirc;n tạo v&agrave; độ n&ocirc;ng s&acirc;u khi cấy gh&eacute;p.</strong></p>
<figure id="attachment_306" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-306 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-768x511.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-1024x681.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-600x399.jpg 600w" alt="" width="300" height="199" />
<figcaption class="wp-caption-text"><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng</strong></figcaption>
</figure>
<ol start="2">
<li>
<h4><strong>B&aacute;c sĩ l&ecirc;n kế hoạch điều trị v&agrave; cấy gh&eacute;p Implant cho răng:</strong></h4>
</li>
</ol>
<p><strong>Khi đ&atilde; c&oacute; đầy đủ những th&ocirc;ng số cơ bản b&aacute;c sĩ sẽ l&ecirc;n kế hoạch điều trị cụ thể với &nbsp;&nbsp;kh&aacute;ch h&agrave;ng. C&ugrave;ng với đ&oacute;, họ sẽ tư vấn về c&aacute;c điều kiện cấy gh&eacute;p Implant v&agrave; mức chi ph&iacute; để kh&aacute;ch h&agrave;ng biết r&otilde;, nếu kh&ocirc;ng c&oacute; vấn đề g&igrave; kh&aacute;c th&igrave; b&aacute;c sĩ sẽ đặt lịch hẹn để cấy gh&eacute;p Implant.</strong></p>
<ol start="3">
<li>
<h4><strong>Thực hiện cấy gh&eacute;p Implant:</strong></h4>
</li>
</ol>
<p><strong>Đến ng&agrave;y hẹn cấy gh&eacute;p bạn phải để t&acirc;m trạng m&igrave;nh thoải m&aacute;i, ăn uống đầy đủ v&agrave; chắc chắn sức khỏe tốt. B&aacute;c sĩ sẽ g&acirc;y t&ecirc; v&ugrave;ng cấy gh&eacute;p cho n&ecirc;n trong thời gian cấy gh&eacute;p bạn sẽ kh&ocirc;ng cảm thấy đau hay kh&oacute; chịu nữa. Sau đ&oacute;, b&aacute;c sĩ sẽ b&oacute;c t&aacute;ch nướu, khoan lỗ tr&ecirc;n xương h&agrave;m để cắm trụ Implant v&agrave;o.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Thực hiện cấy gh&eacute;p Implant</figcaption>
</figure>
<ol start="4">
<li>
<h4><strong>Lấy dấu mẫu h&agrave;m v&agrave; thiết kế răng sứ:</strong></h4>
</li>
</ol>
<p><strong>Bạn lo sợ rằng h&agrave;m răng của bạn sẽ bị trống sau khi cắm trụ Implant v&agrave;o? Kh&ocirc;ng,đừng lo, v&igrave; trước khi cắm trụ Implant v&agrave;o, họ đ&atilde; chuẩn bị răng tạm thời cho bạn, thường l&agrave; h&agrave;m th&aacute;o lắp. Sau một thời gian khi trụ Implant t&iacute;ch hợp trong xương h&agrave;m, b&aacute;c sĩ sẽ phục h&igrave;nh răng sứ l&ecirc;n tr&ecirc;n. Răng tạm sẽ gi&uacute;p bạn ăn nhai, đ&aacute;p ứng việc giao tiếp, sinh hoạt trong qu&aacute; tr&igrave;nh chờ trụ Implant t&iacute;ch hợp với xương h&agrave;m.</strong></p>
<ol start="5">
<li>
<h4><strong>T&aacute;i kh&aacute;m sau khi cấy gh&eacute;p implant:</strong></h4>
</li>
</ol>
<p><strong>Sau khi cấy gh&eacute;p Implant xong, khoảng một tuần- 10 ng&agrave;y sau bạn phải gặp b&aacute;c sĩ để kiểm tra c&aacute;c m&ocirc; nướu xung quanh xem c&oacute; l&agrave;nh lại chưa. B&aacute;c sĩ sẽ chụp phim để kiểm tra khả năng t&iacute;ch hợp Implant v&agrave;o xương như thế n&agrave;o.</strong></p>
<ol start="6">
<li>
<h4><strong>Phục h&igrave;nh răng sứ tr&ecirc;n trụ implant</strong>:</h4>
</li>
</ol>
<p><strong>Thời điểm n&agrave;y l&agrave; sau 3-6 th&aacute;ng cấy gh&eacute;p trụ implant. C&ocirc;ng việc tương tự như khi bọc m&atilde;o răng sứ hay cầu răng th&ocirc;ng thường. B&aacute;c sĩ sẽ tư vấn cho m&igrave;nh loại răng sứ ph&ugrave; hợp như cercon, titan&hellip;T&ugrave;y theo nhu cầu thẩm mĩ v&agrave; chi ph&iacute; của từng người m&agrave; bạn chọn loại răng sứ th&iacute;ch hợp cho m&igrave;nh. Bạn c&oacute; thể đến nha khoa trong 2-4 lần hẹn, t&ugrave;y v&agrave;o số lượng răng sứ m&agrave; thời gian sẽ ch&ecirc;nh lệch.</strong></p>',
                'title' => 'Bảo vệ hàm răng chắc khỏe cho trẻ',
                'staff_id' => '1',
                'create_date' => '2018-06-19 04:31:27',
            ]);
            News::create([
                'image_header' => 'http://150.95.104.237/assets/images/TreatmentCateImg/RangSuVEENER.png',
                'content' => '<h2 style="color: blue;">TRỒNG RĂNG IMPLANT</h2>
<p><strong>Với sự ph&aacute;t triển của nha khoa hiện nay th&igrave; c&aacute;c bạn sẽ kh&ocirc;ng c&ograve;n lo ngại v&agrave; xấu hổ với những chiếc răng bị mất của m&igrave;nh nữa. Đến với nha khoa của ch&uacute;ng t&ocirc;i c&aacute;c bạn sẽ được tư vấn miễn ph&iacute; bởi c&aacute;c b&aacute;c sĩ c&oacute; nhiều năm kinh nghiệm trong việc&rdquo; trồng răng Implant&rdquo; để c&oacute; được một h&agrave;m răng chắc, khỏe v&agrave; đẹp.</strong></p>
<p><strong>Tuy nhi&ecirc;n, kh&aacute;i niệm &ldquo;trồng răng Implant&rdquo; c&ograve;n rất &iacute;t người biết đến. Vậy trồng răng Implant l&agrave; g&igrave;? Kĩ thuật trồng răng Implant&nbsp;l&agrave; việc phục hồi răng bị mất bằng việc cắm v&iacute;t Implant v&agrave;o trong xương h&agrave;m l&agrave;m trụ sau đ&oacute; sẽ phục h&igrave;nh m&atilde;o sứ ở tr&ecirc;n để gi&uacute;p lấy lại n&eacute;t thẩm mĩ cũng như giữ vững cấu tr&uacute;c của h&agrave;m răng.T&ugrave;y&nbsp;v&agrave;o t&igrave;nh trạng răng h&agrave;m v&agrave; nhu cầu của mỗi kh&aacute;ch h&agrave;ng, c&aacute;c b&aacute;c sĩ sẽ tư vấn số lượng cũng như vị tr&iacute; cấy gh&eacute;p răng Implant ph&ugrave; hợp cho từng đối tượng. Vậy việc trồng răng Implant sẽ cho bạn những lợi &iacute;ch g&igrave;?</strong></p>
<p><strong>&ndash; Chiếc răng chắc chắn nhất.</strong></p>
<p><strong>&ndash; Chiếc răng bền nhất.</strong></p>
<p><strong>&ndash; Bảo vệ sức khỏe răng miệng triệt để nhất.</strong></p>
<p><strong>&ndash; Phục hồi ho&agrave;n hảo chức năng của một chiếc răng.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Trồng răng Implant</figcaption>
</figure>
<p><strong>Tuy nhi&ecirc;n, muốn c&oacute; một h&agrave;m răng như thế th&igrave; việc đầu ti&ecirc;n bạn cần l&agrave;m đ&oacute; l&agrave; chọn một nha khoa cực k&igrave; uy t&iacute;n. Vậy c&aacute;c bạn sẽ được g&igrave; khi đến với nha khoa của ch&uacute;ng t&ocirc;i?</strong></p>
<ul>
<li><strong>Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm:</strong></li>
</ul>
<p><strong>C&oacute; thể n&oacute;i để nhận x&eacute;t hay đ&aacute;nh gi&aacute; một nha khoa n&agrave;o đ&oacute; th&igrave; việc đầu ti&ecirc;n ta cần quan t&acirc;m đến đ&oacute; l&agrave; yếu tố đội ngũ b&aacute;c sĩ. C&aacute;c b&aacute;c sĩ ở nha khoa ở WeCare đều đ&atilde; c&oacute; rất nhiều kinh nghiệm trong việc phục hồi răng từ đơn giản đến phức tạp v&agrave; hầu như mọi trường hợp cấy gh&eacute;p răng Implant đều th&agrave;nh c&ocirc;ng.</strong></p>
<figure id="attachment_156" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-156 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-768x512.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-1024x682.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-600x400.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2.jpg 1280w" alt="" width="300" height="200" />
<figcaption class="wp-caption-text">Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm</figcaption>
</figure>
<ul>
<li><strong>100% vật liệu được nhập khẩu v&agrave; trải qua kiểm định khắt khe:</strong></li>
</ul>
<p><strong>Nha khoa WeCare c&oacute; khả năng nhập khẩu trực tiếp trụ răng nh&acirc;n tạo Implant ch&iacute;nh h&atilde;ng n&ecirc;n đảm bảo chất lượng răng tốt nhất.</strong></p>
<figure id="attachment_155" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-155 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-768x576.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-600x450.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png.jpg 950w" alt="" width="300" height="225" />
<figcaption class="wp-caption-text"><strong>Vật liệu được nhập khẩu</strong></figcaption>
</figure>
<ul>
<li><strong>M&aacute;y m&oacute;c v&agrave; trang thiết bị hiện đại:</strong></li>
</ul>
<p><strong>Để qu&aacute; tr&igrave;nh trồng răng Implant đạt được kết quả tốt nhất th&igrave; thiết bị hỗ trợ cấy gh&eacute;p răng Implant hiện đại cũng g&oacute;p một phần đ&aacute;ng kể để gi&uacute;p c&aacute;c b&aacute;c sĩ tối ưu được trong thao t&aacute;c, linh hoạt v&agrave; c&oacute; độ t&ugrave;y chỉnh lớn. Trang thiết bị hỗ trợ gh&eacute;p răng ở nha khoa ch&uacute;ng t&ocirc;i rất hiện đại, đ&atilde; được kiểm định kĩ về t&iacute;nh năng hoạt động v&agrave; chất lượng kĩ thuật n&ecirc;n đảm bảo cấy gh&eacute;p an to&agrave;n tuyệt đối, tối ưu ho&agrave;n hảo nhất.</strong></p>
<p><strong>Nhưng để c&oacute; một h&agrave;m răng đẹp v&agrave; chắc khỏe như mong muốn th&igrave; bạn phải trải qua c&aacute;c bước sau đ&acirc;y với c&aacute;c nha sĩ ở WeCare ch&uacute;ng t&ocirc;i:</strong></p>
<ol>
<li>
<h4><strong>Thăm kh&aacute;m v&agrave; chụp phim bằng m&aacute;y X quang:</strong></h4>
</li>
</ol>
<p><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng, t&igrave;nh trạng răng, nướu v&agrave; sức khỏe tổng thể bằng c&aacute;c thao t&aacute;c chụp X-quang, kiểm tra mật độ xương, độ d&agrave;y xương h&agrave;m.</strong></p>
<p><strong>Dựa tr&ecirc;n kết quả khảo s&aacute;t đ&oacute; , b&aacute;c sĩ sẽ t&iacute;nh to&aacute;n được ch&iacute;nh x&aacute;c độ d&agrave;i, k&iacute;ch cỡ, đường k&iacute;nh v&agrave; số ren cho trụ Implant tương th&iacute;ch với đặc điểm cấu tạo xương h&agrave;m bị mất răng. Đ&acirc;y sẽ l&agrave; cơ sở để b&aacute;c sĩ x&aacute;c định x&aacute;c định hướng đi của trụ nh&acirc;n tạo v&agrave; độ n&ocirc;ng s&acirc;u khi cấy gh&eacute;p.</strong></p>
<figure id="attachment_306" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-306 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-768x511.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-1024x681.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-600x399.jpg 600w" alt="" width="300" height="199" />
<figcaption class="wp-caption-text"><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng</strong></figcaption>
</figure>
<ol start="2">
<li>
<h4><strong>B&aacute;c sĩ l&ecirc;n kế hoạch điều trị v&agrave; cấy gh&eacute;p Implant cho răng:</strong></h4>
</li>
</ol>
<p><strong>Khi đ&atilde; c&oacute; đầy đủ những th&ocirc;ng số cơ bản b&aacute;c sĩ sẽ l&ecirc;n kế hoạch điều trị cụ thể với &nbsp;&nbsp;kh&aacute;ch h&agrave;ng. C&ugrave;ng với đ&oacute;, họ sẽ tư vấn về c&aacute;c điều kiện cấy gh&eacute;p Implant v&agrave; mức chi ph&iacute; để kh&aacute;ch h&agrave;ng biết r&otilde;, nếu kh&ocirc;ng c&oacute; vấn đề g&igrave; kh&aacute;c th&igrave; b&aacute;c sĩ sẽ đặt lịch hẹn để cấy gh&eacute;p Implant.</strong></p>
<ol start="3">
<li>
<h4><strong>Thực hiện cấy gh&eacute;p Implant:</strong></h4>
</li>
</ol>
<p><strong>Đến ng&agrave;y hẹn cấy gh&eacute;p bạn phải để t&acirc;m trạng m&igrave;nh thoải m&aacute;i, ăn uống đầy đủ v&agrave; chắc chắn sức khỏe tốt. B&aacute;c sĩ sẽ g&acirc;y t&ecirc; v&ugrave;ng cấy gh&eacute;p cho n&ecirc;n trong thời gian cấy gh&eacute;p bạn sẽ kh&ocirc;ng cảm thấy đau hay kh&oacute; chịu nữa. Sau đ&oacute;, b&aacute;c sĩ sẽ b&oacute;c t&aacute;ch nướu, khoan lỗ tr&ecirc;n xương h&agrave;m để cắm trụ Implant v&agrave;o.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Thực hiện cấy gh&eacute;p Implant</figcaption>
</figure>
<ol start="4">
<li>
<h4><strong>Lấy dấu mẫu h&agrave;m v&agrave; thiết kế răng sứ:</strong></h4>
</li>
</ol>
<p><strong>Bạn lo sợ rằng h&agrave;m răng của bạn sẽ bị trống sau khi cắm trụ Implant v&agrave;o? Kh&ocirc;ng,đừng lo, v&igrave; trước khi cắm trụ Implant v&agrave;o, họ đ&atilde; chuẩn bị răng tạm thời cho bạn, thường l&agrave; h&agrave;m th&aacute;o lắp. Sau một thời gian khi trụ Implant t&iacute;ch hợp trong xương h&agrave;m, b&aacute;c sĩ sẽ phục h&igrave;nh răng sứ l&ecirc;n tr&ecirc;n. Răng tạm sẽ gi&uacute;p bạn ăn nhai, đ&aacute;p ứng việc giao tiếp, sinh hoạt trong qu&aacute; tr&igrave;nh chờ trụ Implant t&iacute;ch hợp với xương h&agrave;m.</strong></p>
<ol start="5">
<li>
<h4><strong>T&aacute;i kh&aacute;m sau khi cấy gh&eacute;p implant:</strong></h4>
</li>
</ol>
<p><strong>Sau khi cấy gh&eacute;p Implant xong, khoảng một tuần- 10 ng&agrave;y sau bạn phải gặp b&aacute;c sĩ để kiểm tra c&aacute;c m&ocirc; nướu xung quanh xem c&oacute; l&agrave;nh lại chưa. B&aacute;c sĩ sẽ chụp phim để kiểm tra khả năng t&iacute;ch hợp Implant v&agrave;o xương như thế n&agrave;o.</strong></p>
<ol start="6">
<li>
<h4><strong>Phục h&igrave;nh răng sứ tr&ecirc;n trụ implant</strong>:</h4>
</li>
</ol>
<p><strong>Thời điểm n&agrave;y l&agrave; sau 3-6 th&aacute;ng cấy gh&eacute;p trụ implant. C&ocirc;ng việc tương tự như khi bọc m&atilde;o răng sứ hay cầu răng th&ocirc;ng thường. B&aacute;c sĩ sẽ tư vấn cho m&igrave;nh loại răng sứ ph&ugrave; hợp như cercon, titan&hellip;T&ugrave;y theo nhu cầu thẩm mĩ v&agrave; chi ph&iacute; của từng người m&agrave; bạn chọn loại răng sứ th&iacute;ch hợp cho m&igrave;nh. Bạn c&oacute; thể đến nha khoa trong 2-4 lần hẹn, t&ugrave;y v&agrave;o số lượng răng sứ m&agrave; thời gian sẽ ch&ecirc;nh lệch.</strong></p>',
                'title' => 'Trồng răng sứ tặng tặng thẻ',
                'staff_id' => '1',
                'create_date' => '2018-06-19 04:31:27',
            ]);
            News::create([
                'image_header' => 'http://150.95.104.237/assets/images/TreatmentCateImg/NiengRang.jpg',
                'content' => '<h2 style="color: blue;">TRỒNG RĂNG IMPLANT</h2>
<p><strong>Với sự ph&aacute;t triển của nha khoa hiện nay th&igrave; c&aacute;c bạn sẽ kh&ocirc;ng c&ograve;n lo ngại v&agrave; xấu hổ với những chiếc răng bị mất của m&igrave;nh nữa. Đến với nha khoa của ch&uacute;ng t&ocirc;i c&aacute;c bạn sẽ được tư vấn miễn ph&iacute; bởi c&aacute;c b&aacute;c sĩ c&oacute; nhiều năm kinh nghiệm trong việc&rdquo; trồng răng Implant&rdquo; để c&oacute; được một h&agrave;m răng chắc, khỏe v&agrave; đẹp.</strong></p>
<p><strong>Tuy nhi&ecirc;n, kh&aacute;i niệm &ldquo;trồng răng Implant&rdquo; c&ograve;n rất &iacute;t người biết đến. Vậy trồng răng Implant l&agrave; g&igrave;? Kĩ thuật trồng răng Implant&nbsp;l&agrave; việc phục hồi răng bị mất bằng việc cắm v&iacute;t Implant v&agrave;o trong xương h&agrave;m l&agrave;m trụ sau đ&oacute; sẽ phục h&igrave;nh m&atilde;o sứ ở tr&ecirc;n để gi&uacute;p lấy lại n&eacute;t thẩm mĩ cũng như giữ vững cấu tr&uacute;c của h&agrave;m răng.T&ugrave;y&nbsp;v&agrave;o t&igrave;nh trạng răng h&agrave;m v&agrave; nhu cầu của mỗi kh&aacute;ch h&agrave;ng, c&aacute;c b&aacute;c sĩ sẽ tư vấn số lượng cũng như vị tr&iacute; cấy gh&eacute;p răng Implant ph&ugrave; hợp cho từng đối tượng. Vậy việc trồng răng Implant sẽ cho bạn những lợi &iacute;ch g&igrave;?</strong></p>
<p><strong>&ndash; Chiếc răng chắc chắn nhất.</strong></p>
<p><strong>&ndash; Chiếc răng bền nhất.</strong></p>
<p><strong>&ndash; Bảo vệ sức khỏe răng miệng triệt để nhất.</strong></p>
<p><strong>&ndash; Phục hồi ho&agrave;n hảo chức năng của một chiếc răng.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Trồng răng Implant</figcaption>
</figure>
<p><strong>Tuy nhi&ecirc;n, muốn c&oacute; một h&agrave;m răng như thế th&igrave; việc đầu ti&ecirc;n bạn cần l&agrave;m đ&oacute; l&agrave; chọn một nha khoa cực k&igrave; uy t&iacute;n. Vậy c&aacute;c bạn sẽ được g&igrave; khi đến với nha khoa của ch&uacute;ng t&ocirc;i?</strong></p>
<ul>
<li><strong>Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm:</strong></li>
</ul>
<p><strong>C&oacute; thể n&oacute;i để nhận x&eacute;t hay đ&aacute;nh gi&aacute; một nha khoa n&agrave;o đ&oacute; th&igrave; việc đầu ti&ecirc;n ta cần quan t&acirc;m đến đ&oacute; l&agrave; yếu tố đội ngũ b&aacute;c sĩ. C&aacute;c b&aacute;c sĩ ở nha khoa ở WeCare đều đ&atilde; c&oacute; rất nhiều kinh nghiệm trong việc phục hồi răng từ đơn giản đến phức tạp v&agrave; hầu như mọi trường hợp cấy gh&eacute;p răng Implant đều th&agrave;nh c&ocirc;ng.</strong></p>
<figure id="attachment_156" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-156 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-300x200.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-768x512.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-1024x682.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2-600x400.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/3-2.jpg 1280w" alt="" width="300" height="200" />
<figcaption class="wp-caption-text">Đội h&igrave;nh b&aacute;c sĩ giỏi chuy&ecirc;n m&ocirc;n v&agrave; c&oacute; nhiều năm kinh nghiệm</figcaption>
</figure>
<ul>
<li><strong>100% vật liệu được nhập khẩu v&agrave; trải qua kiểm định khắt khe:</strong></li>
</ul>
<p><strong>Nha khoa WeCare c&oacute; khả năng nhập khẩu trực tiếp trụ răng nh&acirc;n tạo Implant ch&iacute;nh h&atilde;ng n&ecirc;n đảm bảo chất lượng răng tốt nhất.</strong></p>
<figure id="attachment_155" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-155 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-300x225.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-768x576.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png-600x450.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/2.png.jpg 950w" alt="" width="300" height="225" />
<figcaption class="wp-caption-text"><strong>Vật liệu được nhập khẩu</strong></figcaption>
</figure>
<ul>
<li><strong>M&aacute;y m&oacute;c v&agrave; trang thiết bị hiện đại:</strong></li>
</ul>
<p><strong>Để qu&aacute; tr&igrave;nh trồng răng Implant đạt được kết quả tốt nhất th&igrave; thiết bị hỗ trợ cấy gh&eacute;p răng Implant hiện đại cũng g&oacute;p một phần đ&aacute;ng kể để gi&uacute;p c&aacute;c b&aacute;c sĩ tối ưu được trong thao t&aacute;c, linh hoạt v&agrave; c&oacute; độ t&ugrave;y chỉnh lớn. Trang thiết bị hỗ trợ gh&eacute;p răng ở nha khoa ch&uacute;ng t&ocirc;i rất hiện đại, đ&atilde; được kiểm định kĩ về t&iacute;nh năng hoạt động v&agrave; chất lượng kĩ thuật n&ecirc;n đảm bảo cấy gh&eacute;p an to&agrave;n tuyệt đối, tối ưu ho&agrave;n hảo nhất.</strong></p>
<p><strong>Nhưng để c&oacute; một h&agrave;m răng đẹp v&agrave; chắc khỏe như mong muốn th&igrave; bạn phải trải qua c&aacute;c bước sau đ&acirc;y với c&aacute;c nha sĩ ở WeCare ch&uacute;ng t&ocirc;i:</strong></p>
<ol>
<li>
<h4><strong>Thăm kh&aacute;m v&agrave; chụp phim bằng m&aacute;y X quang:</strong></h4>
</li>
</ol>
<p><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng, t&igrave;nh trạng răng, nướu v&agrave; sức khỏe tổng thể bằng c&aacute;c thao t&aacute;c chụp X-quang, kiểm tra mật độ xương, độ d&agrave;y xương h&agrave;m.</strong></p>
<p><strong>Dựa tr&ecirc;n kết quả khảo s&aacute;t đ&oacute; , b&aacute;c sĩ sẽ t&iacute;nh to&aacute;n được ch&iacute;nh x&aacute;c độ d&agrave;i, k&iacute;ch cỡ, đường k&iacute;nh v&agrave; số ren cho trụ Implant tương th&iacute;ch với đặc điểm cấu tạo xương h&agrave;m bị mất răng. Đ&acirc;y sẽ l&agrave; cơ sở để b&aacute;c sĩ x&aacute;c định x&aacute;c định hướng đi của trụ nh&acirc;n tạo v&agrave; độ n&ocirc;ng s&acirc;u khi cấy gh&eacute;p.</strong></p>
<figure id="attachment_306" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-306 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-300x199.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-768x511.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-1024x681.jpg 1024w, http://nhakhoawecare.com/wp-content/uploads/2018/03/DSC_1459-600x399.jpg 600w" alt="" width="300" height="199" />
<figcaption class="wp-caption-text"><strong>Bệnh nh&acirc;n sẽ được kh&aacute;m tổng qu&aacute;t khoang miệng</strong></figcaption>
</figure>
<ol start="2">
<li>
<h4><strong>B&aacute;c sĩ l&ecirc;n kế hoạch điều trị v&agrave; cấy gh&eacute;p Implant cho răng:</strong></h4>
</li>
</ol>
<p><strong>Khi đ&atilde; c&oacute; đầy đủ những th&ocirc;ng số cơ bản b&aacute;c sĩ sẽ l&ecirc;n kế hoạch điều trị cụ thể với &nbsp;&nbsp;kh&aacute;ch h&agrave;ng. C&ugrave;ng với đ&oacute;, họ sẽ tư vấn về c&aacute;c điều kiện cấy gh&eacute;p Implant v&agrave; mức chi ph&iacute; để kh&aacute;ch h&agrave;ng biết r&otilde;, nếu kh&ocirc;ng c&oacute; vấn đề g&igrave; kh&aacute;c th&igrave; b&aacute;c sĩ sẽ đặt lịch hẹn để cấy gh&eacute;p Implant.</strong></p>
<ol start="3">
<li>
<h4><strong>Thực hiện cấy gh&eacute;p Implant:</strong></h4>
</li>
</ol>
<p><strong>Đến ng&agrave;y hẹn cấy gh&eacute;p bạn phải để t&acirc;m trạng m&igrave;nh thoải m&aacute;i, ăn uống đầy đủ v&agrave; chắc chắn sức khỏe tốt. B&aacute;c sĩ sẽ g&acirc;y t&ecirc; v&ugrave;ng cấy gh&eacute;p cho n&ecirc;n trong thời gian cấy gh&eacute;p bạn sẽ kh&ocirc;ng cảm thấy đau hay kh&oacute; chịu nữa. Sau đ&oacute;, b&aacute;c sĩ sẽ b&oacute;c t&aacute;ch nướu, khoan lỗ tr&ecirc;n xương h&agrave;m để cắm trụ Implant v&agrave;o.</strong></p>
<figure id="attachment_158" class="wp-caption aligncenter" style="text-align: center;"><img class="wp-image-158 size-medium" style="display: block; margin-left: auto; margin-right: auto;" src="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-768x438.jpg 768w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1-600x342.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/03/5-1.jpg 1000w" alt="" width="300" height="171" />
<figcaption class="wp-caption-text">Thực hiện cấy gh&eacute;p Implant</figcaption>
</figure>
<ol start="4">
<li>
<h4><strong>Lấy dấu mẫu h&agrave;m v&agrave; thiết kế răng sứ:</strong></h4>
</li>
</ol>
<p><strong>Bạn lo sợ rằng h&agrave;m răng của bạn sẽ bị trống sau khi cắm trụ Implant v&agrave;o? Kh&ocirc;ng,đừng lo, v&igrave; trước khi cắm trụ Implant v&agrave;o, họ đ&atilde; chuẩn bị răng tạm thời cho bạn, thường l&agrave; h&agrave;m th&aacute;o lắp. Sau một thời gian khi trụ Implant t&iacute;ch hợp trong xương h&agrave;m, b&aacute;c sĩ sẽ phục h&igrave;nh răng sứ l&ecirc;n tr&ecirc;n. Răng tạm sẽ gi&uacute;p bạn ăn nhai, đ&aacute;p ứng việc giao tiếp, sinh hoạt trong qu&aacute; tr&igrave;nh chờ trụ Implant t&iacute;ch hợp với xương h&agrave;m.</strong></p>
<ol start="5">
<li>
<h4><strong>T&aacute;i kh&aacute;m sau khi cấy gh&eacute;p implant:</strong></h4>
</li>
</ol>
<p><strong>Sau khi cấy gh&eacute;p Implant xong, khoảng một tuần- 10 ng&agrave;y sau bạn phải gặp b&aacute;c sĩ để kiểm tra c&aacute;c m&ocirc; nướu xung quanh xem c&oacute; l&agrave;nh lại chưa. B&aacute;c sĩ sẽ chụp phim để kiểm tra khả năng t&iacute;ch hợp Implant v&agrave;o xương như thế n&agrave;o.</strong></p>
<ol start="6">
<li>
<h4><strong>Phục h&igrave;nh răng sứ tr&ecirc;n trụ implant</strong>:</h4>
</li>
</ol>
<p><strong>Thời điểm n&agrave;y l&agrave; sau 3-6 th&aacute;ng cấy gh&eacute;p trụ implant. C&ocirc;ng việc tương tự như khi bọc m&atilde;o răng sứ hay cầu răng th&ocirc;ng thường. B&aacute;c sĩ sẽ tư vấn cho m&igrave;nh loại răng sứ ph&ugrave; hợp như cercon, titan&hellip;T&ugrave;y theo nhu cầu thẩm mĩ v&agrave; chi ph&iacute; của từng người m&agrave; bạn chọn loại răng sứ th&iacute;ch hợp cho m&igrave;nh. Bạn c&oacute; thể đến nha khoa trong 2-4 lần hẹn, t&ugrave;y v&agrave;o số lượng răng sứ m&agrave; thời gian sẽ ch&ecirc;nh lệch.</strong></p>',
                'title' => 'Nạo tủy công nghệ Mỹ - gây tê nhanh chóng',
                'staff_id' => '1',
                'create_date' => '2018-06-19 04:31:27',
            ]);
            Payment::create([
                'prepaid' => '100000',
                'total_price' => '300000',
                'phone' => '1279011097',
                'is_done' => false,
            ]);
            Payment::create([
                'prepaid' => '200000',
                'total_price' => '600000',
                'phone' => '1279011096',
                'is_done' => false,
            ]);
            Payment::create([
                'prepaid' => '150000',
                'total_price' => '600000',
                'phone' => '1279011098',
                'is_done' => false,
            ]);
            Payment::create([
                'prepaid' => '250000',
                'total_price' => '500000',
                'phone' => '1279011099',
                'is_done' => false,
            ]);
            PaymentDetail::create([
                'staff_id' => 3,
                'payment_id' => '1',
                'receptionist_id' => '1',
                'date_create' => '2018-06-13 20:08:18',
                'received_money' => '100000',
            ]);
            PaymentDetail::create([
                'staff_id' => 3,
                'payment_id' => '1',
                'receptionist_id' => '2',
                'date_create' => '2018-06-18 20:08:18',
                'received_money' => '200000',
            ]);
            PaymentDetail::create([
                'staff_id' => 3,
                'payment_id' => '2',
                'receptionist_id' => '2',
                'date_create' => '2018-06-14 20:08:18',
                'received_money' => '200000',
            ]);
            PaymentDetail::create([
                'staff_id' => 3,
                'payment_id' => '2',
                'receptionist_id' => '2',
                'date_create' => '2018-06-19 20:08:18',
                'received_money' => '400000',
            ]);
            PaymentDetail::create([
                'staff_id' => 3,
                'payment_id' => '3',
                'receptionist_id' => '2',
                'date_create' => '2018-06-19 20:08:18',
                'received_money' => '150000',
            ]);
            PaymentDetail::create([
                'staff_id' => 3,
                'payment_id' => '3',
                'receptionist_id' => '2',
                'date_create' => '2018-06-22 20:08:18',
                'received_money' => '450000',
            ]);
            PaymentDetail::create([
                'staff_id' => 3,
                'payment_id' => '4',
                'receptionist_id' => '1',
                'date_create' => '2018-06-22 20:08:18',
                'received_money' => '250000',
            ]);
            PaymentDetail::create([
                'staff_id' => 3,
                'payment_id' => '4',
                'receptionist_id' => '1',
                'date_create' => '2018-06-30 20:08:18',
                'received_money' => '250000',
            ]);

            //Cai nao cung cần:
            Step::create([
                'name' => 'Khám và tư vấn',
                'description' => 'Bác sĩ sẽ khám tổng quát để đánh giá tình hình sức khỏe răng miệng cũng như tình hình trạng răng miệng của bệnh nhân.Sau đó, tư vấn phương pháp điều trị cụ thể.',

            ]);
            Step::create([
                'name' => 'chụp X-quang',
                'description' => 'Bệnh nhân sẽ được chụp X-quang và kiểm tra tình trạng răng miệng, mức độ sâu răng cụ thể để bác sỹ có cơ sở chỉ định việc điều trị sâu răng hay buộc phải nhổ bỏ răng sâu.',

            ]);
            Step::create([
                'name' => 'Vệ sinh khoang miệng',
                'description' => 'Tiến hành vệ sinh vùng khoang miệng để thực hiện các bước điều trị',

            ]);
            //end
            //Cạo vôi răng
            Step::create([
                'name' => 'Cạo vôi răng (scaling)',
                'description' => '   Bác sĩ sử dụng đầu máy siêu âm siêu nhỏ với chuyển động rung của các bước sóng lên toàn bộ bề mặt có mảng bám, vôi răng. Những mảng bám, vôi răng sẽ được loại bỏ nhanh chóng ngay cả khi chúng nằm sâu dưới nướu hay trong các kẽ răng.',

            ]);
            Step::create([
                'name' => 'Đánh bóng răng',
                'description' => 'Sau khi hoàn tất cạo vôi răng, bác sĩ sử dụng cụ và thuốc đánh bóng cho răng, giúp răng không chỉ sạch sẽ mà còn sáng bóng, có khả năng hạn chế sự tích tụ mảng bám sau này.',

            ]);
            //end cao vội răng
            // cạo vôi rang nướu dưới
            Step::create([
                'name' => 'Siêu âm Cavitron BP 8.0',
                'description' => ' Đây là phương pháp lấy cao răng tối ưu nhất hiện nay, được ứng dụng ở tất cả các trung tâm nha khoa lớn trên thế giới:',

            ]);
            //end cạo vôi rang nướu dưới
            //Cắt Nướu
            Step::create([
                'name' => 'Lập phác đồ điều trị',
                'description' => 'Bác sĩ đưa kết quả chụp phim được mô phỏng trên hình ảnh không gian 3 chiều để bệnh nhân có thể hình dung cụ thể tình trạng, sau đó tư vấn về chi phí, thời gian, phương pháp tiến hành…',

            ]);
            Step::create([
                'name' => 'Phẫu thuật cắt nướu',
                'description' => 'Dựa vào phác đồ điều trị đã lập ra, bác sĩ sẽ tiến hành điều trị cho bệnh nhân theo đúng quy trình và kỹ thuật yêu cầu.
',

            ]);
            //end Cắt Nướu
            //nạo túi nha chu
            Step::create([
                'name' => 'Làm sạch sâu (root planing)',
                'description' => 'Còn làm sạch sâu là quá trình làm mịn bề mặt gốc chân răng và loại bỏ bất cứ cấu trúc răng nào bị nhiễm bệnh.',

            ]);
            //end nạo túi nha chu
            //XOANG
            Step::create([
                'name' => 'Tạo hình chất trám',
                'description' => 'bác sĩ sẽ tiến hành đưa vật liệu trám composite vào bề mặt răng nơi vị trí cần trám, sử dụng dụng cụ nha khoa để tạo hình miếng trám sao cho vừa khít với vị trí cần trám đảm bảo thẩm mỹ cho vết trám.',

            ]);
            Step::create([
                'name' => 'chiếu đèn laser hóa cứng miếng trám',
                'description' => 'Sau khi cố định được miếng trám vào vị trí trám bác sĩ sẽ sử dụng bước sóng laser để làm cứng vật liệu trám composite và kết thúc quy trình điều trị. ',

            ]);
            //end XOANG
            //tẩy trắng răng tại phòng
            Step::create([
                'name' => 'Bôi gel bảo vệ nướu',
                'description' => 'Chất gel bảo vệ nướu sẽ được thoa lên vùng tiếp xúc giữa răng và nướu với mục đích không làm tổn thương nướu khi chiếu đèn tẩy trắng. Công đoạn bôi gel che nướu và chiếu đèn sẽ được thực hiện khoảng 2 – 3 lần trong toàn bộ quy trình',

            ]);
            Step::create([
                'name' => 'Phủ gel tẩy trắng răng',
                'description' => 'Sau khi bề mặt răng được vệ sinh sạch, đồng thời lắp dụng cụ che nướu và bảo vệ nướu, bệnh nhân sẽ được phủ lên một lớp gel tẩy trắng dày khoảng 2mm bằng cọ phủ, quy trình này được lặp lại 2 lần. ',

            ]);
            Step::create([
                'name' => 'Tẩy trắng răng bằng đèn Plasma',
                'description' => 'Sau khi bề mặt răng được vệ sinh sạch, đồng thời lắp dụng cụ che nướu và bảo vệ nướu, bệnh nhân sẽ được phủ lên một lớp gel tẩy trắng dày khoảng 2mm bằng cọ phủ, quy trình này được lặp lại 2 lần. ',

            ]);
            Step::create([
                'name' => 'Vệ sinh sau tẩy',
                'description' => 'Sau khi hết thời gian phủ gel, bệnh nhân sẽ được vệ sinh sạch gel tẩy trắng, đánh bóng lại răng bằng bột kim cương và so lại màu sắc răng sau khi tẩy trắng.
',

            ]);
            //end tẩy trắng tại phòng
            // tẩy trắng tại nhà
            Step::create([
                'name' => 'Tạo khay răng bằng nhựa dẻo',
                'description' => 'Bác sĩ sẽ lấy dấu răng của bạn và làm một cặp khay bằng nhựa dẻo vừa khít với răng của bạn',

            ]);

            Step::create([
                'name' => 'Bôi gel tẩy trắng (dành cho tại nhà)',
                'description' => 'gel tẩy trắng răng với hàm lượng Hydrogen Peroxide thấp tại nhà ',

            ]);
            //end tẩy trắng tại nhà
            //post sợi
            Step::create([
                'name' => 'Post Kim Loại',
                'description' => 'Trám răng có chốt cắm bằng kim loại',

            ]);
//            end post soi
//            post kim loai
            Step::create([
                'name' => 'Post Sợi',
                'description' => 'Trám răng có chốt cắm bằng sợi thủy tinh - hạn chế gãy như  chốt kim loại',

            ]);
//            end post kim loai
            // chữa đau răng
            Step::create([
                'name' => 'Chữa đau răng',
                'description' => 'Điều trị nội nha dứt điểm về triệu chứng dau răng do bên trong răng - dưới men trắng  hoặc do tủy , dây thần kinh...',

            ]);
            // end chữa đau răng

            //lấy lại tủy
            Step::create([
                'name' => 'Chữa tủy răng ( lấy lại tủy)',
                'description' => 'Đây là một quy trình chữa tủy răng cho các răng đã được chữa tủy rồi nhưng vẫn còn các triệu chứng đau, khó chịu hay răng không có triệu chứng gì nhưng chất lượng nội nha không đạt yêu cầu.',

            ]);
            //end lấy lại tủy

            //nhổ răng
            Step::create([
                'name' => 'Gây tê',
                'description' => 'Tại vị trí răng sâu cần nhổ, bác sỹ sẽ gây tê để bệnh nhân không cảm thấy đau đớn và thoải mái trong khi bác sỹ nhổ răng.',

            ]);
            Step::create([
                'name' => 'Nhổ răng sâu',
                'description' => 'Bác sỹ sẽ sử dụng dụng cụ để nạy nướu, làm răng lung lay, sau đó dùng kìm nha khoa để nhổ răng và lấy toàn bộ chân răng ra. Sau đó, bác sỹ tiến hành khâu lại vết nhổ và cầm máu.',

            ]);
            Step::create([
                'name' => 'Tiểu phẩu',
                'description' => 'Phẩu thuật nhỏ không cần gây mê mà chỉ cần gây tê tại chổ.Trước khi tiểu khẩu cần xét nghiệm máu và đảm bảo khả năng đông của máu',

            ]);
            // end nhổ răng
            // dinh hình răng
            Step::create([
                'name' => 'MÃO SỨ KL THƯỜNG',
                'description' => 'Mão kim loại gồm có các loại mão được làm từ các chất liệu : kim loại quý như vàng, ',

            ]);
            Step::create([
                'name' => 'MÃO SỨ TITAN',
                'description' => 'Mão kim loại gồm có các loại mão được làm từ các chất liệu TITAN',

            ]);
            Step::create([
                'name' => 'MÃO SỨ ZIRCONIA',
                'description' => 'Mão kim loại gồm có các loại mão được làm từ các chất liệu SỨ ZIRCONIA',

            ]);
            Step::create([
                'name' => 'MÃO SỨ LAVA',
                'description' => 'Mão kim loại gồm có các loại mão được làm từ các chất liệu SỨ LAVA ',

            ]);
           
            Step::create([
                'name' => 'VENEER',
                'description' => 'Mão kim loại gồm có các loại mão được làm từ các chất liệu VENEER',

            ]);
            Step::create([
                'name' => 'MÃO SỨ CERCON',
                'description' => 'Mão kim loại gồm có các loại mão được làm từ các chất liệu SỨ CERCON',

            ]);
            Step::create([
                'name' => 'Mài cùi & làm khuông',
                'description' => 'Thực hiện mài cùi răng để tạo khung với tỉ lệ chính xác.Sau đó bắt đầu tạo khung và lấy dấu răng.Sau đó gửi về trung tâm Lab để thiết kế với kích thước và chất liệu phù hợp ,',

            ]);
            Step::create([
                'name' => 'Lắp răng sứ',
                'description' => 'Tiến hành lắp ráp mẫu răng mới cho khách hàng và điều chỉnh cho thích hợp. ',

            ]);
//            end dinh hinh rang


            //ham nhua rang VN
            Step::create([
                'name' => 'Lắp ráp & hoàn thiện',
                'description' => 'Lắp ráp khung răng cho khách hàng',

            ]);
            Step::create([
                'name' => 'Mài cùi & làm khuông HÀM NHỰA & RĂNG NHỰA VIỆT NAM',
                'description' => 'Thực hiện mài cùi răng để tạo khung với tỉ lệ chính xác.Sau đó bắt đầu tạo khung và lấy dấu răng.Sau đó gửi về trung tâm Lab để thiết kế với kích thước và chất liệu phù hợp ,',

            ]);
            Step::create([
                'name' => 'Mài cùi & làm khuông HÀM NHỰA & RĂNG COMPOSITE  ',
                'description' => 'Thực hiện mài cùi răng để tạo khung với tỉ lệ chính xác.Sau đó bắt đầu tạo khung và lấy dấu răng.Sau đó gửi về trung tâm Lab để thiết kế với kích thước và chất liệu phù hợp ,',

            ]);
            Step::create([
                'name' => 'Mài cùi & làm khuông HÀM NHỰA & RĂNG SỨ  ',
                'description' => 'Thực hiện mài cùi răng để tạo khung với tỉ lệ chính xác.Sau đó bắt đầu tạo khung và lấy dấu răng.Sau đó gửi về trung tâm Lab để thiết kế với kích thước và chất liệu phù hợp ,',

            ]);
            //end


            //Trám
//            Step::create([
//                'name' => 'Sửa soạn răng hỏng và xử lý bệnh lý',
//                'description' => 'Sau khi được thăm khám, nha sỹ sẽ tiến hành sửa soạn răng hỏng cho bệnh nhân. Xác định ổ bệnh cần nạo vét và sử dụng dụng cụ đã được thanh trùng lấy đi chất bẩn.',
//
//            ]);
//            Step::create([
//                'name' => 'Hàn trám tạm thời',
//                'description' => 'Trong quy trình trám răng bị sâu, nha sỹ trám miếng trám thời lên răng sâu sau khi đó hẹn bạn tái khám để kiểm tra xem ổ sâu đã được nạo vét hết chưa.',
//
//            ]);
//            Step::create([
//                'name' => 'Tái khám và tiến hành trám răng vĩnh viễn',
//                'description' => 'Sau khoảng 1 tuần, nếu vị trí sâu răng không có biểu hiện đau nhức gì tức là khoang sâu đã sạch. Lúc này, nha sỹ sẽ bóc miếng trám tạm thời và dùng vật liệu composite lên răng bệnh trám vĩnh viễn.',
//
//            ]);
//            Step::create([
//                'name' => 'Hoàn thành quá trình điều trị',
//                'description' => 'Bước sau cùng của quy trình trám răng sâu, bác sỹ sẽ tư vấn cho bệnh nhân sau khi thực hiện hàn trám về cách chăm sóc răng miệng và chế độ ăn uống để miếng trám được bền chặt và hạn chế sâu răng tái phát.',
//
//            ]);
            //xxx


            //implant end + xquang
            Step::create([
                'name' => 'Phẫu thuật đặt Implant (tiểu phẫu)',
                'description' => 'Bác sĩ sẽ thực hiện 1 tiểu phẫu để đặt Implant vào xương hàm. Với mỗi Implant sẽ cần 10-15 phút để thực hiện. Với các trường hợp đặt implant vùng răng cửa, ngay sau phẫu thuật bạn sẽ được gắn răng tạm để sử dụng như bình thường .',

            ]);
            Step::create([
                'name' => 'Đặt trụ Implant Mỹ',
                'description' => 'Thông thường sau khoảng 4-6 tháng đặt Implant khách hàng sẽ được đặt lịch hẹn tái khám, chụp phim kiểm tra.
',

            ]);
            Step::create([
                'name' => 'Đặt trụ Implant Hàn Quốc',
                'description' => 'Thông thường sau khoảng 4-6 tháng đặt Implant khách hàng sẽ được đặt lịch hẹn tái khám, chụp phim kiểm tra.
',

            ]);
            Step::create([
                'name' => 'Đặt trụ Implant NOBEL HAY STRAUMAN',
                'description' => 'Thông thường sau khoảng 4-6 tháng đặt Implant khách hàng sẽ được đặt lịch hẹn tái khám, chụp phim kiểm tra.
',

            ]);
            Step::create([
                'name' => 'Phục hình cố định trên Implant - giai đoạn 1',
                'description' => 'Bác sĩ sẽ tiến hành đặt Abutment trên implant và lấy dấu bằng các vật liệu & dụng cụ chuyên biệt cho phục hình trên Implant  đồng thời chọn màu răng sứ cho phù hợp với màu răng tự nhiên của bạn.',

            ]);
            Step::create([
                'name' => 'Phục hình cố định trên Implant - giai đoạn 2',
                'description' => 'sau khi labo đã hoàn tất răng sứ, bác sĩ sẽ thử răng cho bạn và sau đó gắn chặt răng sứ trên Implant bằng ciment hoặc ốc vặn.',
            ]);
            //implant end
            //chinh nha mắc cài
            Step::create([
                'name' => 'Chỉnh nha mắc cài kim loại',
                'description' => 'Niềng răng mắc cài kim loại hay còn được gọi là phương pháp niềng răng truyền thống, giúp khách hàng cải thiện khuyết điểm của hàm răng một cách hiệu quả.
',

            ]);
            Step::create([
                'name' => 'Chỉnh nha mắc cài Sứ',
                'description' => ' Niềng răng mắc cài sứ: Được cải tiến từ mắc cài inox truyền thống nhưng được làm bằng hợp kim sứ và một số vật liệu vô cơ khác.',

            ]);
            Step::create([
                'name' => 'Chỉnh nha mắc cài kim loại tự khóa',
                'description' => 'Niềng răng mắc cài kim loại tự đóng/tự khóa được cải tiến từ mắc cài inox cổ điển, ',

            ]);
            Step::create([
                'name' => 'Chỉnh nha mắc cài sứ tự khóa',
                'description' => 'Phương pháp niềng răng mắc cài sứ tự đóng/tự khóa, có cấu tạo giống với niềng răng mắc cài kim loại và mắc cài sứ thông thường.',

            ]);
            Step::create([
                'name' => 'Chỉnh nha INVISALIGN',
                'description' => 'Chỉnh nha bằng Invisalign đem lại nhiều ưu điểm và thuận tiện cho bệnh nhân như thẩm mỹ cao, dễ vệ sinh, có thể tháo ra trong những dịp quan trọng',

            ]);
//            end chinh nha mac cai

            //treatment_detail_step
            TreatmentStep::create([
                'treatment_id'=>'1',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'1',
                'step_id' =>'4',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'1',
                'step_id' =>'5',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'2',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'2',
                'step_id' =>'6',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'2',
                'step_id' =>'5',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'3',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'3',
                'step_id' =>'5',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'3',
                'step_id' =>'8',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'4',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'4',
                'step_id' =>'4',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'4',
                'step_id' =>'6',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'5',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'5',
                'step_id' =>'9',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'6',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'7',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'6',
                'step_id' =>'10',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'7',
                'step_id' =>'10',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'6',
                'step_id' =>'11',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'7',
                'step_id' =>'11',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'8',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'8',
                'step_id' =>'12',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'8',
                'step_id' =>'13',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'8',
                'step_id' =>'14',
                'description' =>'Chưa có',
            ]);TreatmentStep::create([
                'treatment_id'=>'8',
                'step_id' =>'15',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'9',
                'step_id' =>'16',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'9',
                'step_id' =>'17',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'10',
                'step_id' =>'18',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'11',
                'step_id' =>'19',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'12',
                'step_id' =>'20',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'13',
                'step_id' =>'20',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'14',
                'step_id' =>'20',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'15',
                'step_id' =>'21',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'16',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'16',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'16',
                'step_id' =>'22',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'16',
                'step_id' =>'23',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'17',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'17',
                'step_id' =>'2',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'17',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'17',
                'step_id' =>'22',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'17',
                'step_id' =>'23',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'18',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'18',
                'step_id' =>'2',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'18',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'18',
                'step_id' =>'22',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'18',
                'step_id' =>'23',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'19',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'19',
                'step_id' =>'2',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'19',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'19',
                'step_id' =>'22',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'19',
                'step_id' =>'23',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'20',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'20',
                'step_id' =>'2',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'20',
                'step_id' =>'3',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'20',
                'step_id' =>'22',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'20',
                'step_id' =>'24',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'20',
                'step_id' =>'23',
                'description' =>'Chưa có',
            ]);
//            --------------
            TreatmentStep::create([
                'treatment_id'=>'21',
                'step_id' =>'31',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'21',
                'step_id' =>'25',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'21',
                'step_id' =>'32',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'22',
                'step_id' =>'31',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'22',
                'step_id' =>'26',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'22',
                'step_id' =>'32',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'23',
                'step_id' =>'31',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'23',
                'step_id' =>'27',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'23',
                'step_id' =>'32',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'24',
                'step_id' =>'31',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'24',
                'step_id' =>'28',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'24',
                'step_id' =>'32',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'25',
                'step_id' =>'31',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'25',
                'step_id' =>'29',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'25',
                'step_id' =>'32',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'26',
                'step_id' =>'31',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'26',
                'step_id' =>'30',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'26',
                'step_id' =>'32',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'29',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'29',
                'step_id' =>'37',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'29',
                'step_id' =>'36',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'30',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'30',
                'step_id' =>'38',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'30',
                'step_id' =>'36',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'31',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'31',
                'step_id' =>'39',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'31',
                'step_id' =>'36',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'32',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'32',
                'step_id' =>'40',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'32',
                'step_id' =>'42',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'32',
                'step_id' =>'45',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'32',
                'step_id' =>'46',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'33',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'33',
                'step_id' =>'40',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'33',
                'step_id' =>'41',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'33',
                'step_id' =>'45',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'33',
                'step_id' =>'46',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'34',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'34',
                'step_id' =>'40',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'34',
                'step_id' =>'43',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'34',
                'step_id' =>'45',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'34',
                'step_id' =>'46',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'35',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'35',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'35',
                'step_id' =>'43',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'36',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'36',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'36',
                'step_id' =>'44',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'37',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'37',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'37',
                'step_id' =>'45',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'38',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'38',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'38',
                'step_id' =>'46',
                'description' =>'Chưa có',
            ]);
            //--------------
            TreatmentStep::create([
                'treatment_id'=>'39',
                'step_id' =>'1',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'39',
                'step_id' =>'7',
                'description' =>'Chưa có',
            ]);
            TreatmentStep::create([
                'treatment_id'=>'39',
                'step_id' =>'47',
                'description' =>'Chưa có',
            ]);

            //end
            Event::create([
                'name' => 'Khuyến Mãi Trám răng',
                'start_date' => '2018-06-15 20:08:18',
                'end_date' => '2018-07-15 20:08:18',
                'discount' => '20',
                'staff_id' => 1,
                'create_date' => Carbon::now(),
                'treatment_id' => 1,
            ]);
            Event::create([
                'name' => 'Khuyến Mãi Trám răng',
                'start_date' => '2018-06-15 20:08:18',
                'end_date' => '2018-06-17 20:08:18',
                'discount' => '30',
                'staff_id' => 1,
                'create_date' => Carbon::now(),
                'treatment_id' => 1,
            ]);
            Event::create([
                'name' => 'Khuyến Mãi Trám răng',
                'start_date' => '2018-06-15 20:08:18',
                'end_date' => '2018-07-15 20:08:18',
                'discount' => '20',
                'staff_id' => 1,
                'create_date' => Carbon::now(),
                'treatment_id' => 2,
            ]);


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    public function index()
    {
        return view('admin.CalendarUser.ManageCalendar');
    }

    public function action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('tbl_patients')
                    ->where('phone', 'like', '%'.$query.'%')
                    ->orderBy('phone', 'desc')
                    ->get();

            }

            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td>'.$row->address.'</td>
         <td>'.$row->phone.'</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }


}
