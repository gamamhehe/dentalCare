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
use App\Model\UserHasRole;
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
        try {
            $phone = $request->input('phone');
            $user = $this->getUserByPhone($phone);
            if ($user == null) {
                $user = new User();
                $password = $request->input('password');
                $name = $request->input('name');
                $gender = $request->input('gender');
                $birthday = $request->input('birthday');
                $districtId = $request->input('districtId');
                $address = $request->input('address');

                $user->phone = $phone;
                $user->password = Hash::make($password);
                $user->isDeleted = 0;

                $patient = new Patient();
                $patient->phone = $phone;
                $patient->date_of_birth = $birthday;
                $patient->gender = $gender;
                $patient->district_id = $districtId;
                $patient->name = $name;
                $patient->avatar = "";
                $patient->address = $address;
                ////HASH
                $userHasRole = new UserHasRole();
                $userHasRole->phone = $phone;
                $userHasRole->role_id = 0;
                $this->registerPatient($user, $patient, $userHasRole);
                return response()->json($patient, 200);
            } else {
                $error = new \stdClass();
                $error->error = "Số điện thoại đã tồn tại";
                $error->exception = "No Exception";
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Không thể đăng kí thông tin người dùng";
            $error->exception = $ex->getMessage();
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
            $result = $this->checkLogin($phone, $password);
            if ($result != null) {
                $patients = $this->getPatient($phone);
                $userResponse = new \stdClass();
                $userResponse->phone = $phone;
                $userResponse->patients = $patients;
                return response()->json($userResponse, 200);
            } else {
                $error = new \stdClass();
                $error->error = "Số điện thoại hoặc mật khẩu không chính xác";
                $error->exception = "No exception";
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Lỗi server";
            $error->exception = $ex->getMessage();
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

    public function changePassword(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $user = $this->getUserByPhone($phone);
        $errorResponse = new \stdClass();
        if ($user != null) {
            if ($this->changeUserPassword($phone, $password)) {
                $successResponse = new \stdClass();
                $successResponse->status = "OK";
                $successResponse->code = 200;
                $successResponse->message = "Sửa mật khẩu thành công";
                $successResponse->data = null;
                return response()->json($successResponse, 200);
            } else {
                $errorResponse->error = "Không thể sửa mật khẩu";
                $errorResponse->exception = null;
                return response()->json($errorResponse, 400);
            }
        } else {
            $errorResponse->error = "Không thể tìm thấy người dùng";
            $errorResponse->exception = null;
            return response()->json($errorResponse, 400);
        }
    }

    public function resetpassword($phone, $password)
    {
//        $phone = $request->get('phone');
//        $password = $request->get('password');

        $user = User::where('phone', $phone)->first();
        if (
            $user != null
        ) {
            $user->password = Hash::make($password);
            $user->save();
            return response()->json("Update Phone: " . $phone . " and password: " . $password . " Successful!");
        }
    }

    public function updatePatientInfo(Request $request)
    {
        try {
            $patientId = $request->input('id');
            $name = $request->input('name');
            $gender = $request->input('gender');
            $birthday = $request->input('date_of_birth');
            $address = $request->input('address');
            $districtId = $request->input('district_id');
            $patient = $this->getPatientById($patientId);
            if ($patient != null) {
                $patient->name = $name;
                $patient->gender = $gender;
                $patient->date_of_birth = $birthday;
                $patient->address = $address;
                $patient->district_id = $districtId;
                $result = $this->updatePatient($patient);
                if ($result == true) {
                    $successResponse = new \stdClass();
                    $successResponse->status = "OK";
                    $successResponse->code = 200;
                    $successResponse->message = "Sửa tài khoản thành công";
                    $successResponse->data = $patient;
                    return response()->json($successResponse, 200);
                } else {
                    $error = new \stdClass();
                    $error->error = "Không thể sửa đổi thông tin người dùng";
                    $error->exeption = null;
                    return response()->json($error, 400);
                }
            } else {
                $error = new \stdClass();
                $error->error = "Không thể tìm thấy id bệnh nhân";
                $error->exeption = null;
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Lỗi máy chủ";
            $error->exception = $ex->getMessage();
            return response()->json($error, 400);
        }
    }

    public function changeAvatar(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $id = $request->input('id');
                $image = $request->file('image');
                $tmpPatient = $this->getPatientById($id);
                if ($tmpPatient != null) {
                    if ($this->editAvatar($image, $id)) {
                        $patient = $this->getPatientById($id);
                        $response = new \stdClass();
                        $response->status = "OK";
                        $response->message = "Chỉnh sửa avatar thành côngs";
                        $response->data = $patient->avatar;
                        return response()->json($response, 200);
                    } else {
                        $error = new \stdClass();
                        $error->error = "Có lỗi xảy ra, không thể chỉnh sửa avatar";
                        $error->exception = "Nothing";
                        return response()->json($error, 400);
                    }
                } else {
                    $error = new \stdClass();
                    $error->error = "Không thể tìm thấy bệnh nhân ";
                    $error->exception = "Nothing";
                    return response()->json($error, 400);
                }
            } else {
                $error = new \stdClass();
                $error->error = "Lỗi khi nhận hình ảnh ";
                $error->exception = "Nothing";
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Lỗi máy chủ";
            $error->exception = $ex->getMessage();
            return response()->json($error, 400);
        }
    }

}