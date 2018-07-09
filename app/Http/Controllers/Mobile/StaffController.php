<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 08-Jul-18
 * Time: 16:04
 */

namespace App\Http\Controllers\Mobile;


use App\Helpers\AppConst;
use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Patient;
use App\Model\Staff;
use App\Model\User;
use App\Model\UserHasRole;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class StaffController extends BaseController
{
    use UserBusinessFunction;
    use StaffBusinessFunction;

    public function loginStaff(Request $request)
    {
        try {
            $phone = $request->input('phone');
            $password = $request->input('password');
            $notifToken = $request->input('noti_token');
            $staff = $this->getUserByPhone($phone);
            if ($staff == null) {
                $error = $this->getErrorObj("Không thể tìm thấy số điện thoại", "No exception");
                return response()->json($error, 400);
            }
            if (!$this->isRoleStaff($phone)) {
                $error = $this->getErrorObj("Tài khoản của bạn không có quyền truy cập!", "No exception");
                return response()->json($error, 400);
            }
            $result = $this->checkLogin($phone, $password);
            if ($result != null) {
                $result->noti_token = $notifToken;
                $this->updateUser($result);//update notification token
                $staffProfile = $result->belongToStaff()->first();
                $clientSecret = env(AppConst::PASSWORD_CLIENT_SECRET, false);
                $clientId = env(AppConst::PASSWORD_CLIENT_ID, false);
                $request->request->add([
                    'client_id' => $clientId,
                    'grant_type' => 'password',
                    'client_secret' => $clientSecret,
                    'scope' => '',
                    'username' => $phone
                ]);
                $tokenRequest = Request::create('/oauth/token', 'post');
                $tokenResponse = (Route::dispatch($tokenRequest));
                $tokenResponseBody = json_decode($tokenResponse->getContent());
                if ($tokenResponseBody != null) {
                    $staffProfile->access_token = $tokenResponseBody->access_token;
                    $staffProfile->refresh_token = $tokenResponseBody->refresh_token;
                    $staffProfile->token_type = $tokenResponseBody->token_type;
                    $staffProfile->expires_in = $tokenResponseBody->expires_in;
                }
                return response()->json($staffProfile, 200);
            } else {
                $error = $this->getErrorObj(
                    "Số điện thoại hoặc mật khẩu không chính xác"
                    , "No exception");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            return response()->json($this->getErrorObj('Lỗi server', $ex), 400);
        }
    }

    public function createStaffAcccount(Request $request)
    {
        try {
            $phone = $request->phone;
            $checkExist = $this->checkExistUser($phone);
            if ($checkExist) {
                $errorObj = $this->getErrorObj(
                    "Tài khoản đã tồn tại",
                    "No exception");
                return response()->json($errorObj, 400);
            }
            $userHasRole = new UserHasRole();
            $userHasRole->phone = $request->phone;
            $userHasRole->role_id = $request->role_id;
            $userHasRole->start_time = Carbon::now();
            $staff = new Staff();
            $user = new User();
            $staff->name = $request->name;
            $staff->address = $request->address;
            $staff->phone = $request->phone;
            $staff->date_of_birth = $request->date_of_birth;
            $staff->gender = $request->gender;
            $staff->avatar = $request->avatar;
            $staff->district_id = $request->district_id;
            $staff->degree = $request->degree;
            $user->phone = $phone;
            $user->password = Hash::make($request->password);
            $result = $this->createUserWithRole($user, $staff, $userHasRole);
            if ($result) {
                return response()->json($staff, 200);
            } else {
                $errorObj = $this->getErrorObj("Có lỗi xảy ra, không thể tạo tài khoản",
                    "No exception");
                return response()->json($errorObj, 400);
            }
        } catch (Exception $exception) {
            $errorObj = $this->getErrorObj("Lỗi server", $exception);
            return response()->json($errorObj, 400);
        }
    }

    public function createPatient(Request $request)
    {
        try {
            $phone = $request->input('phone');
            $user = $this->getUserByPhone($phone);
            if ($user != null) {
                $name = $request->input('name');
                $gender = $request->input('gender');
                $birthday = $request->input('birthday');
                $districtId = $request->input('districtId');
                $address = $request->input('address');
                $patient = new Patient();
                $patient->phone = $phone;
                $patient->date_of_birth = $birthday;
                $patient->gender = $gender;
                $patient->district_id = $districtId;
                $patient->name = $name;
                $patient->address = $address;
                $result = $this->updateUser($patient);
                if ($result) {
                    return response()->json($patient, 200);
                } else {
                    $error = $this->getErrorObj("Không thễ tạo hồ sơ bệnh nhân, vui lòng thử lại",
                        "result false, no exception");
                    return response()->json($error, 400);
                }
            } else {
                $error = $this->getErrorObj(
                    "Số diện thoại chưa được đăng kí",
                    "No Exception");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = $this->getErrorObj(
                "Không thể đăng kí thông tin người dùng", $ex);
            return response()->json($error, 400);
        }
    }

    public function createUser(Request $request)
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
                $userHasRole->role_id = 4;
                $userHasRole->start_time = Carbon::now();
                $this->createUserWithRole($user, $patient, $userHasRole);

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
}