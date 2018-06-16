<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Appointment;
use App\Model\Patient;
use App\Model\Role;
use App\Model\Staff;
use App\Model\Step;
use App\Model\TreatmentDetail;
use App\Model\TreatmentDetailStep;
use App\Model\TreatmentHistory;
use App\Model\User;
use App\Model\UserHasRole;
use App\Model\Treatment;
use App\Model\TreatmentCategory;
use App\Model\Tooth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    use UserBusinessFunction;

    //

    public function loginGet(Request $request)
    {
        $sessionUser = $request->session()->get('role', -1);
        if ($sessionUser != -1) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6'
        ]);
        $user = $this->checkLogin($request->phone, $request->password);
        if ($user != null) {
            $roleID = $user->hasUserHasRole()->first()->belongsToRole()->first()->id;
            if ($roleID < 3 and $roleID > 0) {
                session(['currentAdmin' => $user]);
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->back()->with('fail', '* You do not have permission for this page')->withInput($request->only('phone'));
        }
        return redirect()->back()->with('fail', '* Wrong phone number or password')->withInput($request->only('phone'));
    }

    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->remove('role');
        return redirect()->route('admin.login');
    }

    public function initData()
    {
        DB::beginTransaction();
        try {
            User::create([
                'phone' => '01279011096',
                'password' => Hash::make('#2017#'),
                'isDeleted' => false
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
                'isDeleted' => false
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
                'isDeleted' => false
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
                'isDeleted' => false
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
                'name' => 'INVISALGN( KHÔNG MẮC CÀI)',
                'description' => 'INVISALGN( KHÔNG MẮC CÀI)',
                'treatment_category_id' => '8',
                'min_price' => '88000000',
                'max_price' => '115000000',
            ]);

            TreatmentCategory::create([
                'name' => 'Nha Chu',
                'description' => 'Nha chu là tổ chức xung quanh răng, chức năng chính là chống đỡ và giữ răng trong xương hàm. Răng khỏe mạnh được giữ trong xương hàm bởi xương ổ răng, dây chằng và nướu răng.',
                'icon_link' => '/assets/images/icon/bocrangsu.png',
                'created_at' => '2018-06-13 00:00:00',
                'updated_at' => '2018-06-03 00:00:00',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'Trám Răng',
                'description' => ' XXX',
                'icon_link' => '/assets/images/icon/tramrangthammy.png',
                'created_at' => '2018-06-13 00:00:00',
                'updated_at' => '2018-06-03 00:00:00',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'Nội Nha ',
                'description' => 'phương pháp điều trị ở bên trong của răng. Bên trong răng, dưới men trắng và một lớp cứng gọi là ngà răng, là một mô mềm gọi là tủy răng. Tủy răng chứa các mạch máu, dây thần kinh, và mô liên kết  ',
                'icon_link' => '/assets/images/icon/caovoirang.png',
                'created_at' => '2018-06-13 00:00:00',
                'updated_at' => '2018-06-03 00:00:00',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => ' Nhổ Răng',
                'description' => 'Nhổ răng khó là những răng mọc lệch, răng ngầm, răng khôn bị tai biến, răng bị gẫy chân, răng dính khớp..',
                'icon_link' => '/assets/images/icon/nhorang.png',
                'created_at' => '2018-06-13 00:00:00',
                'updated_at' => '2018-06-03 00:00:00',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'PHỤC HÌNH CỐ ĐỊNH',
                'description' => 'Phục hình cố định (răng giả cố định) là các loại phục hình – răng giả (mão – cầu răng sứ, mão – cầu răng kim loại…) được gắn cố định vào hàm, miệng người mang.  ',
                'icon_link' => '/assets/images/icon/ranggiathaolap.png',
                'created_at' => '2018-06-13 00:00:00',
                'updated_at' => '2018-06-03 00:00:00',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'PHỤC HÌNH THÁO LẮP ',
                'description' => 'Phục hình tháo lắp, cụ thể là phục hình tháo lắp răng là phương pháp phục hồi các răng hư tổn, để tái tạo các chức năng của răng. Hay phục hình tháo lắp có thể hiểu là sử dụng răng giả để tháo lắp. Bạn có thể cho răng vào và lấy ra dễ dàng để vệ sinh răng',
                'icon_link' => '/assets/images/icon/taytrangrang.png',
                'created_at' => '2018-06-13 00:00:00',
                'updated_at' => '2018-06-03 00:00:00',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'IMPLANT (BAO GỒM PHỤC HÌNH) ',
                'description' => 'Cấy ghép răng Implant nha khoa là phương pháp phục hình răng tốt nhất cho người bị mất răng, đảm bảo khả năng ăn nhai giống hoàn toàn như một chiếc răng bình thường.',
                'icon_link' => '/assets/images/icon/trongimplent.png',
                'created_at' => '2018-06-13 00:00:00',
                'updated_at' => '2018-06-03 00:00:00',
                'estimate_time' => '3'
            ]);
            TreatmentCategory::create([
                'name' => 'CHỈNH NHA',
                'description' => 'Chỉnh nha là một nhánh của ngành nha khoa giúp điều chỉnh vị trí của hàm và những răng sai lệch. Những răng bị lệch lạc và những răng không vừa khít với khuôn miệng. ',
                'icon_link' => '/assets/images/icon/danmatsuVENNER.png',
                'created_at' => '2018-06-13 00:00:00',
                'updated_at' => '2018-06-03 00:00:00',
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
                'tooth_name' => 'Răng số 1 hàm dưới trái (Trẻ em) - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '52',
                'tooth_name' => 'Răng số 1 hàm dưới trái (Trẻ em) - Răng cửa'
            ]);
            Tooth::create([
                'tooth_number' => '53',
                'tooth_name' => 'Răng số 3 hàm dưới trái - Răng Nanh'
            ]);
            Tooth::create([
                'tooth_number' => '54',
                'tooth_name' => 'Răng số 4 hàm dưới trái - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '55',
                'tooth_name' => 'Răng số 5 hàm dưới trái - Răng cối nhỏ'
            ]);
            Tooth::create([
                'tooth_number' => '56',
                'tooth_name' => 'Răng số 6 hàm dưới trái - Răng cối lớn'
            ]);


            Appointment::create([
                'date_booking' => '2018-06-29',
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'start_time' => '2018-07-21 10:05:42',
            ]);
            Appointment::create([
                'date_booking' => '2018-06-29',
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'start_time' => '2018-06-22 10:05:42',
            ]);
            Appointment::create([
                'date_booking' => '2018-06-29',
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'start_time' => '2018-06-24 12:05:42',
            ]);
            Appointment::create([
                'date_booking' => '2018-06-29',
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'start_time' => '2018-06-28 10:05:42',
            ]);
            Appointment::create([
                'date_booking' => '2018-06-29',
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'start_time' => '2018-06-27 10:05:42',
            ]);
            Appointment::create([
                'date_booking' => '2018-06-29',
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'start_time' => '2018-06-26 11:05:42',
            ]);
            Appointment::create([
                'date_booking' => '2018-06-29',
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'start_time' => '2018-06-22 19:05:42',
            ]);
            Appointment::create([
                'date_booking' => '2018-06-29',
                'note' => 'demo data',
                'estimated_time' => '00:00:30',
                'numerical_order' => '12',
                'phone' => '0915469963',
                'start_time' => '2018-06-27 16:05:42',
            ]);

            Step::create([
                'name' => 'Trám Răng',
                'description' => 'Là Trám Răng đó ba'
            ]);
            Step::create([
                'name' => 'Nhổ Răng',
                'description' => 'Là Nhổ Răng đó ba'
            ]);
            Step::create([
                'name' => 'Tẩy răng',
                'description' => 'Là Tẩy răng đó ba'
            ]);

            Patient::create([
                'name' => 'Nguyễn Huỳnh Tài',
                'address' => '188 Nguyễn xí',
                'phone' => '01279011096',
                'date_of_birth' => '1996-10-01',
                'gender' => 'male',
                'district_id' => 1,
            ]);

            Patient::create([
                'name' => 'Huỳnh Võ Thiên Phúc',
                'address' => '188 Cầu xí',
                'phone' => '01279011096',
                'date_of_birth' => '1996-10-02',
                'gender' => 'female',
                'district_id' => 1,
                'is_parent' => 0
            ]);

            Patient::create([
                'name' => 'Nhiêu Sĩ Lực',
                'address' => '188 Cầu Đường',
                'phone' => '01279011097',
                'date_of_birth' => '1996-10-03',
                'gender' => 'female',
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
                'dentist_id' => 1,
                'create_date' => Carbon::now(),
                'note' => 'DEF'
            ]);
            TreatmentDetailStep::create([
                'treatment_detail_id' => 1,
                'treatment_step_id' => 1,
                'description' => 'cho phuc'
            ]);

            TreatmentDetail::create([
                'treatment_history_id' => 1,
                'dentist_id' => 1,
                'create_date' => Carbon::now(),
                'note' => 'DEF'
            ]);
            TreatmentDetailStep::create([
                'treatment_detail_id' => 2,
                'treatment_step_id' => 2,
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
                'dentist_id' => 2,
                'create_date' => Carbon::now(),
                'note' => 'DEF'
            ]);
            TreatmentDetailStep::create([
                'treatment_detail_id' => 3,
                'treatment_step_id' => 1,
                'description' => 'cho phuc'
            ]);

            TreatmentDetail::create([
                'treatment_history_id' => 2,
                'dentist_id' => 1,
                'create_date' => Carbon::now(),
                'note' => 'DEF'
            ]);
            TreatmentDetailStep::create([
                'treatment_detail_id' => 4,
                'treatment_step_id' => 2,
                'description' => 'cho phuc'
            ]);

            Staff::create([
                'name' => 'Nguyễn Huỳnh Tài Dentist',
                'degree' => 'Chịch',
                'address' => '188 Nguyễn xí',
                'district_id' => 1,
                'phone' => '01279011096',
                'date_of_birth' => '1996-10-01',
                'gender' => 'male',
            ]);
            Appointment::create([
                'start_time' => Carbon::now(),
                'note' => 'dume lo di kham di',
                'phone' => '01279011096',
                'number_order' => '1',
                'estimated_time' => '30'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
