<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 04-Jun-18
 * Time: 11:43
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Patient;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class UserController extends Controller
{

use UserBusinessFunction;
use TreatmentBusinessFunction;

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('phone', $request->input('phone'))->first();
            if ($user == null) {
                $user = new User();
                $phone = $request->input('phone');
                $password = $request->input('password');
                $fullname = $request->input('fullname');
                $gender = $request->input('gender');
                $birthday = $request->input('birthday');
                $districtId = $request->input('districtId');
                $address = $request->input('address');
                $user->phone = $phone;
                $user->password = Hash::make($password);
                $user->isActive = 1;
                $user->isDelete = 0;
                $patient = Patient::where('phone', $request->input('phone'))
                    ->first();
                if ($patient != null) {
                    $error = new \stdClass();
                    $error->error = "Số điện thoại bệnh nhân đã tồn tại";
                    $error->exception = "No Exception";
                    DB::rollback();
                    return response()->json($error, 400);
                } else {
                    $patient = new Patient();
                    $patient->phone = $phone;
                    $patient->date_of_birth = $birthday;
                    $patient->gender = $gender;
                    $patient->district_id = $districtId;
                    $patient->name = $fullname;
                    $patient->avatar = "";
                    $patient->address = $address;
                    ////HASH
                    ///
                    $user->save();
                    $patient->save();
                    DB::commit();
                    return response()->json($patient, 200);
                }
            } else {
                $error = new \stdClass();
                $error->error = "Số điện thoại đã tồn tại";
                $error->exception = "No Exception";
                DB::rollback();
                return response()->json($error, 400);
            }
        } catch
        (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Không thể đăng kí thông tin người dùng";
            $error->exception = $ex;
            return response()->json($error, 400);
        }
    }

    /**
     * @param Request $request
     * @return json
     */
    public function loginPatient(Request $request)
    {
        try {
            $phone = $request->input('phone');
            $password = $request->input('password');
            $result = $this->checkLogin($phone,$password);
            if ($result != null) {
            $patientParent = $this->getPatient($phone);
                return response()->json($patientParent, 200);
            } else {
                $error->error = "Số điện thoại hoặc mật khẩu không chính xác";
                $error->exception = "No exception";
                return response()->json($error, 400);
            }
        }

        catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Đã xảy ra lỗi";
            $error->exception = $ex->getMessage();
//            var_dump($ex);
            return response()->json($error, 400);
        }
    }

    public
    function bookAppointment(Request $request)
    {
        ///lclclclcl

        return response()->json([$request->all()], 200);
    }

    public function loginGET()
    {
        return response()->json(['hello' => 'cha co gi ca haha'], 200);
    }


}