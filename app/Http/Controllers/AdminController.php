<?php

namespace App\Http\Controllers;

use App\Model\Role;
use App\Model\User;
use App\Model\Treatment_category;
use App\Model\Treatment;
use App\Model\Staff;
use App\Model\Tooth;
use App\Model\User_has_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Auth;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admins', ['except' => ['logout']]);
    }

    //
    public function checkSessionLogin(Request $request)
    {
        $sessionUser = $request->session()->get('idAdmin', 'default');
        if ($sessionUser == 'default') {
            return view('admin.login');
        } else {
            return view('admin.dashboard');
        }
    }

    public function checkLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('admins')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            // if successful, then redirect to their intended location
//            dd(Auth::guard('admins')->user()->has_role()->first()->Role()->first()->name);
            session(['admin' => Auth::guard('admins')->user()]);
            if (Auth::guard('admins')->user()->hasRole()->first()->getRole()->first()->id != 1) {
                return redirect()->back()->with('fail', '* You do not have permission for this page')->withInput($request->only('phone'));
            }
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->back()->with('fail', '* Wrong phone number or password')->withInput($request->only('phone'));
    }

    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->remove('admin');
        return redirect()->route('checkSessionLogin');
    }

    public function initAdmin()
    {
        User::create([
            'phone' => '01279011096',
            'password' => Hash::make('#2017#'),
            'isActive' => true,
            'isDelete' => false
        ]);
        User_has_role::create([
            'phone' => '01279011096',
            'role_id' => 1,
            'role_start_time' => Carbon::now(),
            'role_end_time' => null
        ]);
        Role::create([
            'id' => '1',
            'name' => 'Administrator',
            'description' => 'Administrator of all system',
        ]);

    }

    public function initAdmin2()
    {
        User::create([
            'phone' => '01279011097',
            'password' => Hash::make('#2017#'),
            'isActive' => true,
            'isDelete' => false
        ]);
        User_has_role::create([
            'phone' => '01279011097',
            'role_id' => 2,
            'role_start_time' => Carbon::now(),
            'role_end_time' => null
        ]);
        Role::create([
            'id' => '2',
            'name' => 'Doctor',
            'description' => 'Doctor of dental Clinic',
        ]);
        User::create([
            'phone' => '01279011098',
            'password' => Hash::make('#2017#'),
            'isActive' => true,
            'isDelete' => false
        ]);
        User_has_role::create([
            'phone' => '01279011098',
            'role_id' => 3,
            'role_start_time' => Carbon::now(),
            'role_end_time' => null
        ]);
        Role::create([
            'id' => '3',
            'name' => 'Receptionist',
            'description' => 'Receptionist of dental Clinic',
        ]);

    } 
    public function initTreatment()
    {
        Treatment::create([
            'name' => 'Cạo vôi',
            'description' => 'Cạo vôi răng',
            'treatment_category_id' => '1',
            'min_price' =>'250000',
            'max_price'=>'350000',
        ]);
        Treatment::create([
            'name' => 'Cạo vôi dưới nướu ',
            'description' => 'Cạo vôi dưới nướu ',
            'treatment_category_id' => '1',
            'min_price' =>'500000',
            'max_price'=>'1000000',
        ]);
        Treatment::create([
            'name' => 'Cắt Nướu ',
            'description' => ' Cắt Nướu',
            'treatment_category_id' => '1',
            'min_price' =>'1000000',
            'max_price'=>'1000000',
        ]);
        Treatment::create([
            'name' => 'Phẫu Thuật Nha Chu răng ',
            'description' => 'Phẫu Thuật Nha Chu răng ',
            'treatment_category_id' => '1',
            'min_price' =>'2000000',
            'max_price'=>'2000000',
        ]);
        Treatment::create([
            'name' => 'Nạo Túi Nha Chu ',
            'description' => 'Nạo Túi Nha Chu ',
            'treatment_category_id' => '1',
            'min_price' =>'200000',
            'max_price'=>'200000',
        ]);
        Treatment::create([
            'name' => 'TRÁM RĂNG COMPOSITE XOANG I VÀ V',
            'description' => 'XOANG I VÀ V',
            'treatment_category_id' => '2',
            'min_price' =>'300000',
            'max_price'=>'500000',
        ]);
         Treatment::create([
            'name' => 'TRÁM RĂNG COMPOSITE XOANG II ,III VÀ IV hay Đắt mặt',
            'description' => 'XOANG I VÀ V',
            'treatment_category_id' => '2',
            'min_price' =>'500000',
            'max_price'=>'1000000',
        ]);
        Treatment::create([
            'name' => 'TẨY TRẮNG TẠI PHÒNG KHÁM ',
            'description' => 'TẨY TRẮNG TẠI PHÒNG KHÁM',
            'treatment_category_id' => '2',
            'min_price' =>'2000000',
            'max_price'=>'2000000',
        ]);
        Treatment::create([
            'name' => 'TẨY TRẮNG TẠI PHÒNG Nhà ',
            'description' => 'TẨY TRẮNG TẠI PHÒNG Nhà',
            'treatment_category_id' => '2',
            'min_price' =>'1000000',
            'max_price'=>'1000000',
        ]);
        
        Treatment::create([
            'name' => 'POST TRÁM - POST SỢI',
            'description' => 'POST TRÁM - POST SỢI',
            'treatment_category_id' => '2',
            'min_price' =>'1000000',
            'max_price'=>'1000000',
        ]);
        Treatment::create([
            'name' => 'POST TRÁM - POST KIM LOẠI',
            'description' => 'POST TRÁM - POST KIM LOẠI',
            'treatment_category_id' => '2',
            'min_price' =>'300000',
            'max_price'=>'500000',
        ]);
        Treatment::create([
            'name' => 'RĂNG CỬA',
            'description' => 'RĂNG CỬA',
            'treatment_category_id' => '3',
            'min_price' =>'700000 ',
            'max_price'=>'700000',
        ]);
        Treatment::create([
            'name' => 'RĂNG CỐI NHỎ VÀ RĂNG NANH',
            'description' => 'RĂNG CỐI NHỎ VÀ RĂNG NANH',
            'treatment_category_id' => '3',
            'min_price' =>'900000',
            'max_price'=>'900000',
        ]);
        Treatment::create([
            'name' => 'RĂNG CỐI LỚN',
            'description' => 'RĂNG CỐI LỚN',
            'treatment_category_id' => '3',
            'min_price' =>'1100000',
            'max_price'=>'1100000',
        ]);
        Treatment::create([
            'name' => 'LẤY TỦY LẠI',
            'description' => 'LẤY TỦY LẠI',
            'treatment_category_id' => '3',
            'min_price' =>'300000',
            'max_price'=>'300000',
        ]);
        Treatment::create([
            'name' => 'NHỔ RĂNG SỮA',
            'description' => 'NHỔ RĂNG SỮA',
            'treatment_category_id' => '4',
            'min_price' =>'0',
            'max_price'=>'0',
        ]);
        Treatment::create([
            'name' => 'NHỔ RĂNG CỬA',
            'description' => 'NHỔ RĂNG CỬA',
            'treatment_category_id' => '4',
            'min_price' =>'500000',
            'max_price'=>'500000',
        ]);
        Treatment::create([
            'name' => 'NHỔ RĂNG CỐI NHỎ',
            'description' => 'NHỔ RĂNG CỐI NHỎ',
            'treatment_category_id' => '4',
            'min_price' =>'700000',
            'max_price'=>'700000',
        ]);
        Treatment::create([
            'name' => 'NHỔ RĂNG CỐI LỚN HOẶC RĂNG KHÔN HÀM TRÊN',
            'description' => 'NHỔ RĂNG CỐI LỚN HOẶC RĂNG KHÔN HÀM TRÊN',
            'treatment_category_id' => '4',
            'min_price' =>'1000000',
            'max_price'=>'1500000',
        ]);
        Treatment::create([
            'name' => 'NHỔ RĂNG TIỂU PHẨU',
            'description' => 'NHỔ RĂNG TIỂU PHẨU',
            'treatment_category_id' => '4',
            'min_price' =>'1500000',
            'max_price'=>'2000000',
        ]);
        Treatment::create([
            'name' => 'MÃO SỨ KL THƯỜNG',
            'description' => 'MÃO SỨ KL THƯỜNG',
            'treatment_category_id' => '5',
            'min_price' =>'1500000',
            'max_price'=>'1500000',
        ]);
        Treatment::create([
            'name' => 'MÃO SỨ TITAN',
            'description' => 'MÃO SỨ TITAN',
            'treatment_category_id' => '5',
            'min_price' =>'2500000',
            'max_price'=>'2500000',
        ]);
        Treatment::create([
            'name' => 'MÃO SỨ ZIRCONIA',
            'description' => 'MÃO SỨ ZIRCONIA',
            'treatment_category_id' => '5',
            'min_price' =>'4000000',
            'max_price'=>'4000000',
        ]);
        Treatment::create([
            'name' => 'MÃO SỨ LAVA',
            'description' => 'MÃO SỨ LAVA',
            'treatment_category_id' => '5',
            'min_price' =>'7000000',
            'max_price'=>'7000000',
        ]);
        Treatment::create([
            'name' => 'VENEER',
            'description' => 'VENEER',
            'treatment_category_id' => '5',
            'min_price' =>'6000000',
            'max_price'=>'8000000',
        ]);
        Treatment::create([
            'name' => 'MÃO SỨ CERCON',
            'description' => 'MÃO SỨ CERCON',
            'treatment_category_id' => '5',
            'min_price' =>'5000000',
            'max_price'=>'5000000',
        ]);
        Treatment::create([
            'name' => 'CÙI GIẢ KIM LOẠI',
            'description' => 'CÙI GIẢ KIM LOẠI',
            'treatment_category_id' => '5',
            'min_price' =>'500000',
            'max_price'=>'500000',
        ]);
        Treatment::create([
            'name' => 'CÙI GIẢ SỨ',
            'description' => 'CÙI GIẢ SỨ',
            'treatment_category_id' => '5',
            'min_price' =>'1500000',
            'max_price'=>'1500000',
        ]);
        Treatment::create([
            'name' => 'HÀM NHỰA - RĂNG NHỰA VIỆT NAM',
            'description' => 'HÀM NHỰA RĂNG NHỰA VIỆT NAM',
            'treatment_category_id' => '6',
            'min_price' =>'300000',
            'max_price'=>'300000',
        ]);
         Treatment::create([
            'name' => 'HÀM NHỰA -RĂNG COMPOSITE',
            'description' => 'HÀM NHỰA - RĂNG COMPOSITE',
            'treatment_category_id' => '6',
            'min_price' =>'500000',
            'max_price'=>'500000',
        ]);
          Treatment::create([
            'name' => 'HÀM NHỰA -RĂNG SỨ',
            'description' => 'HÀM NHỰA - RĂNG SỨ',
            'treatment_category_id' => '6',
            'min_price' =>'600000',
            'max_price'=>'600000',
        ]);
         
        Treatment::create([
            'name' => 'DENTIUM HÀN QUỐC',
            'description' => 'DENTIUM HÀN QUỐC',
            'treatment_category_id' => '7',
            'min_price' =>'15400000',
            'max_price'=>'15400000',
        ]);
         Treatment::create([
            'name' => 'DENTIUM MỸ',
            'description' => 'DENTIUM MỸ',
            'treatment_category_id' => '7',
            'min_price' =>'19800000',
            'max_price'=>'19800000',
        ]);
          Treatment::create([
            'name' => 'NOBEL HAY STRAUMAN',
            'description' => 'NOBEL HAY STRAUMAN',
            'treatment_category_id' => '7',
            'min_price' =>'28600000',
            'max_price'=>'28600000',
        ]);

        Treatment::create([
            'name' => 'MẮC CÀI KIM LOẠI',
            'description' => 'MẮC CÀI KIM LOẠI',
            'treatment_category_id' => '8',
            'min_price' =>'30000000',
            'max_price'=>'35000000',
        ]);
        Treatment::create([
            'name' => 'MẮC CÀI SỨ',
            'description' => 'MẮC CÀI SỨ',
            'treatment_category_id' => '8',
            'min_price' =>'40000000',
            'max_price'=>'45000000',
        ]);
        Treatment::create([
            'name' => 'MẮC CÀI KIM LOẠI TỰ KHÓA',
            'description' => 'MẮC CÀI KIM LOẠI TỰ KHÓA',
            'treatment_category_id' => '8',
            'min_price' =>'40000000',
            'max_price'=>'45000000',
        ]);
        Treatment::create([
            'name' => 'MẮC CÀI SỨ',
            'description' => 'MẮC CÀI SỨ',
            'treatment_category_id' => '8',
            'min_price' =>'55000000',
            'max_price'=>'60000000',
        ]);
        Treatment::create([
            'name' => 'INVISALGN( KHÔNG MẮC CÀI)',
            'description' => 'INVISALGN( KHÔNG MẮC CÀI)',
            'treatment_category_id' => '8',
            'min_price' =>'88000000',
            'max_price'=>'115000000',
        ]);
        Tooth::create([
            'tooth_numnber'=>'1.1',
            'name'=>'Răng số 1 hàm trên'
            ]);
    }

    public function initTooth(){

    }
    public function initTreatmentCate()
    {
         
        Treatment_category::create([
            'name' => 'Nha Chu',
            'description' => 'Nha chu là tổ chức xung quanh răng, chức năng chính là chống đỡ và giữ răng trong xương hàm. Răng khỏe mạnh được giữ trong xương hàm bởi xương ổ răng, dây chằng và nướu răng.',
            'icon_link' => '',
            'created_at' => '2018-06-13 00:00:00',
            'updated_at' => '2018-06-03 00:00:00'
        ]);
        Treatment_category::create([
            'name' => 'Trám Răng',
            'description' => ' XXX',
            'icon_link' => '',
            'created_at' => '2018-06-13 00:00:00',
            'updated_at' => '2018-06-03 00:00:00'
        ]);
        Treatment_category::create([
            'name' => 'Nội Nha ',
            'description' => 'phương pháp điều trị ở bên trong của răng. Bên trong răng, dưới men trắng và một lớp cứng gọi là ngà răng, là một mô mềm gọi là tủy răng. Tủy răng chứa các mạch máu, dây thần kinh, và mô liên kết  ',
            'icon_link' => '',
            'created_at' => '2018-06-13 00:00:00',
            'updated_at' => '2018-06-03 00:00:00'
        ]);
        Treatment_category::create([
            'name' => ' Nhổ Răng',
            'description' => 'Nhổ răng khó là những răng mọc lệch, răng ngầm, răng khôn bị tai biến, răng bị gẫy chân, răng dính khớp..',
            'icon_link' => '',
            'created_at' => '2018-06-13 00:00:00',
            'updated_at' => '2018-06-03 00:00:00'
        ]);
        Treatment_category::create([
            'name' => 'PHỤC HÌNH CỐ ĐỊNH',
            'description' => 'Phục hình cố định (răng giả cố định) là các loại phục hình – răng giả (mão – cầu răng sứ, mão – cầu răng kim loại…) được gắn cố định vào hàm, miệng người mang.  ',
            'icon_link' => '',
            'created_at' => '2018-06-13 00:00:00',
            'updated_at' => '2018-06-03 00:00:00'
        ]);
        Treatment_category::create([
            'name' => 'PHỤC HÌNH THÁO LẮP ',
            'description' => 'Phục hình tháo lắp, cụ thể là phục hình tháo lắp răng là phương pháp phục hồi các răng hư tổn, để tái tạo các chức năng của răng. Hay phục hình tháo lắp có thể hiểu là sử dụng răng giả để tháo lắp. Bạn có thể cho răng vào và lấy ra dễ dàng để vệ sinh răng',
            'icon_link' => '',
            'created_at' => '2018-06-13 00:00:00',
            'updated_at' => '2018-06-03 00:00:00'
        ]);
        Treatment_category::create([
            'name' => 'IMPLANT (BAO GỒM PHỤC HÌNH) ',
            'description' => 'Cấy ghép răng Implant nha khoa là phương pháp phục hình răng tốt nhất cho người bị mất răng, đảm bảo khả năng ăn nhai giống hoàn toàn như một chiếc răng bình thường.',
            'icon_link' => '',
            'created_at' => '2018-06-13 00:00:00',
            'updated_at' => '2018-06-03 00:00:00'
        ]);
        Treatment_category::create([
            'name' => 'CHỈNH NHA',
            'description' => 'Chỉnh nha là một nhánh của ngành nha khoa giúp điều chỉnh vị trí của hàm và những răng sai lệch. Những răng bị lệch lạc và những răng không vừa khít với khuôn miệng. ',
            'icon_link' => '',
            'created_at' => '2018-06-13 00:00:00',
            'updated_at' => '2018-06-03 00:00:00'
        ]);

    }
}
