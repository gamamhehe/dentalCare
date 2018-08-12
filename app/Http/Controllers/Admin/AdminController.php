<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Model\Appointment;
use App\Model\AnamnesisCatalog;
use App\Model\City;
use App\Model\District;
use App\Model\Event;
use App\Model\NewsType;
use App\Model\Patient;
use App\Model\PatientOfAppointment;
use App\Model\Role;
use App\Model\Absent;
use App\Model\Staff;
use App\Model\Step;
use App\Model\Symptom;
use App\Model\TreatmentDetail;
use App\Model\TreatmentDetailStep;
use App\Model\TreatmentHistory;
use App\Model\TreatmentStep;
use App\Model\Type;
use App\Model\User;
use App\Model\UserHasRole;
use App\Model\Treatment;
use App\Model\RequestAbsent;
use App\Model\TreatmentCategory;
use App\Model\Tooth;
use App\Model\News;
use App\Model\Medicine;
use App\Model\Payment;
use App\Model\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{
    use UserBusinessFunction;
    use PatientBusinessFunction;

    //


    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    public function initData()
    {
        DB::beginTransaction();
        try {
            $this->initUser();
            $this->initRole();
            $this->initNew();
            $this->initType();
            $this->initAnamnesisCatalog();
            $this->initTreatmentCategory();
            $this->initMedicine();
            $this->initTooth();
            $this->initStep();
            $this->initAddress();
            $this->initUserHasRole();
            $this->initStaff();
            $this->initAppointment();
            $this->initPatient();
            $this->initNewType();
            $this->initPatientOfAppointment();
            $this->initTreatment();
            $this->initPaymentDetail();
            $this->initTreatmentHistory();
            $this->initTreatmentDetail();
            $this->initTreatmentStep();
            $this->initEvent();
            $this->initRequestAbsent();
            $this->initAbsent();
            $this->initTreatmentDetailStep();
            $this->initSymptom();


            $this->initClientToken();

            DB::commit();
        } catch (\Exception $e) {
            Log::info("INIT ERROR: " . $e->getMessage());
            DB::rollback();
            return response()->json($e->getMessage());
        }
    }

    public function initRole()
    {
        Role::create([
            'id' => '1',
            'name' => 'Quản trị viên',
            'description' => 'Quản lí toàn bộ hệ thống',
        ]);
        Role::create([
            'id' => '2',
            'name' => 'Nha Sĩ',
            'description' => 'Nha sĩ là người khám bệnh trực tiếp cho bệnh nhân',
        ]);
        Role::create([
            'id' => '3',
            'name' => 'Tiếp tân',
            'description' => 'Tiếp tân của phòng khám',
        ]);
        Role::create([
            'id' => '4',
            'name' => 'Bệnh nhân',
            'description' => 'Bệnh nhân',
        ]);
    }

    public function initUser()
    {
        User::create([
            'phone' => '01279011096',
            'password' => Hash::make('123123123'),
        ]);
        User::create([
            'phone' => '01279011097',
            'password' => Hash::make('123123123'),
        ]);
        User::create([
            'phone' => '01279011099',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '01279011098',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555777',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555778',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555779',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555780',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555781',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555782',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555783',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555784',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555785',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555786',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555787',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909555788',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909777555',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909777556',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909777557',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909777558',
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '0909777559',
            'password' => Hash::make('123123123'),
        ]);

        //patient
        User::create([
            'phone' => '0915469963', //phúc
            'password' => Hash::make('123123123'),
        ]);

        User::create([
            'phone' => '01685149049',//trịnh
            'password' => Hash::make('123123123'),
        ]);

        //vitual
        User::create([
            'phone' => '0913520187',
            'password' => Hash::make('0913520187'),
        ]);

        User::create([
            'phone' => '0915235776',
            'password' => Hash::make('0915235776'),
        ]);

        User::create([
            'phone' => '0913270058',
            'password' => Hash::make('0913270058'),
        ]);

        User::create([
            'phone' => '0913947554',
            'password' => Hash::make('0913947554'),
        ]);

        User::create([
            'phone' => '0904035045',
            'password' => Hash::make('0904035045'),
        ]);

        User::create([
            'phone' => '0913287146',
            'password' => Hash::make('0913287146'),
        ]);

        User::create([
            'phone' => '01214757979',
            'password' => Hash::make('01214757979'),
        ]);

        User::create([
            'phone' => '0909539588',
            'password' => Hash::make('0909539588'),
        ]);

        User::create([
            'phone' => '0935109545',
            'password' => Hash::make('0935109545'),
        ]);

        User::create([
            'phone' => '0935105105',
            'password' => Hash::make('0935105105'),
        ]);

        User::create([
            'phone' => '01230405077',
            'password' => Hash::make('01230405077'),
        ]);

        User::create([
            'phone' => '0903211462',
            'password' => Hash::make('0903211462'),
        ]);

        User::create([
            'phone' => '0903552741',
            'password' => Hash::make('0903552741'),
        ]);

        User::create([
            'phone' => '0904777652',
            'password' => Hash::make('0904777652'),
        ]);

        User::create([
            'phone' => '0902159753',
            'password' => Hash::make('0902159753'),
        ]);

        User::create([
            'phone' => '0905045789',
            'password' => Hash::make('0905045789'),
        ]);

        User::create([
            'phone' => '0903056987',
            'password' => Hash::make('0903056987'),
        ]);
    }

    public function initSymptom()
    {
        Symptom::create([
            'name' => 'Viêm nha chu',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Viêm lợi',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Viêm loét đau miệng - áp tơ',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Áp xe răng',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Sâu răng',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Răng Ố Vàng',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Đau răng',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Răng ê buốt',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Răng lỏng lẻo hoặc cong lệch',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Răng bị chảy máu lợi',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Răng bị gãy, nứt, vỡ',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Lở miệng',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Hôi miệng',
            'description' => 'Không'
        ]);
        Symptom::create([
            'name' => 'Khô miệng',
            'description' => 'Không'
        ]);
    }

    public function initUserHasRole()
    {
        UserHasRole::create([
            'phone' => '01279011097',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '01279011099',
            'role_id' => 3,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0905045789',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0902159753',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0904777652',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0903552741',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0903211462',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '01230405077',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0935105105',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0935109545',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909539588',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '01214757979',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0913287146',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0904035045',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0913947554',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0913270058',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0915235776',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0913520187',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '01685149049',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0915469963',
            'role_id' => 4,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909777559',
            'role_id' => 3,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909777558',
            'role_id' => 3,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909777557',
            'role_id' => 3,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909777556',
            'role_id' => 3,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909777555',
            'role_id' => 3,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555788',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555787',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555786',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555785',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555784',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555783',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555782',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555781',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555780',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555779',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555778',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '0909555777',
            'role_id' => 2,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '01279011098',
            'role_id' => 3,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        UserHasRole::create([
            'phone' => '01279011096',
            'role_id' => 1,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
    }

    public function initStaff()
    {
        User::create([
            'phone' => '0000000000',
            'password' => Hash::make('123'),
        ]);
        Staff::create([
            'name' => 'Paypal test',
            'degree' => 'Paypal',
            'address' => 'Paypal',
            'district_id' => 16,
            'phone' => '0000000000',
            'date_of_birth' => '1900-01-01',
            'gender' => 'Nam',
            'email' => 'abc@gmail.com'
        ]);
        UserHasRole::create([
            'phone' => '0000000000',
            'role_id' => 3,
            'start_time' => Carbon::now(),
            'end_time' => null
        ]);
        Staff::create([
            'name' => 'Nguyễn Huỳnh Tài Administrator',
            'degree' => 'Thạc Sĩ',
            'address' => '188 Nguyễn xí',
            'district_id' => 1,
            'phone' => '01279011096',
            'date_of_birth' => '1996-10-01',
            'gender' => 'Nữ',
            'email' => 'abc@gmail.com'
        ]);
        Staff::create([
            'name' => 'Võ Công Minh',
            'degree' => 'Thạc Sĩ',
            'address' => '188 Nguyễn Kiệm',
            'district_id' => 1,
            'phone' => '01279011097',
            'date_of_birth' => '1996-10-01',
            'gender' => 'Nữ',
            'email' => 'abasc@gmail.com'
        ]);
        Staff::create([
            'name' => 'Võ Công Minh',
            'degree' => 'Thạc Sĩ',
            'address' => '188 Nguyễn Kiệm',
            'district_id' => 1,
            'phone' => '01279011099',
            'date_of_birth' => '1996-10-01',
            'gender' => 'Nữ',
            'email' => 'abc@gmail.com'
        ]);
        Staff::create([
            'name' => 'Nguyễn Huỳnh Tài Reception',
            'degree' => 'Thạc Sĩ',
            'address' => '188 Nguyễn xí',
            'district_id' => 1,
            'phone' => '01279011098',
            'date_of_birth' => '1996-10-01',
            'gender' => 'Nữ',
            'email' => 'TaiNHReception@dentalgold.com'
        ]);
        //data thật Dental
        Staff::create([
            'name' => 'Huỳnh Văn Tài',
            'degree' => 'Tiến Sĩ - Bác sĩ',
            'address' => '322 Cách Mạng Tháng 8',
            'district_id' => 2,
            'phone' => '0909555777',
            'description' => '<p>Giám đốc hệ thống chuỗi nha khoa Dental Gold</p><p><b>1. Quá trình đào tạo</b> <br> - Bảo vệ Luận án Tiến Sĩ Đại học chuyên ngành Răng hàm mặt năm 2013 <br> - Tu nghiệp tại nước ngoài: Trường Đại học Milan ( Italia), Trường Đại học TelAvil ( Israel), Bologna ( Italia), Đại học mahidol ( Thái lan) <br> - Tốt nghiệp lớp liên đại học Pháp Việt khoá 2006-2008; 2016-2017 về các chuyên ngành nâng cao: Điều trị nội nha, implant, phục hình thẩm mỹ, phẫu thuật nha chu, răng trẻ em, Nắn chỉnh răng</p><p><b>2. Thành tựu nghề nghiệp:</b> <br> - Giám đốc hệ thống chuỗi nha khoa Dental Gold <br> - Thành viên Hiệp hội implant thế giới ( ICOI : International Congress of Oral Implantologists được thành lập từ năm 1972 tại Hoa Kì). Tham gia các hội nghị của ICOI tổ chức tại Mỹ, Mexico… <br> - Thành viên hiệp hội nha sĩ Mĩ ( ADA: American Dental Association ) <br> - Thành viên hiệp hội ITI ( International Team for Implantology): Hiệp hội các nhà cấy ghép Implant do Thuỵ Sĩ đứng ra quy tụ nhiều Bác sĩ cấy ghép implant thế giới sinh hoạt trao đổi kinh nghiệm, đưa ra các đồng thuận trong thực hành implant nha khoa.</p>',
            'date_of_birth' => '1986-12-01',
            'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist11.PNG',
            'gender' => 'Nam',
            'email' => 'TaiHV@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Đàm Ngọc Trâm',
            'degree' => 'Tiến Sĩ - Bác Sĩ',
            'address' => '188 Nguyễn xí',
            'district_id' => 1,
            'phone' => '0909555778',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ nâng cao</p>',
            'date_of_birth' => '1976-10-01',
            'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist12.PNG',
            'gender' => 'Nữ',
            'email' => 'TramDamNgoc@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Thái Quốc Long',
            'degree' => 'Bác Sĩ',
            'address' => '132 Phan Huy Ích',
            'district_id' => 1,
            'phone' => '0909555779',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ &amp; implant nâng cao</p>',
            'date_of_birth' => '1976-08-01',
            'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist13.PNG',
            'gender' => 'Nam',
            'email' => 'LongTQ@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Nguyễn Đắc Minh',
            'degree' => 'Bác Sĩ',
            'address' => '435 Tô Ký',
            'district_id' => 1,
            'phone' => '0909555780',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ &amp; implant nâng cao</p>', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist14.PNG',
            'date_of_birth' => '1975-09-03',
            'gender' => 'Nam',
            'email' => 'MinhND@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Hồ Anh Tuấn',
            'degree' => 'Bác Sĩ',
            'address' => '187 Trường Chinh',
            'district_id' => 1,
            'phone' => '0909555781',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ nâng cao</p>', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist15.PNG',
            'date_of_birth' => '1980-02-03',
            'gender' => 'Nam',
            'email' => 'TuanHA@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Nguyễn Minh Hải',
            'degree' => 'Bác Sĩ',
            'address' => '1021 Tô Hiến Thành',
            'district_id' => 1,
            'phone' => '0909555782',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ &amp; implant nâng cao</p>', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist20.PNG',
            'date_of_birth' => '1977-10-03',
            'gender' => 'Nam',
            'email' => 'HaiNM@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Nguyễn Quang Anh',
            'degree' => 'Thạc Sĩ - Bác Sĩ',
            'address' => '133 Hòa Hảo',
            'district_id' => 1,
            'phone' => '0909555783',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ &amp; implant nâng cao</p>', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist23.PNG',
            'date_of_birth' => '1989-08-01',
            'gender' => 'Nam',
            'email' => 'AnhNQ@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Thái Ngọc Trâm',
            'degree' => 'Bác Sĩ',
            'address' => '133 Kỳ Hòa',
            'district_id' => 1,
            'phone' => '0909555784',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ &amp; implant nâng cao</p>',
            'date_of_birth' => '1976-08-01',
            'gender' => 'Nữ', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist17.PNG',
            'email' => 'TramTN@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Phan Huỳnh Bảo Long',
            'degree' => 'Bác Sĩ',
            'address' => '452 Hòa Hảo',
            'district_id' => 1,
            'phone' => '0909555785',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ nâng cao</p>',
            'date_of_birth' => '1982-08-01',
            'gender' => 'Nam', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentistBoss3.jpg',
            'email' => 'LongPHB@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Nguyễn Hương Giang',
            'degree' => 'Thạc Sĩ -Bác Sĩ',
            'address' => '32 Phan Huy Ích',
            'district_id' => 1,
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ &amp; implant nâng cao</p>',
            'phone' => '0909555786', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist18.PNG',
            'date_of_birth' => '1984-07-03',
            'gender' => 'Nam',
            'email' => 'GiangNH@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Đặng Thị Thơ',
            'degree' => 'Bác Sĩ',
            'address' => '132 Phan Huy Ích',
            'district_id' => 1,
            'phone' => '0909555787',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ nâng cao</p>',
            'date_of_birth' => '1976-08-01',
            'gender' => 'Nữ', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist19.PNG',
            'email' => 'ThoDT@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Nguyễn Quốc Bảo',
            'degree' => 'Bác Sĩ',
            'address' => '177 Phan Huy Ích',
            'district_id' => 1,
            'phone' => '0909555788',
            'description' => '<p><b>Chuyên khoa phục hình thẩm mỹ</b> <br> - Tốt nghiệp chuyên khoa RHM - Đại học Y Hà Nội <br> - Chứng chỉ Hiệp hội nha khoa thẩm mỹ châu ÂU ESCD <br> - Chứng chỉ chuyên ngành phục hình răng sứ &amp; implant nâng cao</p>',
            'date_of_birth' => '1974-11-11',
            'gender' => 'Nam', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentistBoss2.jpg',
            'email' => 'BaoNQ@dentalgold.com.vn'
        ]);
        //reception
        Staff::create([
            'name' => 'Phan Bảo Trâm',
            'degree' => 'Nhân Viên',
            'address' => '227 Phan Huy Ích',
            'district_id' => 1,
            'phone' => '0909777555',
            'date_of_birth' => '1995-11-11',
            'gender' => 'Nữ', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist24.PNG',
            'email' => 'TramPB@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Trần Bảo Ngọc Quỳnh',
            'degree' => 'Nhân Viên',
            'address' => '227 Phan Huy Ích',
            'district_id' => 1,
            'phone' => '0909777556',
            'date_of_birth' => '1995-10-08',
            'gender' => 'Nữ', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist25.PNG',
            'email' => 'QuynhTBN@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Huỳnh Minh Ngọc',
            'degree' => 'Nhân Viên',
            'address' => '227 Phan Huy Ích',
            'district_id' => 1,
            'phone' => '0909777557',
            'date_of_birth' => '1994-08-04',
            'gender' => 'Nữ', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist16.PNG',
            'email' => 'NgocHM@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Phùng Văn Loan',
            'degree' => 'Nhân Viên',
            'address' => '123 Tô Ký',
            'district_id' => 1,
            'phone' => '0909777558',
            'date_of_birth' => '1995-11-11',
            'gender' => 'Nữ', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist21.PNG',
            'email' => 'LoanPV@dentalgold.com.vn'
        ]);
        Staff::create([
            'name' => 'Trần Ngọc Nhung',
            'degree' => 'Nhân Viên',
            'address' => '227 Phan Huy Ích',
            'district_id' => 1,
            'phone' => '0909777559',
            'date_of_birth' => '1995-11-11',
            'gender' => 'Nữ', 'avatar' => 'http://150.95.104.237/assets/images/Dentist/dentist21.PNG',
            'email' => 'NhungTN@dentalgold.com.vn'
        ]);
    }

    public function initTreatment()
    {
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
    }

    public function initTreatmentCategory()
    {
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
    }

    public function initTooth()
    {
        Tooth::create([
            'tooth_number' => '1',
            'tooth_name' => 'Nguyên hàm'
        ]);

        Tooth::create([
            'tooth_number' => '2',
            'tooth_name' => 'Hàm trên'
        ]);
        Tooth::create([
            'tooth_number' => '3',
            'tooth_name' => 'Hàm dưới'
        ]);
        Tooth::create([
            'tooth_number' => '4',
            'tooth_name' => 'Nhiều răng'
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
    }

    public function initPatientOfAppointment()
    {

        PatientOfAppointment::create([
            'appointment_id' => 1,
            'patient_id' => 1
        ]);

        PatientOfAppointment::create([
            'appointment_id' => 2,
            'patient_id' => 3
        ]);

    }

    public function initPatient()
    {

        Patient::create([
            'name' => 'Huỳnh Võ Thiên Phúc',
            'address' => '188 Nguyễn xí',
            'phone' => '0915469963',
            'date_of_birth' => '1995-04-01',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);

        Patient::create([
            'name' => 'Võ Quốc Trịnh',
            'address' => '18 Quang Trung',
            'phone' => '01685149049',
            'date_of_birth' => '1996-10-02',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,

        ]);

        Patient::create([
            'name' => 'Nhiêu Sĩ Lực',
            'address' => '188 Cầu Đường',
            'phone' => '0913520187',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Hoàng Quốc Huynh',
            'address' => '188 Cầu Đường',
            'phone' => '0915235776',
            'date_of_birth' => '1996-10-03',
            'gender' => 'FEMALE',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Đỗ Thụy An',
            'address' => '188 Cống Lỡ',
            'phone' => '0913270058',
            'date_of_birth' => '1996-10-03',
            'gender' => 'FEMALE',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Nguyễn Thị Bình',
            'address' => '188 Cầu Đường',
            'phone' => '0913947554',
            'date_of_birth' => '1996-10-03',
            'gender' => 'FEMALE',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Bành Văn Bình',
            'address' => '188 Tô Ký',
            'phone' => '0904035045',
            'date_of_birth' => '1996-10-03',
            'gender' => 'FEMALE',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Trần Văn An',
            'address' => '188 Cách Mạng Tháng 8',
            'phone' => '0913287146',
            'date_of_birth' => '1996-10-03',
            'gender' => 'FEMALE',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Bành Văn Bình',
            'address' => '188 Cầu Đường',
            'phone' => '01214757979',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nữ',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Nguyễn Thị Na',
            'address' => '188 Cầu Cáp',
            'phone' => '0909539588',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nữ',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Nguyễn Thị Hường',
            'address' => '188 Đồng Đen',
            'phone' => '0935109545',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nữ',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Nguyễn Thị Thơ',
            'address' => '188 Phan Huy Ích',
            'phone' => '0935105105',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nữ',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Trần Văn Tùng',
            'address' => '188 Cầu Đường',
            'phone' => '01230405077',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Huỳnh Văn An',
            'address' => '188 Cầu Tre',
            'phone' => '0903211462',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Trần Khánh Tùng',
            'address' => '188 Tô Thị',
            'phone' => '0903552741',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Nguyễn Gia Bảo',
            'address' => '188 Cầu Đường',
            'phone' => '0904777652',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Nguyễn Tường Vân Nam',
            'address' => '188 Cầu Đường',
            'phone' => '0902159753',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Nguyễn Trung Kiên',
            'address' => '188 Cầu Đường',
            'phone' => '0905045789',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
        Patient::create([
            'name' => 'Trần Thanh Tùng',
            'address' => '179 Huỳnh Lan Khanh',
            'phone' => '0903056987',
            'date_of_birth' => '1996-10-03',
            'gender' => 'Nam',
            'avatar' => 'assets/images/avatar/user_avatar_5.png',
            'district_id' => 1,
        ]);
    }

    public function initTreatmentHistory()
    {

        TreatmentHistory::create([
            'treatment_id' => 1,
            'patient_id' => 1,
            'description' => 'ABC',
            'created_date' => Carbon::now(),
            'finish_date' => Carbon::now(),
            'tooth_number' => '11',
            'price' => 1000000,
            'total_price' => 900000,
            'payment_id' => 1,
        ]);


        TreatmentHistory::create([
            'treatment_id' => 1,
            'patient_id' => 2,
            'description' => 'ABC',
            'created_date' => Carbon::now(),
            'finish_date' => Carbon::now(),
            'tooth_number' => '11',
            'price' => 1000000,
            'total_price' => 900000,
            'payment_id' => 1,
        ]);
    }

    public function initTreatmentDetail()
    {
        TreatmentDetail::create([
            'treatment_history_id' => 2,
            'staff_id' => 1,
            'created_date' => Carbon::now(),
            'note' => 'DEF'
        ]);
        TreatmentDetail::create([
            'treatment_history_id' => 2,
            'staff_id' => 2,
            'created_date' => Carbon::now(),
            'note' => 'DEF'
        ]);
        TreatmentDetail::create([
            'treatment_history_id' => 1,
            'staff_id' => 1,
            'created_date' => Carbon::now(),
            'note' => 'DEF'
        ]);
        TreatmentDetail::create([
            'treatment_history_id' => 1,
            'staff_id' => 1,
            'created_date' => Carbon::now(),
            'note' => 'DEF'
        ]);
    }

    public function initTreatmentDetailStep()
    {
        TreatmentDetailStep::create([
            'treatment_detail_id' => 3,
            'step_id' => 1,
        ]);


        TreatmentDetailStep::create([
            'treatment_detail_id' => 4,
            'step_id' => 2,
        ]);

        TreatmentDetailStep::create([
            'treatment_detail_id' => 1,
            'step_id' => 1,
        ]);


        TreatmentDetailStep::create([
            'treatment_detail_id' => 2,
            'step_id' => 2,
        ]);

    }

    public function initAppointment()
    {


        Appointment::create([
            'note' => 'demo data',
            'estimated_time' => '00:00:30',
            'numerical_order' => '12',
            'phone' => '0915469963',
            'staff_id' => 4,
            'start_time' => '2018-07-21 10:05:42',
        ]);
        Appointment::create([
            'note' => 'demo data',
            'estimated_time' => '00:00:30',
            'numerical_order' => '12',
            'phone' => '0915469963',
            'staff_id' => 2,
            'start_time' => Carbon::now(),
        ]);
        Appointment::create([
            'note' => 'demo data',
            'estimated_time' => '00:00:30',
            'numerical_order' => '12',
            'phone' => '0915469963',
            'staff_id' => 3,
            'start_time' => Carbon::now(),
        ]);
        Appointment::create([
            'note' => 'demo data',
            'estimated_time' => '00:00:30',
            'numerical_order' => '12',
            'phone' => '0915469963',
            'staff_id' => 2,
            'start_time' => Carbon::now(),
        ]);
        Appointment::create([
            'note' => 'demo data',
            'estimated_time' => '00:00:30',
            'numerical_order' => '12',
            'phone' => '0915469963',
            'staff_id' => 3,
            'start_time' => Carbon::now(),
        ]);
        Appointment::create([
            'note' => 'demo data',
            'estimated_time' => '00:00:30',
            'numerical_order' => '12',
            'phone' => '0915469963',
            'staff_id' => 4,
            'start_time' => Carbon::now(),
        ]);
        Appointment::create([
            'note' => 'demo data',
            'estimated_time' => '00:00:30',
            'numerical_order' => '12',
            'phone' => '0915469963',
            'staff_id' => 2,
            'start_time' => Carbon::now(),
        ]);
        Appointment::create([
            'note' => 'demo data',
            'estimated_time' => '00:00:30',
            'numerical_order' => '12',
            'phone' => '0915469963',
            'staff_id' => 3,
            'start_time' => Carbon::now(),
        ]);


        Appointment::create([
            'start_time' => Carbon::now(),
            'note' => 'Khám chi tiết',
            'phone' => '01279011096',
            'staff_id' => 2,
            'numerical_order' => '1',
            'estimated_time' => '00:30:00'
        ]);

    }

    public function initAbsent()
    {
        Absent::create([
            'staff_approve_id' => 2,
            'request_absent_id' => 1,
            'message_from_staff' => 'Chấp Nhận',
            'created_time' => Carbon::now(),
            'is_approved' => 1,
        ]);
        Absent::create([
            'staff_approve_id' => 2,
            'request_absent_id' => 2,
            'message_from_staff' => 'Chấp Nhận, đảm bảo công việc nhé',
            'created_time' => Carbon::now(),
            'is_approved' => 1,
        ]);

    }

    public function initRequestAbsent()
    {
        RequestAbsent::create([
            'staff_id' => 2,
            'start_date' => '2018-06-26',
            'end_date' => '2018-06-28',
            'reason' => 'Đám cưới em trai',
            'is_delete' => '0',
        ]);
        RequestAbsent::create([
            'staff_id' => 7,
            'start_date' => '2018-09-15',
            'end_date' => '2018-09-17',
            'reason' => 'Nghỉ bệnh',
            'is_delete' => '0',
        ]);
        RequestAbsent::create([
            'staff_id' => 5,
            'start_date' => '2018-08-29',
            'end_date' => '2018-08-30',
            'reason' => 'Nghỉ bệnh',
            'is_delete' => '0',
        ]);
        RequestAbsent::create([
            'staff_id' => 9,
            'start_date' => '2018-09-05',
            'end_date' => '2018-09-06',
            'reason' => 'Đám cưới em trai',
            'is_delete' => '0',
        ]);
        RequestAbsent::create([
            'staff_id' => 12,
            'start_date' => '2018-09-14',
            'end_date' => '2018-09-15',
            'reason' => 'Sinh nhật con gái',
            'is_delete' => '0',
        ]);
        RequestAbsent::create([
            'staff_id' => 5,
            'start_date' => '2018-09-18',
            'end_date' => '2018-09-22',
            'reason' => 'Mừng sinh nhật lần 80 của bà nội',
            'is_delete' => '0',
        ]);
        RequestAbsent::create([
            'staff_id' => 4,
            'start_date' => '2018-06-25',
            'end_date' => '2018-07-01',
            'reason' => 'Đám cưới chị gái',
            'is_delete' => '0',
        ]);

    }

    public function initNew()
    {
        News::create([
            'image_header' => 'http://150.95.104.237/photos/shares/Niềng-răng-nên-ăn-gì-nên-kiêng-gì-nha-sỹ-tư-vấn-tuyệt-đối-tuân-thủ-1.jpg',
            'content' => '<p>&nbsp;&nbsp;</p>
<header class="entry-header">
<div class="entry-header-text entry-header-text-top text-center">
<h1 class="entry-title">LỰA CHỌN THỰC PHẨM PH&Ugrave; HỢP KHI NIỀNG RĂNG</h1>
<div class="entry-divider is-divider small">&nbsp;</div>
</div>
<div class="entry-image relative"><a href="http://nhakhoawecare.com/lua-chon-thuc-pham-phu-hop-khi-nieng-rang/"><img class="attachment-large size-large wp-post-image" src="http://nhakhoawecare.com/wp-content/uploads/2018/04/Ni%E1%BB%81ng-r%C4%83ng-n%C3%AAn-%C4%83n-g%C3%AC-n%C3%AAn-ki%C3%AAng-g%C3%AC-nha-s%E1%BB%B9-t%C6%B0-v%E1%BA%A5n-tuy%E1%BB%87t-%C4%91%E1%BB%91i-tu%C3%A2n-th%E1%BB%A7-1.jpg" sizes="(max-width: 600px) 100vw, 600px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/04/Niềng-răng-n&ecirc;n-ăn-g&igrave;-n&ecirc;n-ki&ecirc;ng-g&igrave;-nha-sỹ-tư-vấn-tuyệt-đối-tu&acirc;n-thủ-1.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/04/Niềng-răng-n&ecirc;n-ăn-g&igrave;-n&ecirc;n-ki&ecirc;ng-g&igrave;-nha-sỹ-tư-vấn-tuyệt-đối-tu&acirc;n-thủ-1-300x171.jpg 300w" alt="" width="600" height="342" /></a>
<div class="badge absolute top post-date badge-outline">
<div class="badge-inner">&nbsp;</div>
</div>
</div>
</header>
<div class="entry-content single-page">
<h1><strong>LỰA CHỌN THỰC PHẨM PH&Ugrave; HỢP KHI NIỀNG RĂNG</strong></h1>
<p><strong>WeCare h&ocirc;m nay sẽ c&ugrave;ng với qu&yacute; kh&aacute;ch h&agrave;ng t&igrave;m hiểu về những điều cần lưu &yacute; n&ecirc;n v&agrave; kh&ocirc;ng n&ecirc;n ăn g&igrave; sau khi niềng răng- qu&aacute; tr&igrave;nh sau để tạo n&ecirc;n một h&agrave;m răng đều, đẹp, chắc v&agrave; khỏe.. C&oacute; thể n&oacute;i chế độ ăn uống cũng đ&oacute;ng g&oacute;p vai tr&ograve; rất quan trọng để c&oacute; được một h&agrave;m răng ho&agrave;n hảo như mong muốn.V&igrave; thể muốn răng khỏe, răng xinh h&atilde;y nắm chắc những m&eacute;o nhỏ dưới đ&acirc;y của WeCare nh&eacute;!</strong></p>
<p><img class="size-medium wp-image-380 aligncenter" src="http://nhakhoawecare.com/wp-content/uploads/2018/04/cham-soc-rang-nieng-8886-300x204.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/04/cham-soc-rang-nieng-8886-300x204.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/04/cham-soc-rang-nieng-8886.jpg 600w" alt="" width="300" height="204" /></p>
<h2><strong>Vậy bạn n&ecirc;n d&ugrave;ng những thực phẩm g&igrave; để th&ecirc;m v&agrave;o qu&aacute; tr&igrave;nh niềng răng tốt hơn?</strong></h2>
<p><strong>Điều đầu ti&ecirc;n sau khi bạn niềng răng đ&oacute; l&agrave; bạn n&ecirc;n ăn c&aacute;c loại thức ăn mềm như s&uacute;p, ch&aacute;o, b&aacute;nh m&igrave;, b&aacute;nh xốp mềm,&hellip;để tr&aacute;nh l&agrave;m tổn thương, l&agrave;m lệch h&igrave;nh dạng răng sau khi niềng.</strong></p>
<p><strong>Tr&aacute;nh n&ecirc;n ăn những m&oacute;n cứng như xo&agrave;i, cốc, ổi,&hellip;hay l&agrave; c&aacute;c m&oacute;n d&iacute;nh răng như kẹo cao su, kẹo gummy,&hellip;để tr&aacute;nh trường hợp l&agrave;m hỏng khu&ocirc;n răng sau khi niềng.</strong></p>
<p><strong>Hạn chế ăn những thực phẩm chứa nhiều chất tinh bột. V&igrave; khi ta ăn nhiều loại thức ăn n&agrave;y sẽ tạo n&ecirc;n axit v&agrave; g&acirc;y ra c&aacute;c mảng b&aacute;m tr&ecirc;n răng. Đ&acirc;y l&agrave; một trong những l&iacute; do g&acirc;y n&ecirc;n s&acirc;u răng nhiều nhất. C&ugrave;ng với đ&oacute; l&agrave; tr&aacute;nh c&aacute;c loại thức ăn như tr&agrave;, nước &eacute;p tr&aacute;i c&acirc;y, đồ ăn ngọt,&hellip;.</strong></p>
<p><strong>Hơn nữa c&aacute;c bạn n&ecirc;n d&ugrave;ng c&aacute;c sản phẩm từ sữa như: bơ mềm, ph&ocirc; mai,&hellip; Tại sao ư? Tại v&igrave; đ&acirc;y l&agrave; những loại thức ăn dễ nhai c&ugrave;ng với đ&oacute; c&oacute; th&ecirc;m nhiều chất dinh dưỡng gi&uacute;p qu&aacute; tr&igrave;nh niềng răng tốt hơn.</strong></p>
<p><strong>Kết hợp v&agrave;o bữa ăn c&aacute;c sản phẩm từ trứng sẽ tốt hơn cho răng miệng. V&igrave; trong trứng c&oacute; Flour khi đưa v&agrave;o men răng sẽ l&agrave;m cho răng của ch&uacute;ng ta cứng chắc hơn v&agrave; ngăn cản sự ph&aacute; hủy của axit trong thức ăn. Đ&acirc;y c&oacute; thể được xem l&agrave; một trong những thực phẩm tốt cho qu&aacute; tr&igrave;nh niềng răng của c&aacute;c bạn.</strong></p>
<p><strong>C&ugrave;ng với đ&oacute; l&agrave; bạn n&ecirc;n đưa v&agrave;o bữa ăn của m&igrave;nh c&aacute;c loại thực phẩm từ rau, củ quả. Bạn c&oacute; thể chế biến c&aacute;c m&oacute;n mềm từ rau củ như luộc, xay,&hellip; để kết hợp với rau v&agrave; ch&aacute;o. Tốt hơn nữa l&agrave; bạn c&oacute; thể uống tr&agrave; xanh, nước &eacute;p nho,việt quốc v&agrave; quả m&acirc;m x&ocirc;i. Điều n&agrave;y vừa tốt cho hệ ti&ecirc;u h&oacute;a, cho cơ thể cũng như rất tốt cho sức khỏe răng của bạn nữa nh&eacute;!</strong></p>
<p><img class="size-medium wp-image-379 aligncenter" src="http://nhakhoawecare.com/wp-content/uploads/2018/04/Ni%E1%BB%81ng-r%C4%83ng-n%C3%AAn-%C4%83n-g%C3%AC-n%C3%AAn-ki%C3%AAng-g%C3%AC-nha-s%E1%BB%B9-t%C6%B0-v%E1%BA%A5n-tuy%E1%BB%87t-%C4%91%E1%BB%91i-tu%C3%A2n-th%E1%BB%A7-1-300x171.jpg" sizes="(max-width: 300px) 100vw, 300px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/04/Niềng-răng-n&ecirc;n-ăn-g&igrave;-n&ecirc;n-ki&ecirc;ng-g&igrave;-nha-sỹ-tư-vấn-tuyệt-đối-tu&acirc;n-thủ-1-300x171.jpg 300w, http://nhakhoawecare.com/wp-content/uploads/2018/04/Niềng-răng-n&ecirc;n-ăn-g&igrave;-n&ecirc;n-ki&ecirc;ng-g&igrave;-nha-sỹ-tư-vấn-tuyệt-đối-tu&acirc;n-thủ-1.jpg 600w" alt="" width="300" height="171" /></p>
<h2><strong>Những m&oacute;n m&agrave; ta n&ecirc;n ăn mỗi ng&agrave;y sau qu&aacute; tr&igrave;nh niềng răng</strong></h2>
<p><strong>Vậy theo bạn thực phẩm m&agrave; ta kh&ocirc;ng n&ecirc;n ăn l&agrave; những thực phẩm n&agrave;o?</strong></p>
<p><strong>Đối lập ở tr&ecirc;n, thực phẩm kh&ocirc;ng n&ecirc;n ăn đầu ti&ecirc;n đ&oacute; l&agrave; những thức ăn dai, gi&ograve;n, cứng, d&iacute;nh như kẹo cao su, nước đ&aacute;, kẹo cứng, vỏ b&aacute;nh pizza, b&aacute;nh nếp,&hellip;</strong></p>
<p><strong>Điều tiếp theo l&agrave; bạn n&ecirc;n hạn chế c&aacute;c m&oacute;n c&oacute; đường. Đ&oacute; l&agrave; v&igrave; trong thức ăn n&agrave;y dễ sinh ra c&aacute;c axit v&agrave; c&aacute;c mảng b&aacute;m g&acirc;y ra s&acirc;u răng cũng như c&aacute;c bệnh về lợi. C&aacute;c bạn n&ecirc;n tr&aacute;nh c&aacute;c thực phẩm như: soda, kẹo c&oacute; chứa đường, c&aacute;c loại b&aacute;nh kẹo c&oacute; m&agrave;u sắc nh&acirc;n tạo để tr&aacute;nh l&agrave;m hại đến răng của m&igrave;nh sau khi niềng.</strong></p>
<p><strong>H&ocirc;m nay WeCare đ&atilde; cung cấp cho bạn v&agrave;i mẹo nhỏ để c&oacute; thể gi&uacute;p bạn c&oacute; được răng đẹp v&agrave; khỏe nhất sau khi niềng răng cũng như c&aacute;c sản phẩm tốt cho sức khỏe của ch&iacute;nh bạn nh&eacute;! H&atilde;y lu&ocirc;n theo d&otilde;i ch&uacute;ng t&ocirc;i để c&oacute; được c&aacute;c th&ocirc;ng tin hữu &iacute;ch sớm nhất.</strong></p>
</div>',
            'title' => 'LỰA CHỌN THỰC PHẨM PHÙ HỢP KHI NIỀNG RĂNG',
            'staff_id' => '1',
            'created_date' => '2018-06-19 04:31:27',
        ]);
        News::create([
            'image_header' => 'http://150.95.104.237/photos/shares/rang-cua-thua-ho-phai-lam-sao-1.jpg',
            'content' => '<h1><strong>Răng cửa hở! Phải l&agrave;m g&igrave;?</strong></h1>
<p><strong>Ng&agrave;y nay c&ugrave;ng với sự ph&aacute;t triển vượt bậc của nền c&ocirc;ng nghệ đ&oacute; l&agrave; nền nha khoa hiện đại Việt Nam ch&uacute;ng ta. &ldquo;C&aacute;i răng c&aacute;i g&oacute;c l&agrave; g&oacute;c con người&rdquo; &ndash; Nhu cầu l&agrave;m đẹp răng kh&ocirc;ng chỉ l&agrave; nhu cầu của những người nổi tiếng m&agrave; c&ograve;n l&agrave; nhu cầu của tất cả mọi người trong x&atilde; hội ng&agrave;y nay. Hơn nữa, nụ cười tươi tắn c&ograve;n mang lại cho người sở hữu n&oacute; sự tự tin v&agrave; rạng ngời. Ch&iacute;nh v&igrave; những l&iacute; do n&agrave;y m&agrave; xu hướng thẩm mĩ nha khoa đang dần trở th&agrave;nh tr&agrave;o lưu trong những năm gần đ&acirc;y.</strong></p>
<p><strong>V&agrave; h&ocirc;m nay, nha khoa WeCare sẽ trả lời v&agrave;i thắc mắc m&agrave; qu&yacute; kh&aacute;ch h&agrave;ng quan t&acirc;m hiện nay.</strong></p>
<p><strong>Kh&aacute;ch h&agrave;ng: Thưa b&aacute;c sĩ, nếu răng cửa của t&ocirc;i bị hở th&igrave; c&oacute; c&aacute;ch n&agrave;o để h&agrave;m răng của t&ocirc;i kh&iacute;t lại v&agrave; đều hơn kh&ocirc;ng ạ? V&agrave; c&aacute;c c&aacute;ch ấy c&oacute; những ưu v&agrave; nhược điểm với chi ph&iacute; để trả hết sau một liệu tr&igrave;nh như thế n&agrave;o vậy ạ?</strong></p>
<p><strong>B&aacute;c sĩ: Trong trường hợp của bạn ở nha khoa ch&uacute;ng t&ocirc;i sẽ c&oacute; 3 phương &aacute;n thẩm mĩ để bạn lựa chọn:</strong></p>
<ul>
<li><strong>Ở phương &aacute;n thứ nhất n&agrave;y nha khoa sẽ tr&aacute;m bằng vật liệu 3M (được nhập từ Mỹ) để thẩm mĩ răng cho bạn. Với c&aacute;ch n&agrave;y vừa tiết tiệm được chi ph&iacute;, &iacute;t ph&aacute; hủy cấu tr&uacute;c răng lại vừa c&oacute; độ cứng, độ chịu lực, chịu m&ograve;n cao n&ecirc;n được kh&aacute; nhiều người tin tưởng v&agrave; sử dụng. Nhưng miếng tr&aacute;m sẽ đổi m&agrave;u sau v&agrave;i năm v&agrave; miếng tr&aacute;m c&oacute; thể bị bong tr&oacute;c n&ecirc;n hạn chế nhai đồ cứng với lực mạnh.</strong></li>
<li><strong>Nếu bạn muốn c&oacute; một h&agrave;m răng vừa c&oacute; t&iacute;nh thẩm mĩ cao lại vừa an to&agrave;n, đảm bảo chất lượng v&agrave; ăn uống như răng thật th&igrave; bạn n&ecirc;n chọn c&aacute;ch thứ 2- phục h&igrave;nh răng bằng m&atilde;o sứ. Ở c&aacute;ch n&agrave;y bạn kh&ocirc;ng cần lo sẽ bị bong, tr&oacute;c, rớt v&agrave; bị xỉn m&agrave;u sau một thời gian.Với lại n&oacute; kh&ocirc;ng g&acirc;y hại cho khoang miệng v&agrave; tuổi thọ răng sứ cao, n&oacute; c&oacute; thể tồn tại trong m&ocirc;i trường miệng từ 15-20 năm. Nhưng c&aacute;i nhược điểm lớn nhất của phương &aacute;n n&agrave;y đ&oacute; l&agrave; bạn phải m&agrave;i răng, n&oacute; sẽ bị mất răng thật để phục h&igrave;nh răng mới.</strong></li>
<li><strong>C&ograve;n nếu bạn muốn c&oacute; một nụ cười đẹp với h&agrave;m răng ngay ngắn, đúng vị tr&iacute; m&agrave; kh&ocirc;ng phải bất cứ phương ph&aacute;p chỉnh nha n&agrave;o cũng c&oacute; thể giải quyết được th&igrave; h&atilde;y chọn phương &aacute;n 3- niềng răng. Ở phương &aacute;n n&agrave;y mang lại cho bạn h&agrave;m răng chắc chắn v&agrave; ổn định, chi ph&iacute; lại ph&ugrave; hợp với khả năng t&agrave;i ch&iacute;nh của bạn.Nhưng n&oacute; lại chiếm nhiều thời gian trong qu&aacute; tr&igrave;nh điều trị v&agrave; t&ugrave;y thuộc v&agrave;o khớp cắn.</strong></li>
</ul>
<p><strong>Đ&oacute; l&agrave; c&aacute;c phương &aacute;n tốt nhất ở nha khoa ch&uacute;ng t&ocirc;i sẽ đem lại cho bạn nụ cười TƯƠI TẮN- RẠNG RỠ.</strong></p>',
            'title' => 'RĂNG CỬA HỞ! PHẢI LÀM SAO?',
            'staff_id' => '1',
            'created_date' => '2018-06-19 04:31:27',
        ]);
        News::create([
            'image_header' => 'http://150.95.104.237/photos/shares/cham-soc-rang-mieng.jpg',
            'content' => '<header class="entry-header">
<div class="entry-header-text entry-header-text-top text-center">
<h1 class="entry-title">CHĂM S&Oacute;C RĂNG MIỆNG HẰNG NG&Agrave;Y C&Ugrave;NG WECARE</h1>
<div class="entry-divider is-divider small">&nbsp;</div>
</div>
<div class="entry-image relative"><a href="http://nhakhoawecare.com/cham-soc-rang-mieng-hang-wecare/"><img class="attachment-large size-large wp-post-image" src="http://nhakhoawecare.com/wp-content/uploads/2018/04/chi-nha-khoa-6.jpg" sizes="(max-width: 600px) 100vw, 600px" srcset="http://nhakhoawecare.com/wp-content/uploads/2018/04/chi-nha-khoa-6.jpg 600w, http://nhakhoawecare.com/wp-content/uploads/2018/04/chi-nha-khoa-6-300x187.jpg 300w" alt="" width="600" height="374" /></a>
<div class="badge absolute top post-date badge-outline">
<div class="badge-inner">&nbsp;</div>
</div>
</div>
</header>
<div class="entry-content single-page">
<h1><strong>CHĂM S&Oacute;C RĂNG MIỆNG HẰNG NG&Agrave;Y C&Ugrave;NG WECARE</strong></h1>
<p><strong>Xin ch&agrave;o c&aacute;c bạn!&nbsp; Ng&agrave;y h&ocirc;m nay của bạn như thế n&agrave;o rồi?&nbsp; Bạn c&oacute; chăm s&oacute;c răng miệng đ&uacute;ng c&aacute;ch để m&igrave;nh c&oacute; được h&agrave;m răng sạch đẹp kh&ocirc;ng? Nếu c&aacute;c bạn chưa biết l&agrave;m đ&uacute;ng c&aacute;ch th&igrave; h&ocirc;m nay WeCare sẽ c&ugrave;ng với bạn t&igrave;m hiểu r&otilde; hơn về c&aacute;ch để vệ sinh răng miệng tốt nhất nh&eacute;!</strong></p>
<h2><strong>Thế vệ sinh răng miệng đ&uacute;ng c&aacute;ch l&agrave; g&igrave;?</strong></h2>
<p><strong>Điều đ&oacute; thể hiện bằng miệng của bạn tr&ocirc;ng khỏe mạnh v&agrave; kh&ocirc;ng c&oacute; m&ugrave;i h&ocirc;i. Thế điều n&agrave;y c&oacute; nghĩa l&agrave;:</strong></p>
<p><strong>&ndash; Răng của bạn sạch sẽ v&agrave; kh&ocirc;ng vướng vụn thức ăn.</strong></p>
<p><strong>&ndash; Nướu c&oacute; m&agrave;u hồng v&agrave; kh&ocirc;ng tổn thương hoặc chảy m&aacute;u khi bạn chải răng hoặc d&ugrave;ng chỉ nha khoa.</strong></p>
<p><strong>&ndash; H&ocirc;i miệng kh&ocirc;ng phải l&agrave; vấn đề thường xuy&ecirc;n.</strong></p>
<p><strong>Nếu nướu răng của bạn bị tổn thương hoặc chảy m&aacute;u trong khi đ&aacute;nh răng hoặc d&ugrave;ng chỉ nha khoa, hoặc bạn đang c&oacute; hơi thở h&ocirc;i li&ecirc;n tục, h&atilde;y đến với WeCare để được c&aacute;c nha sĩ tại đ&acirc;y tư vấn bất k&igrave; vấn đề m&agrave; bạn đang gặp phải nh&eacute;!</strong></p>
<p><strong>Hơn nữa c&aacute;c nha sĩ c&oacute; thể gi&uacute;p bạn t&igrave;m hiểu c&aacute;c kĩ thuật vệ sinh răng miệng v&agrave; c&oacute; thể gi&uacute;p chỉ ra c&aacute;c khu vực miệng của bạn cần được ch&uacute; &yacute; khi chải răng v&agrave; d&ugrave;ng chỉ nha khoa.</strong></p>
<h2><strong>Những c&aacute;ch n&agrave;o bạn n&ecirc;n l&agrave;m để vệ sinh răng miệng tốt nhất?</strong></h2>
<p><strong>Duy tr&igrave; vệ sinh răng miệng tốt l&agrave; một trong những điều quan trọng nhất bạn c&oacute; thể l&agrave;m cho răng v&agrave; nướu răng của bạn. Điều n&agrave;y kh&ocirc;ng chỉ cho ph&eacute;p bạn tr&ocirc;ng đẹp v&agrave; cảm thấy thoải m&aacute;i, ch&uacute;ng c&ograve;n khiến bạn c&oacute; thể ăn v&agrave; n&oacute;i đ&uacute;ng c&aacute;ch. Sức khỏe răng miệng tốt l&agrave; một trong những điều quan trọng đối với hạnh ph&uacute;c của bạn.</strong></p>
<p><strong>Chăm s&oacute;c ph&ograve;ng ngừa h&agrave;ng ng&agrave;y, bao gồm việc chải răng v&agrave; d&ugrave;ng chỉ nha khoa đ&uacute;ng c&aacute;ch. N&oacute; gi&uacute;p dừng lại c&aacute;c vấn đề trước khi ch&uacute;ng ph&aacute;t triển v&agrave; &iacute;t g&acirc;y đau đớn, tốn k&eacute;m, v&agrave; &iacute;t đ&aacute;ng lo ngại hơn l&agrave; c&aacute;c điều kiện điều trị phải thực hiện.</strong></p>
<p><img style="display: block; margin-left: auto; margin-right: auto;" src="/photos/shares/cham-soc-rang-mieng.jpg" alt="" width="500" height="333" /></p>
<p><strong>Trong giữa c&aacute;c lần thường xuy&ecirc;n đến nha sĩ, c&oacute; những bước đơn giản m&agrave; mỗi ch&uacute;ng ta c&oacute; thể l&agrave;m để l&agrave;m giảm đ&aacute;ng kể nguy cơ ph&aacute;t triển s&acirc;u răng, bệnh nướu v&agrave; c&aacute;c vấn đề răng miệng kh&aacute;c. Ch&uacute;ng bao gồm:</strong></p>
<p><strong>&ndash; Đ&aacute;nh răng kĩ hai lần mỗi ng&agrave;y v&agrave; d&ugrave;ng chỉ nha khoa h&agrave;ng ng&agrave;y</strong></p>
<p><strong>&ndash; Ăn một chế độ ăn uống c&acirc;n bằng v&agrave; hạn chế c&aacute;c đồ ăn nhẹ giữa c&aacute;c bữa ăn.</strong></p>
<p><strong>&ndash; Sử dụng c&aacute;c sản phẩm nha khoa c&oacute; chứa fluor, bao gồm cả kem đ&aacute;nh răng.</strong></p>
<p><strong>&ndash; Rửa với nước s&uacute;c miệng c&oacute; chứa chất flour nếu nha sĩ khuy&ecirc;n d&ugrave;ng.</strong></p>
<p><strong>&ndash; Đảm bảo rằng trẻ em dưới 12 tuổi uống nước c&oacute; chất fluor hoặc d&ugrave;ng thuốc bổ sung fluor nếu ch&uacute;ng sống trong một v&ugrave;ng kh&ocirc;ng c&oacute; chất fluor.</strong></p>
<p><strong>Duy tr&igrave; vệ sinh răng miệng tốt l&agrave; một trong những điều thiết yếu để bạn c&oacute; thể c&oacute; những đặc điểm tốt cho răng v&agrave; nướu của bạn. Răng khỏe mạnh kh&ocirc;ng chỉ cho ph&eacute;p bạn tr&ocirc;ng đẹp v&agrave; cảm thấy thoải m&aacute;i, ch&uacute;ng c&ograve;n khiến ch&uacute;ng ta c&oacute; thể ăn v&agrave; n&oacute;i đ&uacute;ng c&aacute;ch.</strong></p>
</div>',
            'title' => 'CHĂM SÓC RĂNG MIỆNG HẰNG NGÀY CÙNG DENTAL GOLD',
            'staff_id' => '1',
            'created_date' => '2018-06-19 04:31:27',
        ]);
        News::create([
            'image_header' => 'http://150.95.104.237/photos/shares/46dce1ec-3be1-4f41-a6e5-365d3165ae58.jpg',
            'content' => '<header class="entry-header">
<div class="entry-header-text entry-header-text-top text-center">
<h1 class="entry-title">RĂNG ĐẸP V&Agrave; KHỎE &ndash; N&Ecirc;N V&Agrave; KH&Ocirc;NG N&Ecirc;N ĂN G&Igrave; Đ&Acirc;Y?</h1>
<div class="entry-divider is-divider small">&nbsp;</div>
</div>
<div class="entry-image relative"><br />
<div class="badge absolute top post-date badge-outline">
<div class="badge-inner"><img style="display: block; margin-left: auto; margin-right: auto;" src="/photos/shares/46dce1ec-3be1-4f41-a6e5-365d3165ae58.jpg" alt="" width="376" height="250" /></div>
</div>
</div>
</header>
<div class="entry-content single-page">
<h1><strong>RĂNG ĐẸP V&Agrave; KHỎE &ndash; N&Ecirc;N V&Agrave; KH&Ocirc;NG N&Ecirc;N ĂN G&Igrave; Đ&Acirc;Y?</strong></h1>
<p><strong><em>V&acirc;ng, trong cuộc sống ch&uacute;ng ta c&oacute; thể n&oacute;i sức khỏe l&agrave; một trong c&aacute;c yếu tố quan trọng h&agrave;ng đầu. V&agrave; răng cũng vậy, n&oacute; cũng l&agrave; một phần của yếu tố sức khỏe. C&aacute;i m&agrave; ch&uacute;ng ta quan t&acirc;m nhất. Ch&iacute;nh v&igrave; điều n&agrave;y n&ecirc;n nha khoa WeCare ch&uacute;ng t&ocirc;i h&ocirc;m nay đ&atilde; n&ecirc;u l&ecirc;n c&aacute;c thực phẩm n&ecirc;n v&agrave; kh&ocirc;ng n&ecirc;n ăn để c&oacute; được một h&agrave;m răng khỏe mạnh.</em></strong></p>
<h2><strong>Thực phẩm n&ecirc;n ăn:</strong></h2>
<h3><strong>1.Nước lọc:</strong></h3>
<p><strong>Sau mỗi bữa ăn hoặc sau khi uống c&aacute;c loại nước c&oacute; ga, c&oacute; m&agrave;u bạn n&ecirc;n s&uacute;c miệng bằng nước. Điều n&agrave;y sẽ hạn chế tối đa c&aacute;c mẩu thức ăn c&ograve;n b&aacute;m v&agrave;o dễ g&acirc;y s&acirc;u răng.</strong></p>
<p><img class="aligncenter" style="display: block; margin-left: auto; margin-right: auto;" src="http://giadinh.mediacdn.vn/thumb_w/640/2017/may-loc-nuoc-uong-truc-tiep3-1507799316285.jpg" alt="K&aacute;&ordm;&iquest;t qu&aacute;&ordm;&pound; h&Atilde;&not;nh &aacute;&ordm;&pound;nh cho n&AElig;&deg;&aacute;&raquo;c l&aacute;&raquo;c" width="640" height="481" /></p>
<h3><strong>2.C&aacute;c thực phẩm l&agrave; sản phẩm từ sữa:</strong></h3>
<p><strong>Đ&oacute; l&agrave; ph&ocirc; m&aacute;t, sữa đ&ocirc;ng v&agrave; c&aacute;c sản phẩm c&oacute; nhiều vitamin kh&aacute;c. C&aacute;c chất n&agrave;y rất c&oacute; lợi cho sức khỏe răng của mỗi ch&uacute;ng ta.</strong></p>
<p>&nbsp;</p>
<h3><strong>3.C&aacute;c loại hạt vỏ cứng:</strong></h3>
<p><strong>Trong c&aacute;c hạt n&agrave;y c&oacute; c&aacute;c vitamin, kho&aacute;ng chất, canxi, sắt, kẽm, v&agrave; c&aacute;c loại dưỡng chất kh&aacute;c. Ch&iacute;nh nhờ điều n&agrave;y n&ecirc;n n&oacute; rất c&oacute; lợi cho sự khỏe mạnh của răng bạn.</strong></p>
<h3><strong>4.Tr&agrave; xanh:</strong></h3>
<p><strong>Trong tr&agrave; xanh c&oacute; chất catechin c&oacute; khả năng kiểm so&aacute;t t&igrave;nh trạng vi&ecirc;m v&agrave; chống nhiềm tr&ugrave;ng do vi khuẩn. V&agrave; theo nghiện cứu của c&aacute;c nh&agrave; khoa học đ&atilde; đưa ra kết luận rằng những người thường sử dụng tr&agrave; xanh th&igrave; c&oacute; &iacute;t vi khuẩn v&agrave; acid v&agrave; vi khuẩn trong miệng họ hơn. Chưa hết ở đ&oacute;, tr&agrave; xanh c&ograve;n chấm dứt t&igrave;nh trạng chảy m&aacute;u lợi, chảy m&aacute;u ch&acirc;n răng nữa.</strong></p>
<p><img class="aligncenter" style="display: block; margin-left: auto; margin-right: auto;" src="http://sohanews.sohacdn.com/thumb_w/660/2017/natural-antibacterial-properties-green-tea-1500544525275-0-0-434-700-crop-1500544533450.jpg" alt="K&aacute;&ordm;&iquest;t qu&aacute;&ordm;&pound; h&Atilde;&not;nh &aacute;&ordm;&pound;nh cho tr&Atilde;&nbsp; xanh" /></p>
<h2><strong><em>Đ&oacute; l&agrave; những thứ ch&uacute;ng ta n&ecirc;n ăn vậy c&ograve;n những thực phẩm m&agrave; ta kh&ocirc;ng n&ecirc;n ăn l&agrave; những g&igrave;?</em></strong></h2>
<h3><strong>1.Thực phẩm c&oacute; t&iacute;nh axit:</strong></h3>
<p><strong>Bạn n&ecirc;n hạn chế ăn chanh hoặc c&aacute;c loại tr&aacute;i c&acirc;y c&oacute; t&iacute;nh axit cao hoặc s&uacute;c miệng bằng nước lo&atilde;ng sau khi bạn ăn xong. N&oacute; sẽ gi&uacute;p l&agrave;m bạn pha lo&atilde;ng axit trong miệng. C&ugrave;ng với đ&oacute; bạn n&ecirc;n đợi 30 ph&uacute;t sau mới được đ&aacute;nh răng, như vậy men răng mới c&oacute; thời gian để phục hồi lại b&igrave;nh thường.</strong></p>
<h3><strong>2.Đ&aacute; lạnh:</strong></h3>
<p><strong>Ai cũng biết rằng đ&aacute; rất lạnh v&agrave; cứng. V&igrave; thế khi bạn ăn ch&uacute;ng qu&aacute; nhiều, n&oacute; sẽ ảnh hưởng ti&ecirc;u cực đến men răng( bề mặt bảo vệ răng).</strong></p>
<p><img class="aligncenter" style="display: block; margin-left: auto; margin-right: auto;" src="https://dwbxi9io9o7ce.cloudfront.net/images/dreamstime_15806431.max-600x600.jpg" alt="K&aacute;&ordm;&iquest;t qu&aacute;&ordm;&pound; h&Atilde;&not;nh &aacute;&ordm;&pound;nh cho &Auml;&Atilde;&iexcl; l&aacute;&ordm;&iexcl;nh" /></p>
<h3><strong>3.Nước c&oacute; ga v&agrave; rượu:</strong></h3>
<p><strong>Rượu l&agrave; chất c&oacute; thể l&agrave;m ố v&agrave; hỏng răng của bạn đấy! C&ugrave;ng với đ&oacute; l&agrave; nguy&ecirc;n nh&acirc;n lớn của ung thư miệng nữa. Ch&iacute;nh v&igrave; điều n&agrave;y, bạn chỉ n&ecirc;n uống 1 ly mỗi ng&agrave;y v&agrave; nhớ đ&aacute;nh răng kĩ sau mỗi lần uống nh&eacute;!</strong></p>
<p><strong>Chưa hết, với nước ngọt c&oacute; ga th&igrave; ch&uacute;ng c&oacute; rất nhiều axit photphoric v&agrave; citric l&agrave;m mềm men răng v&agrave; tăng nguy cơ s&acirc;u răng cho ch&iacute;nh người sử dụng n&oacute; đấy. Nếu bạn muốn uống th&igrave; h&atilde;y s&uacute;c miệng bằng nước lọc sau mỗi lần uống n&oacute; nh&eacute;!</strong></p>
<h3><strong>4.Thực phẩm chứa nhiều tinh bột:</strong></h3>
<p><strong>Đ&oacute; l&agrave; c&aacute;c loại thực phẩm như: b&aacute;nh m&igrave; trắng, pizzza, m&igrave; ống v&agrave; b&aacute;nh m&igrave; kẹp thịt,&hellip;Đ&oacute; l&agrave; c&aacute;c loại thực phẩm chứa nhiều tinh bột v&agrave; dễ d&agrave;ng lọt v&agrave;o c&aacute;c khẽ răng g&acirc;y n&ecirc;n s&acirc;u răng.</strong></p>
</div>',
            'title' => 'RĂNG ĐẸP VÀ KHỎE – NÊN VÀ KHÔNG NÊN ĂN GÌ ĐÂY?',
            'staff_id' => '1',
            'created_date' => '2018-06-19 04:31:27',
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
            'created_date' => '2018-06-19 04:31:27',
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
            'created_date' => '2018-06-19 04:31:27',
        ]);
        News::create([
            'image_header' => 'http://150.95.104.237/photos/shares/2.jpg',
            'content' => '<p class="the-article-summary cms-desc">Nhờ chiết xuất từ thảo dược tự nhi&ecirc;n như vỏ quả cau, đinh hương, cam thảo, kem đ&aacute;nh răng dược liệu gi&uacute;p đẩy l&ugrave;i h&ocirc;i miệng hiệu quả.</p>
<div class="the-article-body cms-body">
<p>T&igrave;nh trạng h&ocirc;i miệng g&acirc;y ảnh hưởng nhiều đến cuộc sống h&agrave;ng ng&agrave;y v&agrave; khiến kh&ocirc;ng &iacute;t người lo lắng.</p>
<h3>Chất lượng sống ảnh hưởng v&igrave; h&ocirc;i miệng</h3>
<p>Chị Ho&agrave;i Thương (28 tuổi, ở H&agrave; Nội) l&agrave;m nh&acirc;n vi&ecirc;n kinh doanh, thường xuy&ecirc;n phải tiếp x&uacute;c với nhiều kh&aacute;ch h&agrave;ng. Nhưng gần đ&acirc;y, chị cảm thấy hiệu quả c&ocirc;ng việc giảm s&uacute;t, nguy&ecirc;n nh&acirc;n một phần v&igrave; miệng xuất hiện m&ugrave;i h&ocirc;i.<br />&ldquo;T&ocirc;i thật sự kh&oacute; chịu, chất lượng sống, c&ocirc;ng việc bị ảnh hưởng. T&ocirc;i đ&atilde; thử nhiều c&aacute;ch nhưng kh&ocirc;ng hiệu quả l&acirc;u, l&uacute;c n&agrave;o cũng cảm gi&aacute;c m&igrave;nh mất lịch sự&rdquo;, chị Thương than thở.</p>
<p>Sau khi được tư vấn, chị Thương biết t&igrave;nh trạng hơi thở c&oacute; m&ugrave;i kh&ocirc;ng phải tự nhi&ecirc;n xuất hiện m&agrave; do vi khuẩn sinh s&ocirc;i, ph&aacute;t triển từ trong miệng. Ch&uacute;ng ph&aacute; vỡ c&aacute;c mảnh vụn thức ăn v&agrave; tạo ra hợp chất ph&aacute;t ra m&ugrave;i h&ocirc;i.</p>
<p>&ldquo;B&aacute;c sĩ cũng n&oacute;i t&ocirc;i bị h&ocirc;i miệng do th&oacute;i quen vệ sinh răng miệng chưa tốt, chưa đ&uacute;ng. Chỉ xỉa răng kh&ocirc;ng thể k&eacute;o hết thức ăn c&ograve;n s&oacute;t, vi khuẩn sinh s&ocirc;i, g&acirc;y h&ocirc;i miệng&rdquo;, chị Thương chia sẻ.</p>
<p>Kh&ocirc;ng những thế, việc xỉa răng c&ograve;n khiến phần lợi bị trầy xước, đ&ocirc;i khi sưng đỏ, chảy m&aacute;u kẽ ch&acirc;n răng. Đ&acirc;y l&agrave; dấu hiệu sớm của bệnh vi&ecirc;m lợi - một nguy&ecirc;n nh&acirc;n g&acirc;y h&ocirc;i miệng thường gặp, nhưng nhiều người chủ quan, bỏ qua. Ngo&agrave;i ra, những người bị s&acirc;u răng, vừa nhổ răng kh&ocirc;n, c&oacute; chỗ vỡ trơ tủy răng hoặc lỗ hổng s&acirc;u răng, nhiều mảng cao răng&hellip; cũng dễ bị h&ocirc;i miệng.</p>
<p>Với người đeo niềng, răng giả, vi khuẩn sẽ dễ t&iacute;ch tụ ở c&aacute;c kẽ g&acirc;y m&ugrave;i h&ocirc;i. T&igrave;nh trạng n&agrave;y c&ograve;n xuất hiện do uống rượu, h&uacute;t thuốc l&aacute;, ăn c&aacute;c thực phẩm để lại m&ugrave;i như tỏi, h&agrave;nh, thức ăn cay&hellip;</p>
<table class="picture" align="center">
<tbody>
<tr>
<td class="pic">
<div class="photoset-item"><img title="Chữa h&ocirc;i miệng bằng kem đ&aacute;nh răng dược liệu h&igrave;nh ảnh 1" src="https://znews-photo-td.zadn.vn/w660/Uploaded/wyhktpu/2018_07_09/8cachdanhbayhoithocomui_01.jpg" alt="Chua hoi mieng bang kem danh rang duoc lieu hinh anh 1" width="660" height="409" /></div>
</td>
</tr>
<tr>
<td class="pCaption caption">Vi&ecirc;m lợi l&agrave; một nguy&ecirc;n nh&acirc;n g&acirc;y h&ocirc;i miệng thường gặp.</td>
</tr>
</tbody>
</table>
<h3>C&aacute;ch ph&ograve;ng tr&aacute;nh h&ocirc;i miệng</h3>
<p>Để vệ sinh răng miệng đ&uacute;ng c&aacute;ch, bạn cần uống nhiều nước để giữ ẩm miệng, tập th&oacute;i quen đ&aacute;nh răng 2 lần/ng&agrave;y. Vệ sinh kỹ c&aacute;c g&oacute;c cạnh của miệng, loại bỏ thức ăn thừa d&iacute;nh ở c&aacute;c kẽ răng. Đồng thời, việc đ&aacute;nh, cạo lưỡi ngăn sự ph&aacute;t triển mạnh của vi khuẩn cũng cần được ch&uacute; &yacute;. Nếu mắc c&aacute;c bệnh l&yacute; trong miệng người mắc cần điều trị, đi kh&aacute;m nha khoa định kỳ 6 th&aacute;ng/lần.</p>
<p>B&ecirc;n cạnh đ&oacute;, việc chọn kem đ&aacute;nh răng cũng rất quan trọng để &ldquo;ph&ograve;ng từ xa" nguy&ecirc;n nh&acirc;n g&acirc;y h&ocirc;i miệng. C&aacute;c chuy&ecirc;n gia khuyến c&aacute;o n&ecirc;n d&ugrave;ng sản phẩm kem đ&aacute;nh răng dược liệu tự nhi&ecirc;n. V&igrave; sản phẩm n&agrave;y kh&ocirc;ng chỉ l&agrave;m sạch răng lợi, an to&agrave;n, ngừa s&acirc;u, mảng b&aacute;m m&agrave; c&ograve;n gi&uacute;p tăng cường m&aacute;u lưu th&ocirc;ng dưới tủy răng, lợi, gi&uacute;p nu&ocirc;i dưỡng v&agrave; bảo vệ từ b&ecirc;n trong. Kem đ&aacute;nh răng dược liệu cũng gi&uacute;p khử m&ugrave;i h&ocirc;i miệng.</p>
<p>Đ&ocirc;ng y ghi nhận một số vị dược liệu c&oacute; t&aacute;c dụng chăm s&oacute;c sức khỏe răng miệng đ&atilde; được nghi&ecirc;n cứu như chiết xuất vỏ quả cau, đinh hương, cam thảo, một dược&hellip; Trong đ&oacute;, đinh hương c&oacute; vị cay, t&ecirc;, kh&aacute;ng khuẩn, khử m&ugrave;i, được d&ugrave;ng trong nhiều b&agrave;i thuốc gi&uacute;p giảm c&aacute;c bệnh về răng miệng. Tinh chất bạc h&agrave; c&oacute; t&aacute;c dụng diệt khuẩn, thơm miệng, được d&ugrave;ng phổ biến trong c&aacute;c sản phẩm chăm s&oacute;c răng miệng kh&aacute;c để tạo hơi thở thơm m&aacute;t tự nhi&ecirc;n. Sự phối hợp h&agrave;i ho&agrave; giữa 2 vị thuốc n&agrave;y sẽ gi&uacute;p tăng t&aacute;c dụng ngăn chặn vi khuẩn g&acirc;y m&ugrave;i.</p>
<table class="picture" align="center">
<tbody>
<tr>
<td class="pic">
<div class="photoset-item"><img src="https://znews-photo-td.zadn.vn/w660/Uploaded/wyhktpu/2018_07_09/2.jpg" alt="Chua hoi mieng bang kem danh rang duoc lieu hinh anh 2" width="609" height="410" /></div>
</td>
</tr>
<tr>
<td class="pCaption caption">Kem đ&aacute;nh răng dược liệu chứa nhiều th&agrave;nh phần chữa h&ocirc;i miệng.</td>
</tr>
</tbody>
</table>
</div>',
            'title' => 'Chữa hôi miệng bằng kem đánh răng dược liệu',
            'staff_id' => '1',
            'created_date' => '2018-06-19 04:31:27',
        ]);
        News::create([
            'image_header' => 'http://150.95.104.237/photos/shares/nhorangso6.jpg',
            'content' => '<p class="the-article-summary cms-desc">Để tr&aacute;nh nguy cơ nhổ răng bất đắc dĩ, việc vệ sinh răng miệng thường xuy&ecirc;n bằng kem đ&aacute;nh răng dược liệu được nhiều người ưu ti&ecirc;n sử dụng.</p>
<div class="the-article-body cms-body">
<p>Thống k&ecirc; mới nhất của Bệnh viện Răng h&agrave;m mặt Trung ương H&agrave; Nội cho thấy c&oacute; đến 90% d&acirc;n số gặp c&aacute;c vấn đề về răng miệng, trong đ&oacute; chủ yếu l&agrave; s&acirc;u răng, vi&ecirc;m lợi v&agrave; phải nhổ răng.</p>
<h3>&ldquo;Mất răng&rdquo; do đ&acirc;u?</h3>
<p>Theo c&aacute;c chuy&ecirc;n gia nha khoa, răng lợi cũng như c&aacute;c bộ phận kh&aacute;c của cơ thể, cần được nu&ocirc;i dưỡng để ph&aacute;t triển khỏe mạnh.Chỉ l&agrave;m sạch b&ecirc;n ngo&agrave;i th&ocirc;i chưa đủ, cần phải nu&ocirc;i dưỡng, t&aacute;i tạo răng lợi h&agrave;ng ng&agrave;y từ b&ecirc;n trong.<br />Răng gồm 4 nh&oacute;m với răng cửa đảm nhiệm chức năng cắt, răng nanh x&eacute;, răng h&agrave;m nhỏ v&agrave; h&agrave;m lớn sẽ nghiền thức ăn. Khi c&aacute;c răng vĩnh viễn mọc l&ecirc;n, nhưng bị mất v&igrave; l&yacute; do n&agrave;o đ&oacute;, sẽ kh&ocirc;ng c&oacute; răng thay thế nữa.</p>
<table class="picture" align="center">
<tbody>
<tr>
<td class="pic">
<div class="photoset-item"><img title="C&aacute;ch ph&ograve;ng tr&aacute;nh nguy cơ nhổ răng bất đắc dĩ h&igrave;nh ảnh 1" src="https://znews-photo-td.zadn.vn/w660/Uploaded/wyhktpu/2018_07_04/nhorangso6.jpg" alt="Cach phong tranh nguy co nho rang bat dac di hinh anh 1" width="500" height="329" /></div>
</td>
</tr>
<tr>
<td class="pCaption caption">Răng vĩnh viễn c&oacute; thể bị buộc nhổ bỏ v&igrave; bị tổn thương.</td>
</tr>
</tbody>
</table>
<p>Ngo&agrave;i nguy&ecirc;n nh&acirc;n do va chạm mạnh g&acirc;y g&atilde;y hoặc mất răng, phần kh&ocirc;ng nhỏ c&ograve;n lại li&ecirc;n quan đến những bệnh răng miệng thường gặp như vi&ecirc;m lợi, chảy m&aacute;u ch&acirc;n răng, bệnh nha chu, s&acirc;u răng&hellip;</p>
<p>Bệnh nha chu kh&ocirc;ng chỉ ảnh hưởng đến nướu răng m&agrave; c&ograve;n cả xương, d&acirc;y chằng xung quanh răng, thậm ch&iacute; l&agrave;m giảm sức đề kh&aacute;ng to&agrave;n cơ thể. Nguy&ecirc;n nh&acirc;n ch&iacute;nh của bệnh phổ biến n&agrave;y l&agrave; do t&igrave;nh trạng vệ sinh răng miệng k&eacute;m,t&iacute;ch tụ th&agrave;nh cao răng.</p>
<p>Cao răng c&agrave;ng nhiều sẽ dẫn đến t&igrave;nh trạng vi&ecirc;m lợi c&agrave;ng nặng, c&oacute; thể khiến lợi sưng phồng, chảy m&aacute;u, ph&aacute; hủy xương ổ răng, hậu quả l&agrave;m răng bị lung lay, kh&ocirc;ng thể cắn, x&eacute;, nhai, nghiền... Nha sĩ l&uacute;c n&agrave;y bắt buộc phải nhổ bỏ c&aacute;c răng bị ảnh hưởng mặc d&ugrave; vẫn c&ograve;n l&agrave;nh lặn.</p>
<h3>Ph&ograve;ng nguy cơ nhổ răng bất đắc dĩ</h3>
<p>Để giữ răng chắc, khỏe, bạn cần c&oacute; chế độ ăn uống hợp l&yacute;, đủ dinh dưỡng; tr&aacute;nh những thứ qu&aacute; n&oacute;ng hoặc qu&aacute; lạnh. Việc vệ sinh răng miệng thường xuy&ecirc;n, đ&uacute;ng c&aacute;ch để ph&ograve;ng ngừa c&aacute;c bệnh răng miệng, tr&aacute;nh bị mất răng &ldquo;bất đắc dĩ&rdquo; đ&oacute;ng vai tr&ograve; rất quan trọng.</p>
<p>Những người hay gặp c&aacute;c vấn đề răng miệng về nhiệt, vi&ecirc;m lợi, chảy m&aacute;u ch&acirc;n răng, tụt lợi dẫn đến răng lung lay, &ecirc; buốt&hellip; n&ecirc;n d&ugrave;ng kem đ&aacute;nh răng dược liệu. Sản phẩm tự nhi&ecirc;n n&agrave;y kh&ocirc;ng chỉ l&agrave;m sạch răng lợi, an to&agrave;n m&agrave; c&ograve;n tăng cường m&aacute;u lưu th&ocirc;ng dưới tủy răng, lợi, gi&uacute;p nu&ocirc;i dưỡng v&agrave; bảo vệ từ b&ecirc;n trong.</p>
<table class="picture" align="center">
<tbody>
<tr>
<td class="pic">
<div class="photoset-item"><img src="https://znews-photo-td.zadn.vn/w660/Uploaded/wyhktpu/2018_07_04/img20160707173259397.jpg" alt="Cach phong tranh nguy co nho rang bat dac di hinh anh 2" width="640" height="427" /></div>
</td>
</tr>
<tr>
<td class="pCaption caption">Những người hay gặp c&aacute;c vấn đề về răng miệng n&ecirc;n d&ugrave;ng kem đ&aacute;nh răng dược liệu.</td>
</tr>
</tbody>
</table>
<p>Nổi bật trong đ&oacute; l&agrave; kem đ&aacute;nh răng dược liệu Ngọc Ch&acirc;u với th&agrave;nh phần tinh chất dược liệu (vỏ quả cau, đinh hương, cam thảo, một dược, hoa h&ograve;e, keo ong&hellip;), bổ sung vitamin v&agrave; muối. Trong đ&oacute;, vỏ quả cau gi&uacute;p chắc ch&acirc;n răng, trắng răng; đinh hương kh&aacute;ng khuẩn khử m&ugrave;i, giảm &ecirc; buốt răng; cam thảo, keo ong lại chống vi&ecirc;m lợi, nhiệt miệng; hoa h&ograve;e hỗ trợ hoạt huyết, bền th&agrave;nh mạch, ngăn chảy m&aacute;u ch&acirc;n răng&hellip;</p>
<p>C&aacute;c th&agrave;nh phần được phối hợp khoa học, ph&aacute;t huy t&aacute;c dụng đồng thời l&ecirc;n cả răng v&agrave; lợi. Nhờ vậy, răng lợi kh&ocirc;ng chỉ được l&agrave;m sạch, bảo vệ b&ecirc;n ngo&agrave;i m&agrave; c&ograve;n tăng cường lưu th&ocirc;ng m&aacute;u, nu&ocirc;i dưỡng từ gốc. Sản phẩm cũng g&oacute;p phần bảo vệ lợi, chắc ch&acirc;n răng, ngăn ngừa nhiệt miệng, vi&ecirc;m lợi, tụt lợi, chảy m&aacute;u ch&acirc;n răng, vi&ecirc;m quanh ch&acirc;n răng&hellip;</p>
</div>',
            'title' => 'Cách phòng tránh nguy cơ nhổ răng bất đắc dĩ',
            'staff_id' => '1',
            'created_date' => '2018-06-19 04:31:27',
        ]);

    }

    public function initType()
    {
        Type::create([
            'id' => '1',
            'type' => 'Tin tức'
        ]);
        Type::create([
            'id' => '2',
            'type' => 'Sự kiện'
        ]);


    }

    public function initNewType()
    {
        NewsType::create([
            'type_id' => '1',
            'news_id' => '1'
        ]);
        NewsType::create([
            'type_id' => '1',
            'news_id' => '2'
        ]);
        NewsType::create([
            'type_id' => '1',
            'news_id' => '3'
        ]);
        NewsType::create([
            'type_id' => '1',
            'news_id' => '4'
        ]);
        NewsType::create([
            'type_id' => '1',
            'news_id' => '5'
        ]);
        NewsType::create([
            'type_id' => '1',
            'news_id' => '6'
        ]);
        NewsType::create([
            'type_id' => '1',
            'news_id' => '7'
        ]);
        NewsType::create([
            'type_id' => '1',
            'news_id' => '8'
        ]);
        NewsType::create([
            'type_id' => '2',
            'news_id' => '1'
        ]);
        NewsType::create([
            'type_id' => '2',
            'news_id' => '3'
        ]);

    }

    public function initPaymentDetail()
    {
        Payment::create([
            'paid' => '100000',
            'total_price' => '300000',
            'phone' => '01279011097',
            'status' => 1,
        ]);
        Payment::create([
            'paid' => '200000',
            'total_price' => '600000',
            'phone' => '01279011096',
            'status' => 1,
        ]);
        Payment::create([
            'paid' => '150000',
            'total_price' => '600000',
            'phone' => '01279011098',
            'status' => 1,
        ]);
        Payment::create([
            'paid' => '250000',
            'total_price' => '500000',
            'phone' => '01279011099',
            'status' => 1,
        ]);
        PaymentDetail::create([
            'staff_id' => 3,
            'payment_id' => '1',
            'receptionist_id' => '1',
            'created_date' => '2018-06-13 20:08:18',
            'received_money' => '100000',
        ]);
        PaymentDetail::create([
            'staff_id' => 3,
            'payment_id' => '1',
            'receptionist_id' => '2',
            'created_date' => '2018-06-18 20:08:18',
            'received_money' => '200000',
        ]);
        PaymentDetail::create([
            'staff_id' => 3,
            'payment_id' => '2',
            'receptionist_id' => '2',
            'created_date' => '2018-06-14 20:08:18',
            'received_money' => '200000',
        ]);
        PaymentDetail::create([
            'staff_id' => 3,
            'payment_id' => '2',
            'receptionist_id' => '2',
            'created_date' => '2018-06-19 20:08:18',
            'received_money' => '400000',
        ]);
        PaymentDetail::create([
            'staff_id' => 3,
            'payment_id' => '3',
            'receptionist_id' => '2',
            'created_date' => '2018-06-19 20:08:18',
            'received_money' => '150000',
        ]);
        PaymentDetail::create([
            'staff_id' => 3,
            'payment_id' => '3',
            'receptionist_id' => '2',
            'created_date' => '2018-06-22 20:08:18',
            'received_money' => '450000',
        ]);
        PaymentDetail::create([
            'staff_id' => 3,
            'payment_id' => '4',
            'receptionist_id' => '1',
            'created_date' => '2018-06-22 20:08:18',
            'received_money' => '250000',
        ]);
        PaymentDetail::create([
            'staff_id' => 3,
            'payment_id' => '4',
            'receptionist_id' => '1',
            'created_date' => '2018-06-30 20:08:18',
            'received_money' => '250000',
        ]);
    }

    public function initStep()
    {
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
        Step::create([
            'name' => 'Bảo hành',
            'description' => 'Bảo hành cho liệu trình',

        ]);
    }

    public function initTreatmentStep()
    {
        TreatmentStep::create([
            'treatment_id' => '1',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '1',
            'step_id' => '4',
        ]);
        TreatmentStep::create([
            'treatment_id' => '1',
            'step_id' => '5',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '2',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '2',
            'step_id' => '6',
        ]);
        TreatmentStep::create([
            'treatment_id' => '2',
            'step_id' => '5',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '3',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '3',
            'step_id' => '5',
        ]);
        TreatmentStep::create([
            'treatment_id' => '3',
            'step_id' => '8',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '4',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '4',
            'step_id' => '4',
        ]);
        TreatmentStep::create([
            'treatment_id' => '4',
            'step_id' => '6',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '5',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '5',
            'step_id' => '9',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '6',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '7',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '6',
            'step_id' => '10',
        ]);
        TreatmentStep::create([
            'treatment_id' => '7',
            'step_id' => '10',
        ]);
        TreatmentStep::create([
            'treatment_id' => '6',
            'step_id' => '11',
        ]);
        TreatmentStep::create([
            'treatment_id' => '7',
            'step_id' => '11',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '8',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '8',
            'step_id' => '12',
        ]);
        TreatmentStep::create([
            'treatment_id' => '8',
            'step_id' => '13',
        ]);
        TreatmentStep::create([
            'treatment_id' => '8',
            'step_id' => '14',
        ]);
        TreatmentStep::create([
            'treatment_id' => '8',
            'step_id' => '15',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '9',
            'step_id' => '16',
        ]);
        TreatmentStep::create([
            'treatment_id' => '9',
            'step_id' => '17',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '10',
            'step_id' => '18',
        ]);
        TreatmentStep::create([
            'treatment_id' => '11',
            'step_id' => '19',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '12',
            'step_id' => '20',
        ]);
        TreatmentStep::create([
            'treatment_id' => '13',
            'step_id' => '20',
        ]);
        TreatmentStep::create([
            'treatment_id' => '14',
            'step_id' => '20',
        ]);
        TreatmentStep::create([
            'treatment_id' => '15',
            'step_id' => '21',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '16',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '16',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '16',
            'step_id' => '22',
        ]);
        TreatmentStep::create([
            'treatment_id' => '16',
            'step_id' => '23',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '17',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '17',
            'step_id' => '2',
        ]);
        TreatmentStep::create([
            'treatment_id' => '17',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '17',
            'step_id' => '22',
        ]);
        TreatmentStep::create([
            'treatment_id' => '17',
            'step_id' => '23',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '18',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '18',
            'step_id' => '2',
        ]);
        TreatmentStep::create([
            'treatment_id' => '18',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '18',
            'step_id' => '22',
        ]);
        TreatmentStep::create([
            'treatment_id' => '18',
            'step_id' => '23',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '19',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '19',
            'step_id' => '2',
        ]);
        TreatmentStep::create([
            'treatment_id' => '19',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '19',
            'step_id' => '22',
        ]);
        TreatmentStep::create([
            'treatment_id' => '19',
            'step_id' => '23',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '20',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '20',
            'step_id' => '2',
        ]);
        TreatmentStep::create([
            'treatment_id' => '20',
            'step_id' => '3',
        ]);
        TreatmentStep::create([
            'treatment_id' => '20',
            'step_id' => '22',
        ]);
        TreatmentStep::create([
            'treatment_id' => '20',
            'step_id' => '24',
        ]);
        TreatmentStep::create([
            'treatment_id' => '20',
            'step_id' => '23',
        ]);
//            --------------
        TreatmentStep::create([
            'treatment_id' => '21',
            'step_id' => '31',
        ]);
        TreatmentStep::create([
            'treatment_id' => '21',
            'step_id' => '25',
        ]);
        TreatmentStep::create([
            'treatment_id' => '21',
            'step_id' => '32',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '22',
            'step_id' => '31',
        ]);
        TreatmentStep::create([
            'treatment_id' => '22',
            'step_id' => '26',
        ]);
        TreatmentStep::create([
            'treatment_id' => '22',
            'step_id' => '32',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '23',
            'step_id' => '31',
        ]);
        TreatmentStep::create([
            'treatment_id' => '23',
            'step_id' => '27',
        ]);
        TreatmentStep::create([
            'treatment_id' => '23',
            'step_id' => '32',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '24',
            'step_id' => '31',
        ]);
        TreatmentStep::create([
            'treatment_id' => '24',
            'step_id' => '28',
        ]);
        TreatmentStep::create([
            'treatment_id' => '24',
            'step_id' => '32',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '25',
            'step_id' => '31',
        ]);
        TreatmentStep::create([
            'treatment_id' => '25',
            'step_id' => '29',
        ]);
        TreatmentStep::create([
            'treatment_id' => '25',
            'step_id' => '32',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '26',
            'step_id' => '31',
        ]);
        TreatmentStep::create([
            'treatment_id' => '26',
            'step_id' => '30',
        ]);
        TreatmentStep::create([
            'treatment_id' => '26',
            'step_id' => '32',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '29',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '29',
            'step_id' => '37',
        ]);
        TreatmentStep::create([
            'treatment_id' => '29',
            'step_id' => '36',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '30',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '30',
            'step_id' => '38',
        ]);
        TreatmentStep::create([
            'treatment_id' => '30',
            'step_id' => '36',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '31',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '31',
            'step_id' => '39',
        ]);
        TreatmentStep::create([
            'treatment_id' => '31',
            'step_id' => '36',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '32',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '32',
            'step_id' => '40',
        ]);
        TreatmentStep::create([
            'treatment_id' => '32',
            'step_id' => '42',
        ]);
        TreatmentStep::create([
            'treatment_id' => '32',
            'step_id' => '45',
        ]);
        TreatmentStep::create([
            'treatment_id' => '32',
            'step_id' => '46',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '33',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '33',
            'step_id' => '40',
        ]);
        TreatmentStep::create([
            'treatment_id' => '33',
            'step_id' => '41',
        ]);
        TreatmentStep::create([
            'treatment_id' => '33',
            'step_id' => '45',
        ]);
        TreatmentStep::create([
            'treatment_id' => '33',
            'step_id' => '46',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '34',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '34',
            'step_id' => '40',
        ]);
        TreatmentStep::create([
            'treatment_id' => '34',
            'step_id' => '43',
        ]);
        TreatmentStep::create([
            'treatment_id' => '34',
            'step_id' => '45',
        ]);
        TreatmentStep::create([
            'treatment_id' => '34',
            'step_id' => '46',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '35',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '35',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '35',
            'step_id' => '43',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '36',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '36',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '36',
            'step_id' => '44',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '37',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '37',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '37',
            'step_id' => '45',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '38',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '38',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '38',
            'step_id' => '46',
        ]);
        //--------------
        TreatmentStep::create([
            'treatment_id' => '39',
            'step_id' => '1',
        ]);
        TreatmentStep::create([
            'treatment_id' => '39',
            'step_id' => '7',
        ]);
        TreatmentStep::create([
            'treatment_id' => '39',
            'step_id' => '47',
        ]);
        TreatmentStep::create([
            'treatment_id' => '39',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '1',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '2',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '3',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '4',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '5',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '6',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '7',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '8',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '9',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '10',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '11',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '12',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '13',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '14',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '15',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '16',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '17',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '18',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '19',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '20',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '21',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '22',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '23',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '24',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '25',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '26',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '27',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '28',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '29',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '30',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '31',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '32',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '33',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '34',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '35',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '36',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '37',
            'step_id' => '48',
        ]);
        TreatmentStep::create([
            'treatment_id' => '38',
            'step_id' => '48',
        ]);



        







    }

    public function initAddress()
    {

        City::create([
            'id' => 1,
            'name' => 'Thành Phố Hà Nội'
        ]);
        City::create([
            'id' => 2,
            'name' => 'Tỉnh Hà Giang'
        ]);
        City::create([
            'id' => 4,
            'name' => 'Tỉnh Cao Bằng'
        ]);
        City::create([
            'id' => 6,
            'name' => 'Tỉnh Bắc Kạn'
        ]);
        City::create([
            'id' => 8,
            'name' => 'Tỉnh Tuyên Quang'
        ]);
        City::create([
            'id' => 10,
            'name' => 'Tỉnh Lào Cai'
        ]);
        City::create([
            'id' => 11,
            'name' => 'Tỉnh Điện Biên'
        ]);
        City::create([
            'id' => 12,
            'name' => 'Tỉnh Lai Châu'
        ]);
        City::create([
            'id' => 14,
            'name' => 'Tỉnh Sơn La'
        ]);
        City::create([
            'id' => 15,
            'name' => 'Tỉnh Yên Bái'
        ]);
        City::create([
            'id' => 17,
            'name' => 'Tỉnh Hòa Bình'
        ]);
        City::create([
            'id' => 19,
            'name' => 'Tỉnh Thái Nguyên'
        ]);
        City::create([
            'id' => 20,
            'name' => 'Tỉnh Lạng Sơn'
        ]);
        City::create([
            'id' => 22,
            'name' => 'Tỉnh Quảng Ninh'
        ]);
        City::create([
            'id' => 24,
            'name' => 'Tỉnh Bắc Giang'
        ]);
        City::create([
            'id' => 25,
            'name' => 'Tỉnh Phú Thọ'
        ]);
        City::create([
            'id' => 26,
            'name' => 'Tỉnh Vĩnh Phúc'
        ]);
        City::create([
            'id' => 27,
            'name' => 'Tỉnh Bắc Ninh'
        ]);
        City::create([
            'id' => 30,
            'name' => 'Tỉnh Hải Dương'
        ]);
        City::create([
            'id' => 31,
            'name' => 'Thành Phố Hải Phòng'
        ]);
        City::create([
            'id' => 33,
            'name' => 'Tỉnh Hưng Yên'
        ]);
        City::create([
            'id' => 34,
            'name' => 'Tỉnh Thái Bình'
        ]);
        City::create([
            'id' => 35,
            'name' => 'Tỉnh Hà Nam'
        ]);
        City::create([
            'id' => 36,
            'name' => 'Tỉnh Nam Định'
        ]);
        City::create([
            'id' => 37,
            'name' => 'Tỉnh Ninh Bình'
        ]);
        City::create([
            'id' => 38,
            'name' => 'Tỉnh Thanh Hóa'
        ]);
        City::create([
            'id' => 40,
            'name' => 'Tỉnh Nghệ An'
        ]);
        City::create([
            'id' => 42,
            'name' => 'Tỉnh Hà Tĩnh'
        ]);
        City::create([
            'id' => 44,
            'name' => 'Tỉnh Quảng Bình'
        ]);
        City::create([
            'id' => 45,
            'name' => 'Tỉnh Quảng Trị'
        ]);
        City::create([
            'id' => 46,
            'name' => 'Tỉnh Thừa Thiên Huế'
        ]);
        City::create([
            'id' => 48,
            'name' => 'Thành Phố Đà Nẵng'
        ]);
        City::create([
            'id' => 49,
            'name' => 'Tỉnh Quảng Nam'
        ]);
        City::create([
            'id' => 51,
            'name' => 'Tỉnh Quảng Ngãi'
        ]);
        City::create([
            'id' => 52,
            'name' => 'Tỉnh Bình Định'
        ]);
        City::create([
            'id' => 54,
            'name' => 'Tỉnh Phú Yên'
        ]);
        City::create([
            'id' => 56,
            'name' => 'Tỉnh Khánh Hòa'
        ]);
        City::create([
            'id' => 58,
            'name' => 'Tỉnh Ninh Thuận'
        ]);
        City::create([
            'id' => 60,
            'name' => 'Tỉnh Bình Thuận'
        ]);
        City::create([
            'id' => 62,
            'name' => 'Tỉnh Kon Tum'
        ]);
        City::create([
            'id' => 64,
            'name' => 'Tỉnh Gia Lai'
        ]);
        City::create([
            'id' => 66,
            'name' => 'Tỉnh Đắk Lắk'
        ]);
        City::create([
            'id' => 67,
            'name' => 'Tỉnh Đắk Nông'
        ]);
        City::create([
            'id' => 68,
            'name' => 'Tỉnh Lâm Đồng'
        ]);
        City::create([
            'id' => 70,
            'name' => 'Tỉnh Bình Phước'
        ]);
        City::create([
            'id' => 72,
            'name' => 'Tỉnh Tây Ninh'
        ]);
        City::create([
            'id' => 74,
            'name' => 'Tỉnh Bình Dương'
        ]);
        City::create([
            'id' => 75,
            'name' => 'Tỉnh Đồng Nai'
        ]);
        City::create([
            'id' => 77,
            'name' => 'Tỉnh Bà Rịa - Vũng Tàu'
        ]);
        City::create([
            'id' => 79,
            'name' => 'Thành Phố Hồ Chí Minh'
        ]);
        City::create([
            'id' => 80,
            'name' => 'Tỉnh Long An'
        ]);
        City::create([
            'id' => 82,
            'name' => 'Tỉnh Tiền Giang'
        ]);
        City::create([
            'id' => 83,
            'name' => 'Tỉnh Bến Tre'
        ]);
        City::create([
            'id' => 84,
            'name' => 'Tỉnh Trà Vinh'
        ]);
        City::create([
            'id' => 86,
            'name' => 'Tỉnh Vĩnh Long'
        ]);
        City::create([
            'id' => 87,
            'name' => 'Tỉnh Đồng Tháp'
        ]);
        City::create([
            'id' => 89,
            'name' => 'Tỉnh An Giang'
        ]);
        City::create([
            'id' => 91,
            'name' => 'Tỉnh Kiên Giang'
        ]);
        City::create([
            'id' => 92,
            'name' => 'Thành Phố Cần Thơ'
        ]);
        City::create([
            'id' => 93,
            'name' => 'Tỉnh Hậu Giang'
        ]);
        City::create([
            'id' => 94,
            'name' => 'Tỉnh Sóc Trăng'
        ]);
        City::create([
            'id' => 95,
            'name' => 'Tỉnh Bạc Liêu'
        ]);
        City::create([
            'id' => 96,
            'name' => 'Tỉnh; Cà Mau'
        ]);
        District::create([
            'id' => 1,
            'name' => 'Quận Ba Đình',
            'city_id' => 1
        ]);
        District::create([
            'id' => 2,
            'name' => 'Quận Hoàn Kiếm',
            'city_id' => 1
        ]);
        District::create([
            'id' => 3,
            'name' => 'Quận Tây Hồ',
            'city_id' => 1
        ]);
        District::create([
            'id' => 4,
            'name' => 'Quận Long Biên',
            'city_id' => 1
        ]);
        District::create([
            'id' => 5,
            'name' => 'Quận Cầu Giấy',
            'city_id' => 1
        ]);
        District::create([
            'id' => 6,
            'name' => 'Quận Đống Đa',
            'city_id' => 1
        ]);
        District::create([
            'id' => 7,
            'name' => 'Quận Hai Bà Trưng',
            'city_id' => 1
        ]);
        District::create([
            'id' => 8,
            'name' => 'Quận Hoàng Mai',
            'city_id' => 1
        ]);
        District::create([
            'id' => 9,
            'name' => 'Quận Thanh Xuân',
            'city_id' => 1
        ]);
        District::create([
            'id' => 16,
            'name' => 'Huyện Sóc Sơn',
            'city_id' => 1
        ]);
        District::create([
            'id' => 17,
            'name' => 'Huyện Đông Anh',
            'city_id' => 1
        ]);
        District::create([
            'id' => 18,
            'name' => 'Huyện Gia Lâm',
            'city_id' => 1
        ]);
        District::create([
            'id' => 19,
            'name' => 'Huyện Từ Liêm',
            'city_id' => 1
        ]);
        District::create([
            'id' => 20,
            'name' => 'Huyện Thanh Trì',
            'city_id' => 1
        ]);
        District::create([
            'id' => 24,
            'name' => 'Thị Xã Hà Giang',
            'city_id' => 2
        ]);
        District::create([
            'id' => 26,
            'name' => 'Huyện Đồng Văn',
            'city_id' => 2
        ]);
        District::create([
            'id' => 27,
            'name' => 'Huyện Mèo Vạc',
            'city_id' => 2
        ]);
        District::create([
            'id' => 28,
            'name' => 'Huyện Yên Minh',
            'city_id' => 2
        ]);
        District::create([
            'id' => 29,
            'name' => 'Huyện Quản Bạ',
            'city_id' => 2
        ]);
        District::create([
            'id' => 30,
            'name' => 'Huyện Vị Xuyên',
            'city_id' => 2
        ]);
        District::create([
            'id' => 31,
            'name' => 'Huyện Bắc Mê',
            'city_id' => 2
        ]);
        District::create([
            'id' => 32,
            'name' => 'Huyện Hoàng Su Phì',
            'city_id' => 2
        ]);
        District::create([
            'id' => 33,
            'name' => 'Huyện Xín Mần',
            'city_id' => 2
        ]);
        District::create([
            'id' => 34,
            'name' => 'Huyện Bắc Quang',
            'city_id' => 2
        ]);
        District::create([
            'id' => 35,
            'name' => 'Huyện Quang Bình',
            'city_id' => 2
        ]);
        District::create([
            'id' => 40,
            'name' => 'Thị Xã Cao Bằng',
            'city_id' => 4
        ]);
        District::create([
            'id' => 42,
            'name' => 'Huyện Bảo Lâm',
            'city_id' => 4
        ]);
        District::create([
            'id' => 43,
            'name' => 'Huyện Bảo Lạc',
            'city_id' => 4
        ]);
        District::create([
            'id' => 44,
            'name' => 'Huyện Thông Nông',
            'city_id' => 4
        ]);
        District::create([
            'id' => 45,
            'name' => 'Huyện Hà Quảng',
            'city_id' => 4
        ]);
        District::create([
            'id' => 46,
            'name' => 'Huyện Trà Lĩnh',
            'city_id' => 4
        ]);
        District::create([
            'id' => 47,
            'name' => 'Huyện Trùng Khánh',
            'city_id' => 4
        ]);
        District::create([
            'id' => 48,
            'name' => 'Huyện Hạ Lang',
            'city_id' => 4
        ]);
        District::create([
            'id' => 49,
            'name' => 'Huyện Quảng Uyên',
            'city_id' => 4
        ]);
        District::create([
            'id' => 50,
            'name' => 'Huyện Phục Hoà',
            'city_id' => 4
        ]);
        District::create([
            'id' => 51,
            'name' => 'Huyện Hoà An',
            'city_id' => 4
        ]);
        District::create([
            'id' => 52,
            'name' => 'Huyện Nguyên Bình',
            'city_id' => 4
        ]);
        District::create([
            'id' => 53,
            'name' => 'Huyện Thạch An',
            'city_id' => 4
        ]);
        District::create([
            'id' => 58,
            'name' => 'Thị Xã Bắc Kạn',
            'city_id' => 6
        ]);
        District::create([
            'id' => 60,
            'name' => 'Huyện Pác Nặm',
            'city_id' => 6
        ]);
        District::create([
            'id' => 61,
            'name' => 'Huyện Ba Bể',
            'city_id' => 6
        ]);
        District::create([
            'id' => 62,
            'name' => 'Huyện Ngân Sơn',
            'city_id' => 6
        ]);
        District::create([
            'id' => 63,
            'name' => 'Huyện Bạch Thông',
            'city_id' => 6
        ]);
        District::create([
            'id' => 64,
            'name' => 'Huyện Chợ Đồn',
            'city_id' => 6
        ]);
        District::create([
            'id' => 65,
            'name' => 'Huyện Chợ Mới',
            'city_id' => 6
        ]);
        District::create([
            'id' => 66,
            'name' => 'Huyện Na Rì',
            'city_id' => 6
        ]);
        District::create([
            'id' => 70,
            'name' => 'Thị Xã Tuyên Quang',
            'city_id' => 8
        ]);
        District::create([
            'id' => 72,
            'name' => 'Huyện Nà Hang',
            'city_id' => 8
        ]);
        District::create([
            'id' => 73,
            'name' => 'Huyện Chiêm Hóa',
            'city_id' => 8
        ]);
        District::create([
            'id' => 74,
            'name' => 'Huyện Hàm Yên',
            'city_id' => 8
        ]);
        District::create([
            'id' => 75,
            'name' => 'Huyện Yên Sơn',
            'city_id' => 8
        ]);
        District::create([
            'id' => 76,
            'name' => 'Huyện Sơn Dương',
            'city_id' => 8
        ]);
        District::create([
            'id' => 80,
            'name' => 'Thành Phố Lào Cai',
            'city_id' => 10
        ]);
        District::create([
            'id' => 82,
            'name' => 'Huyện Bát Xát',
            'city_id' => 10
        ]);
        District::create([
            'id' => 83,
            'name' => 'Huyện Mường Khương',
            'city_id' => 10
        ]);
        District::create([
            'id' => 84,
            'name' => 'Huyện Si Ma Cai',
            'city_id' => 10
        ]);
        District::create([
            'id' => 85,
            'name' => 'Huyện Bắc Hà',
            'city_id' => 10
        ]);
        District::create([
            'id' => 86,
            'name' => 'Huyện Bảo Thắng',
            'city_id' => 10
        ]);
        District::create([
            'id' => 87,
            'name' => 'Huyện Bảo Yên',
            'city_id' => 10
        ]);
        District::create([
            'id' => 88,
            'name' => 'Huyện Sa Pa',
            'city_id' => 10
        ]);
        District::create([
            'id' => 89,
            'name' => 'Huyện Văn Bàn',
            'city_id' => 10
        ]);
        District::create([
            'id' => 94,
            'name' => 'Thành Phố Điện Biên Phủ',
            'city_id' => 11
        ]);
        District::create([
            'id' => 95,
            'name' => 'Thị Xã Mường Lay',
            'city_id' => 11
        ]);
        District::create([
            'id' => 96,
            'name' => 'Huyện Mường Nhé',
            'city_id' => 11
        ]);
        District::create([
            'id' => 97,
            'name' => 'Huyện Mường Chà',
            'city_id' => 11
        ]);
        District::create([
            'id' => 98,
            'name' => 'Huyện Tủa Chùa',
            'city_id' => 11
        ]);
        District::create([
            'id' => 99,
            'name' => 'Huyện Tuần Giáo',
            'city_id' => 11
        ]);
        District::create([
            'id' => 100,
            'name' => 'Huyện Điện Biên',
            'city_id' => 11
        ]);
        District::create([
            'id' => 101,
            'name' => 'Huyện Điện Biên Đông',
            'city_id' => 11
        ]);
        District::create([
            'id' => 102,
            'name' => 'Huyện Mường Ảng',
            'city_id' => 11
        ]);
        District::create([
            'id' => 104,
            'name' => 'Thị Xã Lai Châu',
            'city_id' => 12
        ]);
        District::create([
            'id' => 106,
            'name' => 'Huyện Tam Đường',
            'city_id' => 12
        ]);
        District::create([
            'id' => 107,
            'name' => 'Huyện Mường Tè',
            'city_id' => 12
        ]);
        District::create([
            'id' => 108,
            'name' => 'Huyện Sìn Hồ',
            'city_id' => 12
        ]);
        District::create([
            'id' => 109,
            'name' => 'Huyện Phong Thổ',
            'city_id' => 12
        ]);
        District::create([
            'id' => 110,
            'name' => 'Huyện Than Uyên',
            'city_id' => 12
        ]);
        District::create([
            'id' => 111,
            'name' => 'Huyện Tân Uyên',
            'city_id' => 12
        ]);
        District::create([
            'id' => 116,
            'name' => 'Thành Phố Sơn La',
            'city_id' => 14
        ]);
        District::create([
            'id' => 118,
            'name' => 'Huyện Quỳnh Nhai',
            'city_id' => 14
        ]);
        District::create([
            'id' => 119,
            'name' => 'Huyện Thuận Châu',
            'city_id' => 14
        ]);
        District::create([
            'id' => 120,
            'name' => 'Huyện Mường La',
            'city_id' => 14
        ]);
        District::create([
            'id' => 121,
            'name' => 'Huyện Bắc Yên',
            'city_id' => 14
        ]);
        District::create([
            'id' => 122,
            'name' => 'Huyện Phù Yên',
            'city_id' => 14
        ]);
        District::create([
            'id' => 123,
            'name' => 'Huyện Mộc Châu',
            'city_id' => 14
        ]);
        District::create([
            'id' => 124,
            'name' => 'Huyện Yên Châu',
            'city_id' => 14
        ]);
        District::create([
            'id' => 125,
            'name' => 'Huyện Mai Sơn',
            'city_id' => 14
        ]);
        District::create([
            'id' => 126,
            'name' => 'Huyện Sông Mã',
            'city_id' => 14
        ]);
        District::create([
            'id' => 127,
            'name' => 'Huyện Sốp Cộp',
            'city_id' => 14
        ]);
        District::create([
            'id' => 132,
            'name' => 'Thành Phố Yên Bái',
            'city_id' => 15
        ]);
        District::create([
            'id' => 133,
            'name' => 'Thị Xã Nghĩa Lộ',
            'city_id' => 15
        ]);
        District::create([
            'id' => 135,
            'name' => 'Huyện Lục Yên',
            'city_id' => 15
        ]);
        District::create([
            'id' => 136,
            'name' => 'Huyện Văn Yên',
            'city_id' => 15
        ]);
        District::create([
            'id' => 137,
            'name' => 'Huyện Mù Cang Chải',
            'city_id' => 15
        ]);
        District::create([
            'id' => 138,
            'name' => 'Huyện Trấn Yên',
            'city_id' => 15
        ]);
        District::create([
            'id' => 139,
            'name' => 'Huyện Trạm Tấu',
            'city_id' => 15
        ]);
        District::create([
            'id' => 140,
            'name' => 'Huyện Văn Chấn',
            'city_id' => 15
        ]);
        District::create([
            'id' => 141,
            'name' => 'Huyện Yên Bình',
            'city_id' => 15
        ]);
        District::create([
            'id' => 148,
            'name' => 'Thành Phố Hòa Bình',
            'city_id' => 17
        ]);
        District::create([
            'id' => 150,
            'name' => 'Huyện Đà Bắc',
            'city_id' => 17
        ]);
        District::create([
            'id' => 151,
            'name' => 'Huyện Kỳ Sơn',
            'city_id' => 17
        ]);
        District::create([
            'id' => 152,
            'name' => 'Huyện Lương Sơn',
            'city_id' => 17
        ]);
        District::create([
            'id' => 153,
            'name' => 'Huyện Kim Bôi',
            'city_id' => 17
        ]);
        District::create([
            'id' => 154,
            'name' => 'Huyện Cao Phong',
            'city_id' => 17
        ]);
        District::create([
            'id' => 155,
            'name' => 'Huyện Tân Lạc',
            'city_id' => 17
        ]);
        District::create([
            'id' => 156,
            'name' => 'Huyện Mai Châu',
            'city_id' => 17
        ]);
        District::create([
            'id' => 157,
            'name' => 'Huyện Lạc Sơn',
            'city_id' => 17
        ]);
        District::create([
            'id' => 158,
            'name' => 'Huyện Yên Thủy',
            'city_id' => 17
        ]);
        District::create([
            'id' => 159,
            'name' => 'Huyện Lạc Thủy',
            'city_id' => 17
        ]);
        District::create([
            'id' => 164,
            'name' => 'Thành Phố Thái Nguyên',
            'city_id' => 19
        ]);
        District::create([
            'id' => 165,
            'name' => 'Thị Xã Sông Công',
            'city_id' => 19
        ]);
        District::create([
            'id' => 167,
            'name' => 'Huyện Định Hóa',
            'city_id' => 19
        ]);
        District::create([
            'id' => 168,
            'name' => 'Huyện Phú Lương',
            'city_id' => 19
        ]);
        District::create([
            'id' => 169,
            'name' => 'Huyện Đồng Hỷ',
            'city_id' => 19
        ]);
        District::create([
            'id' => 170,
            'name' => 'Huyện Võ Nhai',
            'city_id' => 19
        ]);
        District::create([
            'id' => 171,
            'name' => 'Huyện Đại Từ',
            'city_id' => 19
        ]);
        District::create([
            'id' => 172,
            'name' => 'Huyện Phổ Yên',
            'city_id' => 19
        ]);
        District::create([
            'id' => 173,
            'name' => 'Huyện Phú Bình',
            'city_id' => 19
        ]);
        District::create([
            'id' => 178,
            'name' => 'Thành Phố Lạng Sơn',
            'city_id' => 20
        ]);
        District::create([
            'id' => 180,
            'name' => 'Huyện Tràng Định',
            'city_id' => 20
        ]);
        District::create([
            'id' => 181,
            'name' => 'Huyện Bình Gia',
            'city_id' => 20
        ]);
        District::create([
            'id' => 182,
            'name' => 'Huyện Văn Lãng',
            'city_id' => 20
        ]);
        District::create([
            'id' => 183,
            'name' => 'Huyện Cao Lộc',
            'city_id' => 20
        ]);
        District::create([
            'id' => 184,
            'name' => 'Huyện Văn Quan',
            'city_id' => 20
        ]);
        District::create([
            'id' => 185,
            'name' => 'Huyện Bắc Sơn',
            'city_id' => 20
        ]);
        District::create([
            'id' => 186,
            'name' => 'Huyện Hữu Lũng',
            'city_id' => 20
        ]);
        District::create([
            'id' => 187,
            'name' => 'Huyện Chi Lăng',
            'city_id' => 20
        ]);
        District::create([
            'id' => 188,
            'name' => 'Huyện Lộc Bình',
            'city_id' => 20
        ]);
        District::create([
            'id' => 189,
            'name' => 'Huyện Đình Lập',
            'city_id' => 20
        ]);
        District::create([
            'id' => 193,
            'name' => 'Thành Phố Hạ Long',
            'city_id' => 22
        ]);
        District::create([
            'id' => 194,
            'name' => 'Thành Phố Móng Cái',
            'city_id' => 22
        ]);
        District::create([
            'id' => 195,
            'name' => 'Thị Xã Cẩm Phả',
            'city_id' => 22
        ]);
        District::create([
            'id' => 196,
            'name' => 'Thị Xã Uông Bí',
            'city_id' => 22
        ]);
        District::create([
            'id' => 198,
            'name' => 'Huyện Bình Liêu',
            'city_id' => 22
        ]);
        District::create([
            'id' => 199,
            'name' => 'Huyện Tiên Yên',
            'city_id' => 22
        ]);
        District::create([
            'id' => 200,
            'name' => 'Huyện Đầm Hà',
            'city_id' => 22
        ]);
        District::create([
            'id' => 201,
            'name' => 'Huyện Hải Hà',
            'city_id' => 22
        ]);
        District::create([
            'id' => 202,
            'name' => 'Huyện Ba Chẽ',
            'city_id' => 22
        ]);
        District::create([
            'id' => 203,
            'name' => 'Huyện Vân Đồn',
            'city_id' => 22
        ]);
        District::create([
            'id' => 204,
            'name' => 'Huyện Hoành Bồ',
            'city_id' => 22
        ]);
        District::create([
            'id' => 205,
            'name' => 'Huyện Đông Triều',
            'city_id' => 22
        ]);
        District::create([
            'id' => 206,
            'name' => 'Huyện Yên Hưng',
            'city_id' => 22
        ]);
        District::create([
            'id' => 207,
            'name' => 'Huyện Cô Tô',
            'city_id' => 22
        ]);
        District::create([
            'id' => 213,
            'name' => 'Thành Phố Bắc Giang',
            'city_id' => 24
        ]);
        District::create([
            'id' => 215,
            'name' => 'Huyện Yên Thế',
            'city_id' => 24
        ]);
        District::create([
            'id' => 216,
            'name' => 'Huyện Tân Yên',
            'city_id' => 24
        ]);
        District::create([
            'id' => 217,
            'name' => 'Huyện Lạng Giang',
            'city_id' => 24
        ]);
        District::create([
            'id' => 218,
            'name' => 'Huyện Lục Nam',
            'city_id' => 24
        ]);
        District::create([
            'id' => 219,
            'name' => 'Huyện Lục Ngạn',
            'city_id' => 24
        ]);
        District::create([
            'id' => 220,
            'name' => 'Huyện Sơn Động',
            'city_id' => 24
        ]);
        District::create([
            'id' => 221,
            'name' => 'Huyện Yên Dũng',
            'city_id' => 24
        ]);
        District::create([
            'id' => 222,
            'name' => 'Huyện Việt Yên',
            'city_id' => 24
        ]);
        District::create([
            'id' => 223,
            'name' => 'Huyện Hiệp Hòa',
            'city_id' => 24
        ]);
        District::create([
            'id' => 227,
            'name' => 'Thành Phố Việt Trì',
            'city_id' => 25
        ]);
        District::create([
            'id' => 228,
            'name' => 'Thị Xã Phú Thọ',
            'city_id' => 25
        ]);
        District::create([
            'id' => 230,
            'name' => 'Huyện Đoan Hùng',
            'city_id' => 25
        ]);
        District::create([
            'id' => 231,
            'name' => 'Huyện Hạ Hoà',
            'city_id' => 25
        ]);
        District::create([
            'id' => 232,
            'name' => 'Huyện Thanh Ba',
            'city_id' => 25
        ]);
        District::create([
            'id' => 233,
            'name' => 'Huyện Phù Ninh',
            'city_id' => 25
        ]);
        District::create([
            'id' => 234,
            'name' => 'Huyện Yên Lập',
            'city_id' => 25
        ]);
        District::create([
            'id' => 235,
            'name' => 'Huyện Cẩm Khê',
            'city_id' => 25
        ]);
        District::create([
            'id' => 236,
            'name' => 'Huyện Tam Nông',
            'city_id' => 25
        ]);
        District::create([
            'id' => 237,
            'name' => 'Huyện Lâm Thao',
            'city_id' => 25
        ]);
        District::create([
            'id' => 238,
            'name' => 'Huyện Thanh Sơn',
            'city_id' => 25
        ]);
        District::create([
            'id' => 239,
            'name' => 'Huyện Thanh Thuỷ',
            'city_id' => 25
        ]);
        District::create([
            'id' => 240,
            'name' => 'Huyện Tân Sơn',
            'city_id' => 25
        ]);
        District::create([
            'id' => 243,
            'name' => 'Thành Phố Vĩnh Yên',
            'city_id' => 26
        ]);
        District::create([
            'id' => 244,
            'name' => 'Thị Xã Phúc Yên',
            'city_id' => 26
        ]);
        District::create([
            'id' => 246,
            'name' => 'Huyện Lập Thạch',
            'city_id' => 26
        ]);
        District::create([
            'id' => 247,
            'name' => 'Huyện Tam Dương',
            'city_id' => 26
        ]);
        District::create([
            'id' => 248,
            'name' => 'Huyện Tam Đảo',
            'city_id' => 26
        ]);
        District::create([
            'id' => 249,
            'name' => 'Huyện Bình Xuyên',
            'city_id' => 26
        ]);
        District::create([
            'id' => 250,
            'name' => 'Huyện Mê Linh',
            'city_id' => 1
        ]);
        District::create([
            'id' => 251,
            'name' => 'Huyện Yên Lạc',
            'city_id' => 26
        ]);
        District::create([
            'id' => 252,
            'name' => 'Huyện Vĩnh Tường',
            'city_id' => 26
        ]);
        District::create([
            'id' => 253,
            'name' => 'Huyện Sông Lô',
            'city_id' => 26
        ]);
        District::create([
            'id' => 256,
            'name' => 'Thành Phố Bắc Ninh',
            'city_id' => 27
        ]);
        District::create([
            'id' => 258,
            'name' => 'Huyện Yên Phong',
            'city_id' => 27
        ]);
        District::create([
            'id' => 259,
            'name' => 'Huyện Quế Võ',
            'city_id' => 27
        ]);
        District::create([
            'id' => 260,
            'name' => 'Huyện Tiên Du',
            'city_id' => 27
        ]);
        District::create([
            'id' => 261,
            'name' => 'Thị Xã Từ Sơn',
            'city_id' => 27
        ]);
        District::create([
            'id' => 262,
            'name' => 'Huyện Thuận Thành',
            'city_id' => 27
        ]);
        District::create([
            'id' => 263,
            'name' => 'Huyện Gia Bình',
            'city_id' => 27
        ]);
        District::create([
            'id' => 264,
            'name' => 'Huyện Lương Tài',
            'city_id' => 27
        ]);
        District::create([
            'id' => 268,
            'name' => 'Quận Hà Đông',
            'city_id' => 1
        ]);
        District::create([
            'id' => 269,
            'name' => 'Thị Xã Sơn Tây',
            'city_id' => 1
        ]);
        District::create([
            'id' => 271,
            'name' => 'Huyện Ba Vì',
            'city_id' => 1
        ]);
        District::create([
            'id' => 272,
            'name' => 'Huyện Phúc Thọ',
            'city_id' => 1
        ]);
        District::create([
            'id' => 273,
            'name' => 'Huyện Đan Phượng',
            'city_id' => 1
        ]);
        District::create([
            'id' => 274,
            'name' => 'Huyện Hoài Đức',
            'city_id' => 1
        ]);
        District::create([
            'id' => 275,
            'name' => 'Huyện Quốc Oai',
            'city_id' => 1
        ]);
        District::create([
            'id' => 276,
            'name' => 'Huyện Thạch Thất',
            'city_id' => 1
        ]);
        District::create([
            'id' => 277,
            'name' => 'Huyện Chương Mỹ',
            'city_id' => 1
        ]);
        District::create([
            'id' => 278,
            'name' => 'Huyện Thanh Oai',
            'city_id' => 1
        ]);
        District::create([
            'id' => 279,
            'name' => 'Huyện Thường Tín',
            'city_id' => 1
        ]);
        District::create([
            'id' => 280,
            'name' => 'Huyện Phú Xuyên',
            'city_id' => 1
        ]);
        District::create([
            'id' => 281,
            'name' => 'Huyện Ứng Hòa',
            'city_id' => 1
        ]);
        District::create([
            'id' => 282,
            'name' => 'Huyện Mỹ Đức',
            'city_id' => 1
        ]);
        District::create([
            'id' => 288,
            'name' => 'Thành Phố Hải Dương',
            'city_id' => 30
        ]);
        District::create([
            'id' => 290,
            'name' => 'Huyện Chí Linh',
            'city_id' => 30
        ]);
        District::create([
            'id' => 291,
            'name' => 'Huyện Nam Sách',
            'city_id' => 30
        ]);
        District::create([
            'id' => 292,
            'name' => 'Huyện Kinh Môn',
            'city_id' => 30
        ]);
        District::create([
            'id' => 293,
            'name' => 'Huyện Kim Thành',
            'city_id' => 30
        ]);
        District::create([
            'id' => 294,
            'name' => 'Huyện Thanh Hà',
            'city_id' => 30
        ]);
        District::create([
            'id' => 295,
            'name' => 'Huyện Cẩm Giàng',
            'city_id' => 30
        ]);
        District::create([
            'id' => 296,
            'name' => 'Huyện Bình Giang',
            'city_id' => 30
        ]);
        District::create([
            'id' => 297,
            'name' => 'Huyện Gia Lộc',
            'city_id' => 30
        ]);
        District::create([
            'id' => 298,
            'name' => 'Huyện Tứ Kỳ',
            'city_id' => 30
        ]);
        District::create([
            'id' => 299,
            'name' => 'Huyện Ninh Giang',
            'city_id' => 30
        ]);
        District::create([
            'id' => 300,
            'name' => 'Huyện Thanh Miện',
            'city_id' => 30
        ]);
        District::create([
            'id' => 303,
            'name' => 'Quận Hồng Bàng',
            'city_id' => 31
        ]);
        District::create([
            'id' => 304,
            'name' => 'Quận Ngô Quyền',
            'city_id' => 31
        ]);
        District::create([
            'id' => 305,
            'name' => 'Quận Lê Chân',
            'city_id' => 31
        ]);
        District::create([
            'id' => 306,
            'name' => 'Quận Hải An',
            'city_id' => 31
        ]);
        District::create([
            'id' => 307,
            'name' => 'Quận Kiến An',
            'city_id' => 31
        ]);
        District::create([
            'id' => 308,
            'name' => 'Quận Đồ Sơn',
            'city_id' => 31
        ]);
        District::create([
            'id' => 309,
            'name' => 'Quận Kinh Dương',
            'city_id' => 31
        ]);
        District::create([
            'id' => 311,
            'name' => 'Huyện Thuỷ Nguyên',
            'city_id' => 31
        ]);
        District::create([
            'id' => 312,
            'name' => 'Huyện An Dương',
            'city_id' => 31
        ]);
        District::create([
            'id' => 313,
            'name' => 'Huyện An Lão',
            'city_id' => 31
        ]);
        District::create([
            'id' => 314,
            'name' => 'Huyện Kiến Thụy',
            'city_id' => 31
        ]);
        District::create([
            'id' => 315,
            'name' => 'Huyện Tiên Lãng',
            'city_id' => 31
        ]);
        District::create([
            'id' => 316,
            'name' => 'Huyện Vĩnh Bảo',
            'city_id' => 31
        ]);
        District::create([
            'id' => 317,
            'name' => 'Huyện Cát Hải',
            'city_id' => 31
        ]);
        District::create([
            'id' => 318,
            'name' => 'Huyện Bạch Long Vĩ',
            'city_id' => 31
        ]);
        District::create([
            'id' => 323,
            'name' => 'Thành Phố Hưng Yên',
            'city_id' => 33
        ]);
        District::create([
            'id' => 325,
            'name' => 'Huyện Văn Lâm',
            'city_id' => 33
        ]);
        District::create([
            'id' => 326,
            'name' => 'Huyện Văn Giang',
            'city_id' => 33
        ]);
        District::create([
            'id' => 327,
            'name' => 'Huyện Yên Mỹ',
            'city_id' => 33
        ]);
        District::create([
            'id' => 328,
            'name' => 'Huyện Mỹ Hào',
            'city_id' => 33
        ]);
        District::create([
            'id' => 329,
            'name' => 'Huyện Ân Thi',
            'city_id' => 33
        ]);
        District::create([
            'id' => 330,
            'name' => 'Huyện Khoái Châu',
            'city_id' => 33
        ]);
        District::create([
            'id' => 331,
            'name' => 'Huyện Kim Động',
            'city_id' => 33
        ]);
        District::create([
            'id' => 332,
            'name' => 'Huyện Tiên Lữ',
            'city_id' => 33
        ]);
        District::create([
            'id' => 333,
            'name' => 'Huyện Phù Cừ',
            'city_id' => 33
        ]);
        District::create([
            'id' => 336,
            'name' => 'Thành Phố Thái Bình',
            'city_id' => 34
        ]);
        District::create([
            'id' => 338,
            'name' => 'Huyện Quỳnh Phụ',
            'city_id' => 34
        ]);
        District::create([
            'id' => 339,
            'name' => 'Huyện Hưng Hà',
            'city_id' => 34
        ]);
        District::create([
            'id' => 340,
            'name' => 'Huyện Đông Hưng',
            'city_id' => 34
        ]);
        District::create([
            'id' => 341,
            'name' => 'Huyện Thái Thụy',
            'city_id' => 34
        ]);
        District::create([
            'id' => 342,
            'name' => 'Huyện Tiền Hải',
            'city_id' => 34
        ]);
        District::create([
            'id' => 343,
            'name' => 'Huyện Kiến Xương',
            'city_id' => 34
        ]);
        District::create([
            'id' => 344,
            'name' => 'Huyện Vũ Thư',
            'city_id' => 34
        ]);
        District::create([
            'id' => 347,
            'name' => 'Thành Phố Phủ Lý',
            'city_id' => 35
        ]);
        District::create([
            'id' => 349,
            'name' => 'Huyện Duy Tiên',
            'city_id' => 35
        ]);
        District::create([
            'id' => 350,
            'name' => 'Huyện Kim Bảng',
            'city_id' => 35
        ]);
        District::create([
            'id' => 351,
            'name' => 'Huyện Thanh Liêm',
            'city_id' => 35
        ]);
        District::create([
            'id' => 352,
            'name' => 'Huyện Bình Lục',
            'city_id' => 35
        ]);
        District::create([
            'id' => 353,
            'name' => 'Huyện Lý Nhân',
            'city_id' => 35
        ]);
        District::create([
            'id' => 356,
            'name' => 'Thành Phố Nam Định',
            'city_id' => 36
        ]);
        District::create([
            'id' => 358,
            'name' => 'Huyện Mỹ Lộc',
            'city_id' => 36
        ]);
        District::create([
            'id' => 359,
            'name' => 'Huyện Vụ Bản',
            'city_id' => 36
        ]);
        District::create([
            'id' => 360,
            'name' => 'Huyện Ý Yên',
            'city_id' => 36
        ]);
        District::create([
            'id' => 361,
            'name' => 'Huyện Nghĩa Hưng',
            'city_id' => 36
        ]);
        District::create([
            'id' => 362,
            'name' => 'Huyện Nam Trực',
            'city_id' => 36
        ]);
        District::create([
            'id' => 363,
            'name' => 'Huyện Trực Ninh',
            'city_id' => 36
        ]);
        District::create([
            'id' => 364,
            'name' => 'Huyện Xuân Trường',
            'city_id' => 36
        ]);
        District::create([
            'id' => 365,
            'name' => 'Huyện Giao Thủy',
            'city_id' => 36
        ]);
        District::create([
            'id' => 366,
            'name' => 'Huyện Hải Hậu',
            'city_id' => 36
        ]);
        District::create([
            'id' => 369,
            'name' => 'Thành Phố Ninh Bình',
            'city_id' => 37
        ]);
        District::create([
            'id' => 370,
            'name' => 'Thị Xã Tam Điệp',
            'city_id' => 37
        ]);
        District::create([
            'id' => 372,
            'name' => 'Huyện Nho Quan',
            'city_id' => 37
        ]);
        District::create([
            'id' => 373,
            'name' => 'Huyện Gia Viễn',
            'city_id' => 37
        ]);
        District::create([
            'id' => 374,
            'name' => 'Huyện Hoa Lư',
            'city_id' => 37
        ]);
        District::create([
            'id' => 375,
            'name' => 'Huyện Yên Khánh',
            'city_id' => 37
        ]);
        District::create([
            'id' => 376,
            'name' => 'Huyện Kim Sơn',
            'city_id' => 37
        ]);
        District::create([
            'id' => 377,
            'name' => 'Huyện Yên Mô',
            'city_id' => 37
        ]);
        District::create([
            'id' => 380,
            'name' => 'Thành Phố Thanh Hóa',
            'city_id' => 38
        ]);
        District::create([
            'id' => 381,
            'name' => 'Thị Xã Bỉm Sơn',
            'city_id' => 38
        ]);
        District::create([
            'id' => 382,
            'name' => 'Thị Xã Sầm Sơn',
            'city_id' => 38
        ]);
        District::create([
            'id' => 384,
            'name' => 'Huyện Mường Lát',
            'city_id' => 38
        ]);
        District::create([
            'id' => 385,
            'name' => 'Huyện Quan Hóa',
            'city_id' => 38
        ]);
        District::create([
            'id' => 386,
            'name' => 'Huyện Bá Thước',
            'city_id' => 38
        ]);
        District::create([
            'id' => 387,
            'name' => 'Huyện Quan Sơn',
            'city_id' => 38
        ]);
        District::create([
            'id' => 388,
            'name' => 'Huyện Lang Chánh',
            'city_id' => 38
        ]);
        District::create([
            'id' => 389,
            'name' => 'Huyện Ngọc Lặc',
            'city_id' => 38
        ]);
        District::create([
            'id' => 390,
            'name' => 'Huyện Cẩm Thủy',
            'city_id' => 38
        ]);
        District::create([
            'id' => 391,
            'name' => 'Huyện Thạch Thành',
            'city_id' => 38
        ]);
        District::create([
            'id' => 392,
            'name' => 'Huyện Hà Trung',
            'city_id' => 38
        ]);
        District::create([
            'id' => 393,
            'name' => 'Huyện Vĩnh Lộc',
            'city_id' => 38
        ]);
        District::create([
            'id' => 394,
            'name' => 'Huyện Yên Định',
            'city_id' => 38
        ]);
        District::create([
            'id' => 395,
            'name' => 'Huyện Thọ Xuân',
            'city_id' => 38
        ]);
        District::create([
            'id' => 396,
            'name' => 'Huyện Thường Xuân',
            'city_id' => 38
        ]);
        District::create([
            'id' => 397,
            'name' => 'Huyện Triệu Sơn',
            'city_id' => 38
        ]);
        District::create([
            'id' => 398,
            'name' => 'Huyện Thiệu Hoá',
            'city_id' => 38
        ]);
        District::create([
            'id' => 399,
            'name' => 'Huyện Hoằng Hóa',
            'city_id' => 38
        ]);
        District::create([
            'id' => 400,
            'name' => 'Huyện Hậu Lộc',
            'city_id' => 38
        ]);
        District::create([
            'id' => 401,
            'name' => 'Huyện Nga Sơn',
            'city_id' => 38
        ]);
        District::create([
            'id' => 402,
            'name' => 'Huyện Như Xuân',
            'city_id' => 38
        ]);
        District::create([
            'id' => 403,
            'name' => 'Huyện Như Thanh',
            'city_id' => 38
        ]);
        District::create([
            'id' => 404,
            'name' => 'Huyện Nông Cống',
            'city_id' => 38
        ]);
        District::create([
            'id' => 405,
            'name' => 'Huyện Đông Sơn',
            'city_id' => 38
        ]);
        District::create([
            'id' => 406,
            'name' => 'Huyện Quảng Xương',
            'city_id' => 38
        ]);
        District::create([
            'id' => 407,
            'name' => 'Huyện Tĩnh Gia',
            'city_id' => 38
        ]);
        District::create([
            'id' => 412,
            'name' => 'Thành Phố Vinh',
            'city_id' => 40
        ]);
        District::create([
            'id' => 413,
            'name' => 'Thị Xã Cửa Lò',
            'city_id' => 40
        ]);
        District::create([
            'id' => 414,
            'name' => 'Thị Xã Thái Hoà',
            'city_id' => 40
        ]);
        District::create([
            'id' => 415,
            'name' => 'Huyện Quế Phong',
            'city_id' => 40
        ]);
        District::create([
            'id' => 416,
            'name' => 'Huyện Quỳ Châu',
            'city_id' => 40
        ]);
        District::create([
            'id' => 417,
            'name' => 'Huyện Kỳ Sơn',
            'city_id' => 40
        ]);
        District::create([
            'id' => 418,
            'name' => 'Huyện Tương Dương',
            'city_id' => 40
        ]);
        District::create([
            'id' => 419,
            'name' => 'Huyện Nghĩa Đàn',
            'city_id' => 40
        ]);
        District::create([
            'id' => 420,
            'name' => 'Huyện Quỳ Hợp',
            'city_id' => 40
        ]);
        District::create([
            'id' => 421,
            'name' => 'Huyện Quỳnh Lưu',
            'city_id' => 40
        ]);
        District::create([
            'id' => 422,
            'name' => 'Huyện Con Cuông',
            'city_id' => 40
        ]);
        District::create([
            'id' => 423,
            'name' => 'Huyện Tân Kỳ',
            'city_id' => 40
        ]);
        District::create([
            'id' => 424,
            'name' => 'Huyện Anh Sơn',
            'city_id' => 40
        ]);
        District::create([
            'id' => 425,
            'name' => 'Huyện Diễn Châu',
            'city_id' => 40
        ]);
        District::create([
            'id' => 426,
            'name' => 'Huyện Yên Thành',
            'city_id' => 40
        ]);
        District::create([
            'id' => 427,
            'name' => 'Huyện Đô Lương',
            'city_id' => 40
        ]);
        District::create([
            'id' => 428,
            'name' => 'Huyện Thanh Chương',
            'city_id' => 40
        ]);
        District::create([
            'id' => 429,
            'name' => 'Huyện Nghi Lộc',
            'city_id' => 40
        ]);
        District::create([
            'id' => 430,
            'name' => 'Huyện Nam Đàn',
            'city_id' => 40
        ]);
        District::create([
            'id' => 431,
            'name' => 'Huyện Hưng Nguyên',
            'city_id' => 40
        ]);
        District::create([
            'id' => 436,
            'name' => 'Thành Phố Hà Tĩnh',
            'city_id' => 42
        ]);
        District::create([
            'id' => 437,
            'name' => 'Thị Xã Hồng Lĩnh',
            'city_id' => 42
        ]);
        District::create([
            'id' => 439,
            'name' => 'Huyện Hương Sơn',
            'city_id' => 42
        ]);
        District::create([
            'id' => 440,
            'name' => 'Huyện Đức Thọ',
            'city_id' => 42
        ]);
        District::create([
            'id' => 441,
            'name' => 'Huyện Vũ Quang',
            'city_id' => 42
        ]);
        District::create([
            'id' => 442,
            'name' => 'Huyện Nghi Xuân',
            'city_id' => 42
        ]);
        District::create([
            'id' => 443,
            'name' => 'Huyện Can Lộc',
            'city_id' => 42
        ]);
        District::create([
            'id' => 444,
            'name' => 'Huyện Hương Khê',
            'city_id' => 42
        ]);
        District::create([
            'id' => 445,
            'name' => 'Huyện Thạch Hà',
            'city_id' => 42
        ]);
        District::create([
            'id' => 446,
            'name' => 'Huyện Cẩm Xuyên',
            'city_id' => 42
        ]);
        District::create([
            'id' => 447,
            'name' => 'Huyện Kỳ Anh',
            'city_id' => 42
        ]);
        District::create([
            'id' => 448,
            'name' => 'Huyện Lộc Hà',
            'city_id' => 42
        ]);
        District::create([
            'id' => 450,
            'name' => 'Thành Phố Đồng Hới',
            'city_id' => 44
        ]);
        District::create([
            'id' => 452,
            'name' => 'Huyện Minh Hóa',
            'city_id' => 44
        ]);
        District::create([
            'id' => 453,
            'name' => 'Huyện Tuyên Hóa',
            'city_id' => 44
        ]);
        District::create([
            'id' => 454,
            'name' => 'Huyện Quảng Trạch',
            'city_id' => 44
        ]);
        District::create([
            'id' => 455,
            'name' => 'Huyện Bố Trạch',
            'city_id' => 44
        ]);
        District::create([
            'id' => 456,
            'name' => 'Huyện Quảng Ninh',
            'city_id' => 44
        ]);
        District::create([
            'id' => 457,
            'name' => 'Huyện Lệ Thủy',
            'city_id' => 44
        ]);
        District::create([
            'id' => 461,
            'name' => 'Thành Phố Đông Hà',
            'city_id' => 45
        ]);
        District::create([
            'id' => 462,
            'name' => 'Thị Xã Quảng Trị',
            'city_id' => 45
        ]);
        District::create([
            'id' => 464,
            'name' => 'Huyện Vĩnh Linh',
            'city_id' => 45
        ]);
        District::create([
            'id' => 465,
            'name' => 'Huyện Hướng Hóa',
            'city_id' => 45
        ]);
        District::create([
            'id' => 466,
            'name' => 'Huyện Gio Linh',
            'city_id' => 45
        ]);
        District::create([
            'id' => 467,
            'name' => 'Huyện Đa Krông',
            'city_id' => 45
        ]);
        District::create([
            'id' => 468,
            'name' => 'Huyện Cam Lộ',
            'city_id' => 45
        ]);
        District::create([
            'id' => 469,
            'name' => 'Huyện Triệu Phong',
            'city_id' => 45
        ]);
        District::create([
            'id' => 470,
            'name' => 'Huyện Hải Lăng',
            'city_id' => 45
        ]);
        District::create([
            'id' => 471,
            'name' => 'Huyện Cồn Cỏ',
            'city_id' => 45
        ]);
        District::create([
            'id' => 474,
            'name' => 'Thành Phố Huế',
            'city_id' => 46
        ]);
        District::create([
            'id' => 476,
            'name' => 'Huyện Phong Điền',
            'city_id' => 46
        ]);
        District::create([
            'id' => 477,
            'name' => 'Huyện Quảng Điền',
            'city_id' => 46
        ]);
        District::create([
            'id' => 478,
            'name' => 'Huyện Phú Vang',
            'city_id' => 46
        ]);
        District::create([
            'id' => 479,
            'name' => 'Huyện Hương Thủy',
            'city_id' => 46
        ]);
        District::create([
            'id' => 480,
            'name' => 'Huyện Hương Trà',
            'city_id' => 46
        ]);
        District::create([
            'id' => 481,
            'name' => 'Huyện A Lưới',
            'city_id' => 46
        ]);
        District::create([
            'id' => 482,
            'name' => 'Huyện Phú Lộc',
            'city_id' => 46
        ]);
        District::create([
            'id' => 483,
            'name' => 'Huyện Nam Đông',
            'city_id' => 46
        ]);
        District::create([
            'id' => 490,
            'name' => 'Quận Liên Chiểu',
            'city_id' => 48
        ]);
        District::create([
            'id' => 491,
            'name' => 'Quận Thanh Khê',
            'city_id' => 48
        ]);
        District::create([
            'id' => 492,
            'name' => 'Quận Hải Châu',
            'city_id' => 48
        ]);
        District::create([
            'id' => 493,
            'name' => 'Quận Sơn Trà',
            'city_id' => 48
        ]);
        District::create([
            'id' => 494,
            'name' => 'Quận Ngũ Hành Sơn',
            'city_id' => 48
        ]);
        District::create([
            'id' => 495,
            'name' => 'Quận Cẩm Lệ',
            'city_id' => 48
        ]);
        District::create([
            'id' => 497,
            'name' => 'Huyện Hoà Vang',
            'city_id' => 48
        ]);
        District::create([
            'id' => 498,
            'name' => 'Huyện Hoàng Sa',
            'city_id' => 48
        ]);
        District::create([
            'id' => 502,
            'name' => 'Thành Phố Tam Kỳ',
            'city_id' => 49
        ]);
        District::create([
            'id' => 503,
            'name' => 'Thành Phố Hội An',
            'city_id' => 49
        ]);
        District::create([
            'id' => 504,
            'name' => 'Huyện Tây Giang',
            'city_id' => 49
        ]);
        District::create([
            'id' => 505,
            'name' => 'Huyện Đông Giang',
            'city_id' => 49
        ]);
        District::create([
            'id' => 506,
            'name' => 'Huyện Đại Lộc',
            'city_id' => 49
        ]);
        District::create([
            'id' => 507,
            'name' => 'Huyện Điện Bàn',
            'city_id' => 49
        ]);
        District::create([
            'id' => 508,
            'name' => 'Huyện Duy Xuyên',
            'city_id' => 49
        ]);
        District::create([
            'id' => 509,
            'name' => 'Huyện Quế Sơn',
            'city_id' => 49
        ]);
        District::create([
            'id' => 510,
            'name' => 'Huyện Nam Giang',
            'city_id' => 49
        ]);
        District::create([
            'id' => 511,
            'name' => 'Huyện Phước Sơn',
            'city_id' => 49
        ]);
        District::create([
            'id' => 512,
            'name' => 'Huyện Hiệp Đức',
            'city_id' => 49
        ]);
        District::create([
            'id' => 513,
            'name' => 'Huyện Thăng Bình',
            'city_id' => 49
        ]);
        District::create([
            'id' => 514,
            'name' => 'Huyện Tiên Phước',
            'city_id' => 49
        ]);
        District::create([
            'id' => 515,
            'name' => 'Huyện Bắc Trà My',
            'city_id' => 49
        ]);
        District::create([
            'id' => 516,
            'name' => 'Huyện Nam Trà My',
            'city_id' => 49
        ]);
        District::create([
            'id' => 517,
            'name' => 'Huyện Núi Thành',
            'city_id' => 49
        ]);
        District::create([
            'id' => 518,
            'name' => 'Huyện Phú Ninh',
            'city_id' => 49
        ]);
        District::create([
            'id' => 519,
            'name' => 'Huyện Nông Sơn',
            'city_id' => 49
        ]);
        District::create([
            'id' => 522,
            'name' => 'Thành Phố Quảng Ngãi',
            'city_id' => 51
        ]);
        District::create([
            'id' => 524,
            'name' => 'Huyện Bình Sơn',
            'city_id' => 51
        ]);
        District::create([
            'id' => 525,
            'name' => 'Huyện Trà Bồng',
            'city_id' => 51
        ]);
        District::create([
            'id' => 526,
            'name' => 'Huyện Tây Trà',
            'city_id' => 51
        ]);
        District::create([
            'id' => 527,
            'name' => 'Huyện Sơn Tịnh',
            'city_id' => 51
        ]);
        District::create([
            'id' => 528,
            'name' => 'Huyện Tư Nghĩa',
            'city_id' => 51
        ]);
        District::create([
            'id' => 529,
            'name' => 'Huyện Sơn Hà',
            'city_id' => 51
        ]);
        District::create([
            'id' => 530,
            'name' => 'Huyện Sơn Tây',
            'city_id' => 51
        ]);
        District::create([
            'id' => 531,
            'name' => 'Huyện Minh Long',
            'city_id' => 51
        ]);
        District::create([
            'id' => 532,
            'name' => 'Huyện Nghĩa Hành',
            'city_id' => 51
        ]);
        District::create([
            'id' => 533,
            'name' => 'Huyện Mộ Đức',
            'city_id' => 51
        ]);
        District::create([
            'id' => 534,
            'name' => 'Huyện Đức Phổ',
            'city_id' => 51
        ]);
        District::create([
            'id' => 535,
            'name' => 'Huyện Ba Tơ',
            'city_id' => 51
        ]);
        District::create([
            'id' => 536,
            'name' => 'Huyện Lý Sơn',
            'city_id' => 51
        ]);
        District::create([
            'id' => 540,
            'name' => 'Thành Phố Qui Nhơn',
            'city_id' => 52
        ]);
        District::create([
            'id' => 542,
            'name' => 'Huyện An Lão',
            'city_id' => 52
        ]);
        District::create([
            'id' => 543,
            'name' => 'Huyện Hoài Nhơn',
            'city_id' => 52
        ]);
        District::create([
            'id' => 544,
            'name' => 'Huyện Hoài Ân',
            'city_id' => 52
        ]);
        District::create([
            'id' => 545,
            'name' => 'Huyện Phù Mỹ',
            'city_id' => 52
        ]);
        District::create([
            'id' => 546,
            'name' => 'Huyện Vĩnh Thạnh',
            'city_id' => 52
        ]);
        District::create([
            'id' => 547,
            'name' => 'Huyện Tây Sơn',
            'city_id' => 52
        ]);
        District::create([
            'id' => 548,
            'name' => 'Huyện Phù Cát',
            'city_id' => 52
        ]);
        District::create([
            'id' => 549,
            'name' => 'Huyện An Nhơn',
            'city_id' => 52
        ]);
        District::create([
            'id' => 550,
            'name' => 'Huyện Tuy Phước',
            'city_id' => 52
        ]);
        District::create([
            'id' => 551,
            'name' => 'Huyện Vân Canh',
            'city_id' => 52
        ]);
        District::create([
            'id' => 555,
            'name' => 'Thành Phố Tuy Hòa',
            'city_id' => 54
        ]);
        District::create([
            'id' => 557,
            'name' => 'Thị Xã Sông Cầu',
            'city_id' => 54
        ]);
        District::create([
            'id' => 558,
            'name' => 'Huyện Đồng Xuân',
            'city_id' => 54
        ]);
        District::create([
            'id' => 559,
            'name' => 'Huyện Tuy An',
            'city_id' => 54
        ]);
        District::create([
            'id' => 560,
            'name' => 'Huyện Sơn Hòa',
            'city_id' => 54
        ]);
        District::create([
            'id' => 561,
            'name' => 'Huyện Sông Hinh',
            'city_id' => 54
        ]);
        District::create([
            'id' => 562,
            'name' => 'Huyện Tây Hoà',
            'city_id' => 54
        ]);
        District::create([
            'id' => 563,
            'name' => 'Huyện Phú Hoà',
            'city_id' => 54
        ]);
        District::create([
            'id' => 564,
            'name' => 'Huyện Đông Hoà',
            'city_id' => 54
        ]);
        District::create([
            'id' => 568,
            'name' => 'Thành Phố Nha Trang',
            'city_id' => 56
        ]);
        District::create([
            'id' => 569,
            'name' => 'Thị Xã Cam Ranh',
            'city_id' => 56
        ]);
        District::create([
            'id' => 570,
            'name' => 'Huyện Cam Lâm',
            'city_id' => 56
        ]);
        District::create([
            'id' => 571,
            'name' => 'Huyện Vạn Ninh',
            'city_id' => 56
        ]);
        District::create([
            'id' => 572,
            'name' => 'Huyện Ninh Hòa',
            'city_id' => 56
        ]);
        District::create([
            'id' => 573,
            'name' => 'Huyện Khánh Vĩnh',
            'city_id' => 56
        ]);
        District::create([
            'id' => 574,
            'name' => 'Huyện Diên Khánh',
            'city_id' => 56
        ]);
        District::create([
            'id' => 575,
            'name' => 'Huyện Khánh Sơn',
            'city_id' => 56
        ]);
        District::create([
            'id' => 576,
            'name' => 'Huyện Trường Sa',
            'city_id' => 56
        ]);
        District::create([
            'id' => 582,
            'name' => 'Thành Phố Phan Rang-Tháp Chàm',
            'city_id' => 58
        ]);
        District::create([
            'id' => 584,
            'name' => 'Huyện Bác Ái',
            'city_id' => 58
        ]);
        District::create([
            'id' => 585,
            'name' => 'Huyện Ninh Sơn',
            'city_id' => 58
        ]);
        District::create([
            'id' => 586,
            'name' => 'Huyện Ninh Hải',
            'city_id' => 58
        ]);
        District::create([
            'id' => 587,
            'name' => 'Huyện Ninh Phước',
            'city_id' => 58
        ]);
        District::create([
            'id' => 588,
            'name' => 'Huyện Thuận Bắc',
            'city_id' => 58
        ]);
        District::create([
            'id' => 589,
            'name' => 'Huyện Thuận Nam',
            'city_id' => 58
        ]);
        District::create([
            'id' => 593,
            'name' => 'Thành Phố Phan Thiết',
            'city_id' => 60
        ]);
        District::create([
            'id' => 594,
            'name' => 'Thị Xã La Gi',
            'city_id' => 60
        ]);
        District::create([
            'id' => 595,
            'name' => 'Huyện Tuy Phong',
            'city_id' => 60
        ]);
        District::create([
            'id' => 596,
            'name' => 'Huyện Bắc Bình',
            'city_id' => 60
        ]);
        District::create([
            'id' => 597,
            'name' => 'Huyện Hàm Thuận Bắc',
            'city_id' => 60
        ]);
        District::create([
            'id' => 598,
            'name' => 'Huyện Hàm Thuận Nam',
            'city_id' => 60
        ]);
        District::create([
            'id' => 599,
            'name' => 'Huyện Tánh Linh',
            'city_id' => 60
        ]);
        District::create([
            'id' => 600,
            'name' => 'Huyện Đức Linh',
            'city_id' => 60
        ]);
        District::create([
            'id' => 601,
            'name' => 'Huyện Hàm Tân',
            'city_id' => 60
        ]);
        District::create([
            'id' => 602,
            'name' => 'Huyện Phú Quí',
            'city_id' => 60
        ]);
        District::create([
            'id' => 608,
            'name' => 'Thành Phố Kon Tum',
            'city_id' => 62
        ]);
        District::create([
            'id' => 610,
            'name' => 'Huyện Đắk Glei',
            'city_id' => 62
        ]);
        District::create([
            'id' => 611,
            'name' => 'Huyện Ngọc Hồi',
            'city_id' => 62
        ]);
        District::create([
            'id' => 612,
            'name' => 'Huyện Đắk Tô',
            'city_id' => 62
        ]);
        District::create([
            'id' => 613,
            'name' => 'Huyện Kon Plông',
            'city_id' => 62
        ]);
        District::create([
            'id' => 614,
            'name' => 'Huyện Kon Rẫy',
            'city_id' => 62
        ]);
        District::create([
            'id' => 615,
            'name' => 'Huyện Đắk Hà',
            'city_id' => 62
        ]);
        District::create([
            'id' => 616,
            'name' => 'Huyện Sa Thầy',
            'city_id' => 62
        ]);
        District::create([
            'id' => 617,
            'name' => 'Huyện Tu Mơ Rông',
            'city_id' => 62
        ]);
        District::create([
            'id' => 622,
            'name' => 'Thành Phố Pleiku',
            'city_id' => 64
        ]);
        District::create([
            'id' => 623,
            'name' => 'Thị Xã An Khê',
            'city_id' => 64
        ]);
        District::create([
            'id' => 624,
            'name' => 'Thị Xã Ayun Pa',
            'city_id' => 64
        ]);
        District::create([
            'id' => 625,
            'name' => 'Huyện Kbang',
            'city_id' => 64
        ]);
        District::create([
            'id' => 626,
            'name' => 'Huyện Đăk Đoa',
            'city_id' => 64
        ]);
        District::create([
            'id' => 627,
            'name' => 'Huyện Chư Păh',
            'city_id' => 64
        ]);
        District::create([
            'id' => 628,
            'name' => 'Huyện Ia Grai',
            'city_id' => 64
        ]);
        District::create([
            'id' => 629,
            'name' => 'Huyện Mang Yang',
            'city_id' => 64
        ]);
        District::create([
            'id' => 630,
            'name' => 'Huyện Kông Chro',
            'city_id' => 64
        ]);
        District::create([
            'id' => 631,
            'name' => 'Huyện Đức Cơ',
            'city_id' => 64
        ]);
        District::create([
            'id' => 632,
            'name' => 'Huyện Chư Prông',
            'city_id' => 64
        ]);
        District::create([
            'id' => 633,
            'name' => 'Huyện Chư Sê',
            'city_id' => 64
        ]);
        District::create([
            'id' => 634,
            'name' => 'Huyện Đăk Pơ',
            'city_id' => 64
        ]);
        District::create([
            'id' => 635,
            'name' => 'Huyện Ia Pa',
            'city_id' => 64
        ]);
        District::create([
            'id' => 637,
            'name' => 'Huyện Krông Pa',
            'city_id' => 64
        ]);
        District::create([
            'id' => 638,
            'name' => 'Huyện Phú Thiện',
            'city_id' => 64
        ]);
        District::create([
            'id' => 639,
            'name' => 'Huyện Chư Pưh',
            'city_id' => 64
        ]);
        District::create([
            'id' => 643,
            'name' => 'Thành Phố Buôn Ma Thuột',
            'city_id' => 66
        ]);
        District::create([
            'id' => 644,
            'name' => 'Thị Xã Buôn Hồ',
            'city_id' => 66
        ]);
        District::create([
            'id' => 645,
            'name' => 'Huyện Ea Hleo',
            'city_id' => 66
        ]);
        District::create([
            'id' => 646,
            'name' => 'Huyện Ea Súp',
            'city_id' => 66
        ]);
        District::create([
            'id' => 647,
            'name' => 'Huyện Buôn Đôn',
            'city_id' => 66
        ]);
        District::create([
            'id' => 648,
            'name' => 'Huyện Cư Mgar',
            'city_id' => 66
        ]);
        District::create([
            'id' => 649,
            'name' => 'Huyện Krông Búk',
            'city_id' => 66
        ]);
        District::create([
            'id' => 650,
            'name' => 'Huyện Krông Năng',
            'city_id' => 66
        ]);
        District::create([
            'id' => 651,
            'name' => 'Huyện Ea Kar',
            'city_id' => 66
        ]);
        District::create([
            'id' => 652,
            'name' => 'Huyện Mđrắk',
            'city_id' => 66
        ]);
        District::create([
            'id' => 653,
            'name' => 'Huyện Krông Bông',
            'city_id' => 66
        ]);
        District::create([
            'id' => 654,
            'name' => 'Huyện Krông Pắc',
            'city_id' => 66
        ]);
        District::create([
            'id' => 655,
            'name' => 'Huyện Krông A Na',
            'city_id' => 66
        ]);
        District::create([
            'id' => 656,
            'name' => 'Huyện Lắk',
            'city_id' => 66
        ]);
        District::create([
            'id' => 657,
            'name' => 'Huyện Cư Kuin',
            'city_id' => 66
        ]);
        District::create([
            'id' => 660,
            'name' => 'Thị Xã Gia Nghĩa',
            'city_id' => 67
        ]);
        District::create([
            'id' => 661,
            'name' => 'Huyện Đắk Glong',
            'city_id' => 67
        ]);
        District::create([
            'id' => 662,
            'name' => 'Huyện Cư Jút',
            'city_id' => 67
        ]);
        District::create([
            'id' => 663,
            'name' => 'Huyện Đắk Mil',
            'city_id' => 67
        ]);
        District::create([
            'id' => 664,
            'name' => 'Huyện Krông Nô',
            'city_id' => 67
        ]);
        District::create([
            'id' => 665,
            'name' => 'Huyện Đắk Song',
            'city_id' => 67
        ]);
        District::create([
            'id' => 666,
            'name' => 'Huyện Đắk Rlấp',
            'city_id' => 67
        ]);
        District::create([
            'id' => 667,
            'name' => 'Huyện Tuy Đức',
            'city_id' => 67
        ]);
        District::create([
            'id' => 672,
            'name' => 'Thành Phố Đà Lạt',
            'city_id' => 68
        ]);
        District::create([
            'id' => 673,
            'name' => 'Thị Xã Bảo Lộc',
            'city_id' => 68
        ]);
        District::create([
            'id' => 674,
            'name' => 'Huyện Đam Rông',
            'city_id' => 68
        ]);
        District::create([
            'id' => 675,
            'name' => 'Huyện Lạc Dương',
            'city_id' => 68
        ]);
        District::create([
            'id' => 676,
            'name' => 'Huyện Lâm Hà',
            'city_id' => 68
        ]);
        District::create([
            'id' => 677,
            'name' => 'Huyện Đơn Dương',
            'city_id' => 68
        ]);
        District::create([
            'id' => 678,
            'name' => 'Huyện Đức Trọng',
            'city_id' => 68
        ]);
        District::create([
            'id' => 679,
            'name' => 'Huyện Di Linh',
            'city_id' => 68
        ]);
        District::create([
            'id' => 680,
            'name' => 'Huyện Bảo Lâm',
            'city_id' => 68
        ]);
        District::create([
            'id' => 681,
            'name' => 'Huyện Đạ Huoai',
            'city_id' => 68
        ]);
        District::create([
            'id' => 682,
            'name' => 'Huyện Đạ Tẻh',
            'city_id' => 68
        ]);
        District::create([
            'id' => 683,
            'name' => 'Huyện Cát Tiên',
            'city_id' => 68
        ]);
        District::create([
            'id' => 688,
            'name' => 'Thị Xã Phước Long',
            'city_id' => 70
        ]);
        District::create([
            'id' => 689,
            'name' => 'Thị Xã Đồng Xoài',
            'city_id' => 70
        ]);
        District::create([
            'id' => 690,
            'name' => 'Thị Xã Bình Long',
            'city_id' => 70
        ]);
        District::create([
            'id' => 691,
            'name' => 'Huyện Bù Gia Mập',
            'city_id' => 70
        ]);
        District::create([
            'id' => 692,
            'name' => 'Huyện Lộc Ninh',
            'city_id' => 70
        ]);
        District::create([
            'id' => 693,
            'name' => 'Huyện Bù Đốp',
            'city_id' => 70
        ]);
        District::create([
            'id' => 694,
            'name' => 'Huyện Hớn Quản',
            'city_id' => 70
        ]);
        District::create([
            'id' => 695,
            'name' => 'Huyện Đồng Phù',
            'city_id' => 70
        ]);
        District::create([
            'id' => 696,
            'name' => 'Huyện Bù Đăng',
            'city_id' => 70
        ]);
        District::create([
            'id' => 697,
            'name' => 'Huyện Chơn Thành',
            'city_id' => 70
        ]);
        District::create([
            'id' => 703,
            'name' => 'Thị Xã Tây Ninh',
            'city_id' => 72
        ]);
        District::create([
            'id' => 705,
            'name' => 'Huyện Tân Biên',
            'city_id' => 72
        ]);
        District::create([
            'id' => 706,
            'name' => 'Huyện Tân Châu',
            'city_id' => 72
        ]);
        District::create([
            'id' => 707,
            'name' => 'Huyện Dương Minh Châu',
            'city_id' => 72
        ]);
        District::create([
            'id' => 708,
            'name' => 'Huyện Châu Thành',
            'city_id' => 72
        ]);
        District::create([
            'id' => 709,
            'name' => 'Huyện Hòa Thành',
            'city_id' => 72
        ]);
        District::create([
            'id' => 710,
            'name' => 'Huyện Gò Dầu',
            'city_id' => 72
        ]);
        District::create([
            'id' => 711,
            'name' => 'Huyện Bến Cầu',
            'city_id' => 72
        ]);
        District::create([
            'id' => 712,
            'name' => 'Huyện Trảng Bàng',
            'city_id' => 72
        ]);
        District::create([
            'id' => 718,
            'name' => 'Thị Xã Thủ Dầu Một',
            'city_id' => 74
        ]);
        District::create([
            'id' => 720,
            'name' => 'Huyện Dầu Tiếng',
            'city_id' => 74
        ]);
        District::create([
            'id' => 721,
            'name' => 'Huyện Bến Cát',
            'city_id' => 74
        ]);
        District::create([
            'id' => 722,
            'name' => 'Huyện Phú Giáo',
            'city_id' => 74
        ]);
        District::create([
            'id' => 723,
            'name' => 'Huyện Tân Uyên',
            'city_id' => 74
        ]);
        District::create([
            'id' => 724,
            'name' => 'Huyện Dĩ An',
            'city_id' => 74
        ]);
        District::create([
            'id' => 725,
            'name' => 'Huyện Thuận An',
            'city_id' => 74
        ]);
        District::create([
            'id' => 731,
            'name' => 'Thành Phố Biên Hòa',
            'city_id' => 75
        ]);
        District::create([
            'id' => 732,
            'name' => 'Thị Xã Long Khánh',
            'city_id' => 75
        ]);
        District::create([
            'id' => 734,
            'name' => 'Huyện Tân Phú',
            'city_id' => 75
        ]);
        District::create([
            'id' => 735,
            'name' => 'Huyện Vĩnh Cửu',
            'city_id' => 75
        ]);
        District::create([
            'id' => 736,
            'name' => 'Huyện Định Quán',
            'city_id' => 75
        ]);
        District::create([
            'id' => 737,
            'name' => 'Huyện Trảng Bom',
            'city_id' => 75
        ]);
        District::create([
            'id' => 738,
            'name' => 'Huyện Thống Nhất',
            'city_id' => 75
        ]);
        District::create([
            'id' => 739,
            'name' => 'Huyện Cẩm Mỹ',
            'city_id' => 75
        ]);
        District::create([
            'id' => 740,
            'name' => 'Huyện Long Thành',
            'city_id' => 75
        ]);
        District::create([
            'id' => 741,
            'name' => 'Huyện Xuân Lộc',
            'city_id' => 75
        ]);
        District::create([
            'id' => 742,
            'name' => 'Huyện Nhơn Trạch',
            'city_id' => 75
        ]);
        District::create([
            'id' => 747,
            'name' => 'Thành Phố Vũng Tầu',
            'city_id' => 77
        ]);
        District::create([
            'id' => 748,
            'name' => 'Thị Xã Bà Rịa',
            'city_id' => 77
        ]);
        District::create([
            'id' => 750,
            'name' => 'Huyện Châu Đức',
            'city_id' => 77
        ]);
        District::create([
            'id' => 751,
            'name' => 'Huyện Xuyên Mộc',
            'city_id' => 77
        ]);
        District::create([
            'id' => 752,
            'name' => 'Huyện Long Điền',
            'city_id' => 77
        ]);
        District::create([
            'id' => 753,
            'name' => 'Huyện Đất Đỏ',
            'city_id' => 77
        ]);
        District::create([
            'id' => 754,
            'name' => 'Huyện Tân Thành',
            'city_id' => 77
        ]);
        District::create([
            'id' => 755,
            'name' => 'Huyện Côn Đảo',
            'city_id' => 77
        ]);
        District::create([
            'id' => 760,
            'name' => 'Quận 1',
            'city_id' => 79
        ]);
        District::create([
            'id' => 761,
            'name' => 'Quận 12',
            'city_id' => 79
        ]);
        District::create([
            'id' => 762,
            'name' => 'Quận Thủ Đức',
            'city_id' => 79
        ]);
        District::create([
            'id' => 763,
            'name' => 'Quận 9',
            'city_id' => 79
        ]);
        District::create([
            'id' => 764,
            'name' => 'Quận Gò Vấp',
            'city_id' => 79
        ]);
        District::create([
            'id' => 765,
            'name' => 'Quận Bình Thạnh',
            'city_id' => 79
        ]);
        District::create([
            'id' => 766,
            'name' => 'Quận Tân Bình',
            'city_id' => 79
        ]);
        District::create([
            'id' => 767,
            'name' => 'Quận Tân Phú',
            'city_id' => 79
        ]);
        District::create([
            'id' => 768,
            'name' => 'Quận Phú Nhuận',
            'city_id' => 79
        ]);
        District::create([
            'id' => 769,
            'name' => 'Quận 2',
            'city_id' => 79
        ]);
        District::create([
            'id' => 770,
            'name' => 'Quận 3',
            'city_id' => 79
        ]);
        District::create([
            'id' => 771,
            'name' => 'Quận 10',
            'city_id' => 79
        ]);
        District::create([
            'id' => 772,
            'name' => 'Quận 11',
            'city_id' => 79
        ]);
        District::create([
            'id' => 773,
            'name' => 'Quận 4',
            'city_id' => 79
        ]);
        District::create([
            'id' => 774,
            'name' => 'Quận 5',
            'city_id' => 79
        ]);
        District::create([
            'id' => 775,
            'name' => 'Quận 6',
            'city_id' => 79
        ]);
        District::create([
            'id' => 776,
            'name' => 'Quận 8',
            'city_id' => 79
        ]);
        District::create([
            'id' => 777,
            'name' => 'Quận Bình Tân',
            'city_id' => 79
        ]);
        District::create([
            'id' => 778,
            'name' => 'Quận 7',
            'city_id' => 79
        ]);
        District::create([
            'id' => 783,
            'name' => 'Huyện Củ Chi',
            'city_id' => 79
        ]);
        District::create([
            'id' => 784,
            'name' => 'Huyện Hóc Môn',
            'city_id' => 79
        ]);
        District::create([
            'id' => 785,
            'name' => 'Huyện Bình Chánh',
            'city_id' => 79
        ]);
        District::create([
            'id' => 786,
            'name' => 'Huyện Nhà Bè',
            'city_id' => 79
        ]);
        District::create([
            'id' => 787,
            'name' => 'Huyện Cần Giờ',
            'city_id' => 79
        ]);
        District::create([
            'id' => 794,
            'name' => 'Thành Phố Tân An',
            'city_id' => 80
        ]);
        District::create([
            'id' => 796,
            'name' => 'Huyện Tân Hưng',
            'city_id' => 80
        ]);
        District::create([
            'id' => 797,
            'name' => 'Huyện Vĩnh Hưng',
            'city_id' => 80
        ]);
        District::create([
            'id' => 798,
            'name' => 'Huyện Mộc Hóa',
            'city_id' => 80
        ]);
        District::create([
            'id' => 799,
            'name' => 'Huyện Tân Thạnh',
            'city_id' => 80
        ]);
        District::create([
            'id' => 800,
            'name' => 'Huyện Thạnh Hóa',
            'city_id' => 80
        ]);
        District::create([
            'id' => 801,
            'name' => 'Huyện Đức Huệ',
            'city_id' => 80
        ]);
        District::create([
            'id' => 802,
            'name' => 'Huyện Đức Hòa',
            'city_id' => 80
        ]);
        District::create([
            'id' => 803,
            'name' => 'Huyện Bến Lức',
            'city_id' => 80
        ]);
        District::create([
            'id' => 804,
            'name' => 'Huyện Thủ Thừa',
            'city_id' => 80
        ]);
        District::create([
            'id' => 805,
            'name' => 'Huyện Tân Trụ',
            'city_id' => 80
        ]);
        District::create([
            'id' => 806,
            'name' => 'Huyện Cần Đước',
            'city_id' => 80
        ]);
        District::create([
            'id' => 807,
            'name' => 'Huyện Cần Giuộc',
            'city_id' => 80
        ]);
        District::create([
            'id' => 808,
            'name' => 'Huyện Châu Thành',
            'city_id' => 80
        ]);
        District::create([
            'id' => 815,
            'name' => 'Thành Phố Mỹ Tho',
            'city_id' => 82
        ]);
        District::create([
            'id' => 816,
            'name' => 'Thị Xã Gò Công',
            'city_id' => 82
        ]);
        District::create([
            'id' => 818,
            'name' => 'Huyện Tân Phước',
            'city_id' => 82
        ]);
        District::create([
            'id' => 819,
            'name' => 'Huyện Cái Bè',
            'city_id' => 82
        ]);
        District::create([
            'id' => 820,
            'name' => 'Huyện Cai Lậy',
            'city_id' => 82
        ]);
        District::create([
            'id' => 821,
            'name' => 'Huyện Châu Thành',
            'city_id' => 82
        ]);
        District::create([
            'id' => 822,
            'name' => 'Huyện Chợ Gạo',
            'city_id' => 82
        ]);
        District::create([
            'id' => 823,
            'name' => 'Huyện Gò Công Tây',
            'city_id' => 82
        ]);
        District::create([
            'id' => 824,
            'name' => 'Huyện Gò Công Đông',
            'city_id' => 82
        ]);
        District::create([
            'id' => 825,
            'name' => 'Huyện Tân Phú Đông',
            'city_id' => 82
        ]);
        District::create([
            'id' => 829,
            'name' => 'Thành Phố Bến Tre',
            'city_id' => 83
        ]);
        District::create([
            'id' => 831,
            'name' => 'Huyện Châu Thành',
            'city_id' => 83
        ]);
        District::create([
            'id' => 832,
            'name' => 'Huyện Chợ Lách',
            'city_id' => 83
        ]);
        District::create([
            'id' => 833,
            'name' => 'Huyện Mỏ Cày Nam',
            'city_id' => 83
        ]);
        District::create([
            'id' => 834,
            'name' => 'Huyện Giồng Trôm',
            'city_id' => 83
        ]);
        District::create([
            'id' => 835,
            'name' => 'Huyện Bình Đại',
            'city_id' => 83
        ]);
        District::create([
            'id' => 836,
            'name' => 'Huyện Ba Tri',
            'city_id' => 83
        ]);
        District::create([
            'id' => 837,
            'name' => 'Huyện Thạnh Phú',
            'city_id' => 83
        ]);
        District::create([
            'id' => 838,
            'name' => 'Huyện Mỏ Cày Bắc',
            'city_id' => 83
        ]);
        District::create([
            'id' => 842,
            'name' => 'Thị Xã Trà Vinh',
            'city_id' => 84
        ]);
        District::create([
            'id' => 844,
            'name' => 'Huyện Càng Long',
            'city_id' => 84
        ]);
        District::create([
            'id' => 845,
            'name' => 'Huyện Cầu Kè',
            'city_id' => 84
        ]);
        District::create([
            'id' => 846,
            'name' => 'Huyện Tiểu Cần',
            'city_id' => 84
        ]);
        District::create([
            'id' => 847,
            'name' => 'Huyện Châu Thành',
            'city_id' => 84
        ]);
        District::create([
            'id' => 848,
            'name' => 'Huyện Cầu Ngang',
            'city_id' => 84
        ]);
        District::create([
            'id' => 849,
            'name' => 'Huyện Trà Cú',
            'city_id' => 84
        ]);
        District::create([
            'id' => 850,
            'name' => 'Huyện Duyên Hải',
            'city_id' => 84
        ]);
        District::create([
            'id' => 855,
            'name' => 'Thành Phố Vĩnh Long',
            'city_id' => 86
        ]);
        District::create([
            'id' => 857,
            'name' => 'Huyện Long Hồ',
            'city_id' => 86
        ]);
        District::create([
            'id' => 858,
            'name' => 'Huyện Mang Thít',
            'city_id' => 86
        ]);
        District::create([
            'id' => 859,
            'name' => 'Huyện Vũng Liêm',
            'city_id' => 86
        ]);
        District::create([
            'id' => 860,
            'name' => 'Huyện Tam Bình',
            'city_id' => 86
        ]);
        District::create([
            'id' => 861,
            'name' => 'Huyện Bình Minh',
            'city_id' => 86
        ]);
        District::create([
            'id' => 862,
            'name' => 'Huyện Trà Ôn',
            'city_id' => 86
        ]);
        District::create([
            'id' => 863,
            'name' => 'Huyện Bình Tân',
            'city_id' => 86
        ]);
        District::create([
            'id' => 866,
            'name' => 'Thành Phố Cao Lãnh',
            'city_id' => 87
        ]);
        District::create([
            'id' => 867,
            'name' => 'Thị Xã Sa Đéc',
            'city_id' => 87
        ]);
        District::create([
            'id' => 868,
            'name' => 'Thị Xã Hồng Ngự',
            'city_id' => 87
        ]);
        District::create([
            'id' => 869,
            'name' => 'Huyện Tân Hồng',
            'city_id' => 87
        ]);
        District::create([
            'id' => 870,
            'name' => 'Huyện Hồng Ngự',
            'city_id' => 87
        ]);
        District::create([
            'id' => 871,
            'name' => 'Huyện Tam Nông',
            'city_id' => 87
        ]);
        District::create([
            'id' => 872,
            'name' => 'Huyện Tháp Mười',
            'city_id' => 87
        ]);
        District::create([
            'id' => 873,
            'name' => 'Huyện Cao Lãnh',
            'city_id' => 87
        ]);
        District::create([
            'id' => 874,
            'name' => 'Huyện Thanh Bình',
            'city_id' => 87
        ]);
        District::create([
            'id' => 875,
            'name' => 'Huyện Lấp Vò',
            'city_id' => 87
        ]);
        District::create([
            'id' => 876,
            'name' => 'Huyện Lai Vung',
            'city_id' => 87
        ]);
        District::create([
            'id' => 877,
            'name' => 'Huyện Châu Thành',
            'city_id' => 87
        ]);
        District::create([
            'id' => 883,
            'name' => 'Thành Phố Long Xuyên',
            'city_id' => 89
        ]);
        District::create([
            'id' => 884,
            'name' => 'Thị Xã Châu Đốc',
            'city_id' => 89
        ]);
        District::create([
            'id' => 886,
            'name' => 'Huyện An Phú',
            'city_id' => 89
        ]);
        District::create([
            'id' => 887,
            'name' => 'Thị Xã Tân Châu',
            'city_id' => 89
        ]);
        District::create([
            'id' => 888,
            'name' => 'Huyện Phú Tân',
            'city_id' => 89
        ]);
        District::create([
            'id' => 889,
            'name' => 'Huyện Châu Phú',
            'city_id' => 89
        ]);
        District::create([
            'id' => 890,
            'name' => 'Huyện Tịnh Biên',
            'city_id' => 89
        ]);
        District::create([
            'id' => 891,
            'name' => 'Huyện Tri Tôn',
            'city_id' => 89
        ]);
        District::create([
            'id' => 892,
            'name' => 'Huyện Châu Thành',
            'city_id' => 89
        ]);
        District::create([
            'id' => 893,
            'name' => 'Huyện Chợ Mới',
            'city_id' => 89
        ]);
        District::create([
            'id' => 894,
            'name' => 'Huyện Thoại Sơn',
            'city_id' => 89
        ]);
        District::create([
            'id' => 899,
            'name' => 'Thành Phố Rạch Giá',
            'city_id' => 91
        ]);
        District::create([
            'id' => 900,
            'name' => 'Thị Xã Hà Tiên',
            'city_id' => 91
        ]);
        District::create([
            'id' => 902,
            'name' => 'Huyện Kiên Lương',
            'city_id' => 91
        ]);
        District::create([
            'id' => 903,
            'name' => 'Huyện Hòn Đất',
            'city_id' => 91
        ]);
        District::create([
            'id' => 904,
            'name' => 'Huyện Tân Hiệp',
            'city_id' => 91
        ]);
        District::create([
            'id' => 905,
            'name' => 'Huyện Châu Thành',
            'city_id' => 91
        ]);
        District::create([
            'id' => 906,
            'name' => 'Huyện Giồng Giềng',
            'city_id' => 91
        ]);
        District::create([
            'id' => 907,
            'name' => 'Huyện Gò Quao',
            'city_id' => 91
        ]);
        District::create([
            'id' => 908,
            'name' => 'Huyện An Biên',
            'city_id' => 91
        ]);
        District::create([
            'id' => 909,
            'name' => 'Huyện An Minh',
            'city_id' => 91
        ]);
        District::create([
            'id' => 910,
            'name' => 'Huyện Vĩnh Thuận',
            'city_id' => 91
        ]);
        District::create([
            'id' => 911,
            'name' => 'Huyện Phú Quốc',
            'city_id' => 91
        ]);
        District::create([
            'id' => 912,
            'name' => 'Huyện Kiên Hải',
            'city_id' => 91
        ]);
        District::create([
            'id' => 913,
            'name' => 'Huyện U Minh Thượng',
            'city_id' => 91
        ]);
        District::create([
            'id' => 914,
            'name' => 'Huyện Giang Thành',
            'city_id' => 91
        ]);
        District::create([
            'id' => 916,
            'name' => 'Quận Ninh Kiều',
            'city_id' => 92
        ]);
        District::create([
            'id' => 917,
            'name' => 'Quận Ô Môn',
            'city_id' => 92
        ]);
        District::create([
            'id' => 918,
            'name' => 'Quận Bình Thuỷ',
            'city_id' => 92
        ]);
        District::create([
            'id' => 919,
            'name' => 'Quận Cái Răng',
            'city_id' => 92
        ]);
        District::create([
            'id' => 923,
            'name' => 'Quận Thốt Nốt',
            'city_id' => 92
        ]);
        District::create([
            'id' => 924,
            'name' => 'Huyện Vĩnh Thạnh',
            'city_id' => 92
        ]);
        District::create([
            'id' => 925,
            'name' => 'Huyện Cờ Đỏ',
            'city_id' => 92
        ]);
        District::create([
            'id' => 926,
            'name' => 'Huyện Phong Điền',
            'city_id' => 92
        ]);
        District::create([
            'id' => 927,
            'name' => 'Huyện Thới Lai',
            'city_id' => 92
        ]);
        District::create([
            'id' => 930,
            'name' => 'Thị Xã Vị Thanh',
            'city_id' => 93
        ]);
        District::create([
            'id' => 931,
            'name' => 'Thị Xã Ngã Bảy',
            'city_id' => 93
        ]);
        District::create([
            'id' => 932,
            'name' => 'Huyện Châu Thành A',
            'city_id' => 93
        ]);
        District::create([
            'id' => 933,
            'name' => 'Huyện Châu Thành',
            'city_id' => 93
        ]);
        District::create([
            'id' => 934,
            'name' => 'Huyện Phụng Hiệp',
            'city_id' => 93
        ]);
        District::create([
            'id' => 935,
            'name' => 'Huyện Vị Thuỷ',
            'city_id' => 93
        ]);
        District::create([
            'id' => 936,
            'name' => 'Huyện Long Mỹ',
            'city_id' => 93
        ]);
        District::create([
            'id' => 941,
            'name' => 'Thành Phố Sóc Trăng',
            'city_id' => 94
        ]);
        District::create([
            'id' => 942,
            'name' => 'Huyện Châu Thành',
            'city_id' => 94
        ]);
        District::create([
            'id' => 943,
            'name' => 'Huyện Kế Sách',
            'city_id' => 94
        ]);
        District::create([
            'id' => 944,
            'name' => 'Huyện Mỹ Tú',
            'city_id' => 94
        ]);
        District::create([
            'id' => 945,
            'name' => 'Huyện Cù Lao Dung',
            'city_id' => 94
        ]);
        District::create([
            'id' => 946,
            'name' => 'Huyện Long Phú',
            'city_id' => 94
        ]);
        District::create([
            'id' => 947,
            'name' => 'Huyện Mỹ Xuyên',
            'city_id' => 94
        ]);
        District::create([
            'id' => 948,
            'name' => 'Huyện Ngã Năm',
            'city_id' => 94
        ]);
        District::create([
            'id' => 949,
            'name' => 'Huyện Thạnh Trị',
            'city_id' => 94
        ]);
        District::create([
            'id' => 950,
            'name' => 'Huyện Vĩnh Châu',
            'city_id' => 94
        ]);
        District::create([
            'id' => 951,
            'name' => 'Huyện Trần Đề',
            'city_id' => 94
        ]);
        District::create([
            'id' => 954,
            'name' => 'Thị Xã Bạc Liêu',
            'city_id' => 95
        ]);
        District::create([
            'id' => 956,
            'name' => 'Huyện Hồng Dân',
            'city_id' => 95
        ]);
        District::create([
            'id' => 957,
            'name' => 'Huyện Phước Long',
            'city_id' => 95
        ]);
        District::create([
            'id' => 958,
            'name' => 'Huyện Vĩnh Lợi',
            'city_id' => 95
        ]);
        District::create([
            'id' => 959,
            'name' => 'Huyện Giá Rai',
            'city_id' => 95
        ]);
        District::create([
            'id' => 960,
            'name' => 'Huyện Đông Hải',
            'city_id' => 95
        ]);
        District::create([
            'id' => 961,
            'name' => 'Huyện Hoà Bình',
            'city_id' => 95
        ]);
        District::create([
            'id' => 964,
            'name' => 'Thành Phố Cà Mau',
            'city_id' => 96
        ]);
        District::create([
            'id' => 966,
            'name' => 'Huyện U Minh',
            'city_id' => 96
        ]);
        District::create([
            'id' => 967,
            'name' => 'Huyện Thới Bình',
            'city_id' => 96
        ]);
        District::create([
            'id' => 968,
            'name' => 'Huyện Trần Văn Thời',
            'city_id' => 96
        ]);
        District::create([
            'id' => 969,
            'name' => 'Huyện Cái Nước',
            'city_id' => 96
        ]);
        District::create([
            'id' => 970,
            'name' => 'Huyện Đầm Dơi',
            'city_id' => 96
        ]);
        District::create([
            'id' => 971,
            'name' => 'Huyện Năm Căn',
            'city_id' => 96
        ]);
        District::create([
            'id' => 972,
            'name' => 'Huyện Phú Tân',
            'city_id' => 96
        ]);
        District::create([
            'id' => 973,
            'name' => 'Huyện Ngọc Hiển',
            'city_id' => 96
        ]);
    }

    public function initAnamnesisCatalog()
    {
        AnamnesisCatalog::create([
            'name' => 'Máu loãng',
            'description' => 'Máu loãng'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Tiểu đường',
            'description' => 'Tiểu đường'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Thần kinh',
            'description' => 'Thần kinh'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Đột quy',
            'description' => 'Đột quy'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Huyết áp thấp',
            'description' => 'Huyết áp thấp'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Huyết áp cao',
            'description' => 'Huyết áp cao'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Ung thư',
            'description' => 'Ung thư'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Hen suyễn',
            'description' => 'Hen suyễn'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Bệnh thận',
            'description' => 'Bệnh thận'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Bệnh tâm thần',
            'description' => 'Bệnh tâm thần'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Dị tật bẩm sinh',
            'description' => 'Dị tật bẩm sinh'
        ]);
        AnamnesisCatalog::create([
            'name' => 'Bệnh truyền nhiễm qua máu',
            'description' => 'Bệnh truyền nhiễm qua máu'
        ]);
        AnamnesisCatalog::create([
            'name' => 'AIDS',
            'description' => 'AIDS'
        ]);
        AnamnesisCatalog::create([
            'name' => 'AIDS',
            'description' => 'AIDS'
        ]);
    }

    public function initMedicine()
    {
        Medicine::create([
            'name' => 'Paracetamol',
            'use' => 'giảm đau',
            'description' => 'giảm đau'
        ]);
        Medicine::create([
            'name' => 'Aspirin',
            'use' => 'giảm đau',
            'description' => 'giảm đau'
        ]);
        Medicine::create([
            'name' => 'Ibuprofen',
            'use' => 'giảm đau',
            'description' => 'giảm đau'
        ]);
        Medicine::create([
            'name' => 'Corticoid',
            'use' => 'Chống viêm mạnh',
            'description' => 'Chống viêm mạnh'
        ]);
        Medicine::create([
            'name' => 'Cimetidin',
            'use' => 'thuốc giảm tiết dịch dạ dày',
            'description' => 'thuốc giảm tiết dịch dạ dày'
        ]);
        Medicine::create([
            'name' => 'Omeprazol',
            'use' => 'thuốc giảm tiết dịch dạ dày',
            'description' => 'thuốc giảm tiết dịch dạ dày'
        ]);
        Medicine::create([
            'name' => 'Penicillin ',
            'use' => 'Kháng sinh',
            'description' => 'Kháng sinh'
        ]);
        Medicine::create([
            'name' => 'Phenoxymethylpenicillin',
            'use' => 'Kháng sinh',
            'description' => 'Kháng sinh'
        ]);
        Medicine::create([
            'name' => 'Phenoxymethylpenicillin',
            'use' => 'Kháng sinh',
            'description' => 'Kháng sinh'
        ]);
        Medicine::create([
            'name' => 'Cefixim',
            'use' => 'Kháng sinh',
            'description' => 'Kháng sinh dòng cephalosporin '
        ]);
        Medicine::create([
            'name' => 'Acyclovir',
            'use' => 'Chống nhiễm nấm ở khoang miệng',
            'description' => 'Chống nhiễm nấm ở khoang miệng'
        ]);
        Medicine::create([
            'name' => 'Penciclovir',
            'use' => 'Chống nhiễm nấm ở khoang miệng',
            'description' => 'Chống nhiễm nấm ở khoang miệng'
        ]);
        Medicine::create([
            'name' => 'Nước súc miệng Chlorhexidin 0,2% ',
            'use' => 'Nước súc miệng',
            'description' => 'Nước súc miệng'
        ]);
        Medicine::create([
            'name' => 'Nước súc miệng Hydrogen peroxid 6%.',
            'use' => 'Nước súc miệng',
            'description' => 'Nước súc miệng'
        ]);
        Medicine::create([
            'name' => 'Pilocarpin',
            'use' => 'Thuốc chống khô miệng',
            'description' => ' tác dụng kích thích vào tuyến nước bọt gây tăng tiết, kích thích vào cơ trơn thành ống tuyến co bóp để đẩy nước bọt vào miệng'
        ]);
        Medicine::create([
            'name' => 'Acmegel 100mg',
            'use' => 'Thuốc điều trị nha chu',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Aldezol-0.5g/100ml',
            'use' => 'Thuốc điều trị nha chu',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Dophargyl',
            'use' => 'Thuốc điều trị nha chu',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Dorogyne',
            'use' => 'Thuốc điều trị nha chu',
            'description' => 'Merynal'
        ]);
        Medicine::create([
            'name' => 'Menystin',
            'use' => 'Thuốc điều trị nha chu',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Mediginal',
            'use' => 'Thuốc điều trị nha chu',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Flagyl 250mg',
            'use' => 'Thuốc điều trị nha chu',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Cebemyxine',
            'use' => 'Thuốc điều trị viêm ổ răng',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Emla',
            'use' => 'Thuốc điều trị viêm ổ răng',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Emla 5%',
            'use' => 'Thuốc điều trị viêm ổ răng',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Lidocain 2%',
            'use' => 'Thuốc điều trị viêm ổ răng',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Lidocain 100mg/5ml',
            'use' => 'Thuốc điều trị viêm ổ răng',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Izac',
            'use' => 'Thuốc điều trị viêm ổ răng',
            'description' => ''
        ]);
        Medicine::create([
            'name' => 'Framykoin 5g',
            'use' => 'Thuốc điều trị viêm ổ răng',
            'description' => ''
        ]);
    }

    public function initDistrict()
    {

    }

    public function initEvent()
    {
        Event::create([
            'name' => 'Khuyến Mãi Trám răng',
            'start_date' => '2018-06-15 20:08:18',
            'end_date' => '2018-07-15 20:08:18',
            'discount' => '20',
            'staff_id' => 1,
            'created_date' => Carbon::now(),
            'treatment_id' => 1,
        ]);
        Event::create([
            'name' => 'Khuyến Mãi Trám răng',
            'start_date' => '2018-06-15 20:08:18',
            'end_date' => '2018-06-17 20:08:18',
            'discount' => '30',
            'staff_id' => 1,
            'created_date' => Carbon::now(),
            'treatment_id' => 1,
        ]);
        Event::create([
            'name' => 'Khuyến Mãi Trám răng',
            'start_date' => '2018-06-15 20:08:18',
            'end_date' => '2018-07-15 20:08:18',
            'discount' => '20',
            'staff_id' => 1,
            'created_date' => Carbon::now(),
            'treatment_id' => 2,
        ]);
    }

    public function initClientToken()
    {
        //ko co model nen insert raw
        DB::insert("INSERT INTO oauth_clients (id, user_id, name, secret, redirect, personal_access_client, password_client, revoked, created_at, updated_at) VALUES
(1, NULL, 'Laravel Personal Access Client', '70ZQNcZU1hBP45hRKBVHUpeUQ5GGEgUPN4NQhSLR', 'http://localhost', 1, 0, 0, '2018-07-10 16:07:11', '2018-07-10 16:07:11'),
(2, NULL, 'Laravel Password Grant Client', 'GaR9EznJvZ7TboFs1af1zfJGVDueHTXr5FWSpb1i', 'http://localhost', 0, 1, 0, '2018-07-10 16:07:11', '2018-07-10 16:07:11');");
    }

}
