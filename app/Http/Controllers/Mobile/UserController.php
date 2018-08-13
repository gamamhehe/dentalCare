<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 04-Jun-18
 * Time: 11:43
 */

namespace App\Http\Controllers\Mobile;


use App\Helpers\AppConst;
use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Jobs\SendSmsJob;
use App\Model\FirebaseToken;
use App\Model\Patient;
use App\Model\User;
use App\Model\UserHasRole;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use SMSGatewayMe\Client\ApiException;

class UserController extends BaseController
{
    use PatientBusinessFunction;
    use UserBusinessFunction;
    use TreatmentBusinessFunction;
    use AppointmentBussinessFunction;

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

                $patient = new Patient();
                $patient->phone = $phone;
                $patient->date_of_birth = $birthday;
                $patient->gender = $gender;
                $patient->district_id = $districtId;
                $patient->name = $name;
                $patient->address = $address;
                ////HASH
                $userHasRole = new UserHasRole();
                $userHasRole->phone = $phone;
                $userHasRole->role_id = AppConst::ROLE_PATIENT;
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

    public function bookAppointment(Request $request)
    {
        try {
            $phone = $request->input('phone');
            $note = $request->input('note');
            $bookingDate = $request->input('booking_date');
            $dentistId = $request->input('dentist_id');
            $patientId = $request->input('patient_id');
            $estimatedTime = $request->input('estimated_time');
            $name = $request->input('name');
            $user = $this->getUserByPhone($phone);
            $isNewUser = false;
            if ($user == null) {
                $user = new User();
                $user->phone = $phone;
                $user->password = Hash::make($phone);

                $userHasRole = new UserHasRole();
                $userHasRole->phone = $phone;
                $userHasRole->role_id = 1;
                $userHasRole->start_time = Carbon::now();
                $this->createUser($user, $userHasRole);
                $isNewUser = true;
            }
            $result = $this->createAppointment($bookingDate, $phone, $note, $dentistId, $patientId, $estimatedTime, $name);
            if ($result != null) {
//                $listAppointment = $this->getAppointmentsByStartTime($bookingDate);
                $startDateTime = new DateTime($result->start_time);
                $vnSmsMessage = AppConst::getSmsMSG($result->numerical_order, $startDateTime, true);
                $engSmsMessage = AppConst::getSmsMSG($result->numerical_order, $startDateTime);
                $this->dispatch(new SendSmsJob($phone, $engSmsMessage));
                if ($isNewUser) {
                    $this->dispatch(new SendSmsJob($phone, AppConst::getSmsNewUser()));
                }
                $successResponse = $this->getSuccessObj(200, "OK", $vnSmsMessage, "Nodata");
                return response()->json($successResponse, 200);
            } else {
                $error = $this->getErrorObj("Đã quá giờ đặt lịch, bạn vui lòng chọn ngày khác",
                    "Result is null, No exception");
                return response()->json($error, 400);
            }

        } catch (ApiException $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 500);
        } catch (\Exception $ex) {
            if ($ex->getMessage() == "isEndOfTheDay") {
                $currentTime = (new DateTime());
                if ($this->isEndOfTheDay($currentTime)) {
                    $error = $this->getErrorObj("Đã quá giờ đặt lịch, bạn vui lòng chọn ngày khác", $ex);
                } else {
                    $error = $this->getErrorObj("Đã quá giờ đặt lịch, bạn vui lòng chọn ngày khác", $ex);
                }
                return response()->json($error, 400);
            } else {
                $error = $this->getErrorObj("Lỗi server", $ex);
                return response()->json($error, 500);
            }
        }
    }

    /**
     * @param Request $request
     * @return json
     */
    public function login(Request $request)
    {
        try {
            $phone = $request->input('phone');
            $password = $request->input('password');
            $notifToken = $request->input('noti_token');
            $result = $this->checkLogin($phone, $password);
            if ($result != null) {
                $this->updateUserFirebaseToken($phone, $notifToken);
                $this->updateUser($result);
                $patients = $this->getPatientByPhone($phone);
                $userResponse = new \stdClass();
                $userResponse->phone = $phone;
                $userResponse->noti_token = $notifToken;
                $userResponse->patients = $patients;
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
                    $userResponse->access_token = $tokenResponseBody->access_token;
                    $userResponse->refresh_token = $tokenResponseBody->refresh_token;
                    $userResponse->token_type = $tokenResponseBody->token_type;
                    $userResponse->expires_in = $tokenResponseBody->expires_in;
                    $userResponse->token_created_date = $result->tokens()->first()->created_date;
                }
                return response()->json($userResponse, 200);
            } else {
                $error = new \stdClass();
                $error->error = "Số điện thoại hoặc mật khẩu không chính xác";
                $error->exception = "No exception";
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            return response()->json($this->getErrorObj('Lỗi server', $ex), 400);
        }
    }

    public function searchListPhone(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $phones = $this->getUserPhones($keyword);
            return response()->json($phones, 200);
        } catch (Exception $ex) {
            return response()->json($this->getErrorObj('Lỗi server', $ex), 400);
        }
    }

    public function logout(Request $request)
    {
        $phone = $request->input("phone");
        $fbToken = FirebaseToken::where('phone', $phone)->first();
        if ($fbToken != null) {
            $fbToken->noti_token = "null";
            $fbToken->save();
        }
        if (!Auth::guard('api')->check()) {
            $error = $this->getErrorObj(AppConst::MSG_LOGOUT_ERROR, null);
            return response()->json($error, 404);
        }
        $user = Auth::user();
        $this->updateUserFirebaseToken($user->phone, "null");
        $request->user('api')->token()->revoke();
//        Session::flush();
//        Session::regenerate();
        $successResponse = new \stdClass();
        $successResponse->code = 200;
        $successResponse->status = "OK";
        $successResponse->message = AppConst::MSG_LOGOUT_SUCCESS;
        $successResponse->data = null;
        return response()->json($successResponse, 200);
    }

    public function loginGET()
    {
        return response()->json(['hello' => 'cha co gi ca haha'], 200);
    }

    public function changePassword(Request $request)
    {
        $phone = $request->input('phone');
        $newPassword = $request->input('password');
        $currentPassword = $request->input('current_password');
        $user = $this->checkLogin($phone, $currentPassword);
        $errorResponse = new \stdClass();
        if ($user != null) {
            if ($this->changeUserPassword($phone, $newPassword)) {
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
            $errorResponse->error = "Mật khẩu hiện tại không hợp lệ";
            $errorResponse->exception = null;
            return response()->json($errorResponse, 400);
        }
    }

    public function getUser()
    {
//        $u = Auth::guard('api')->user();
        $user = Auth::guard('api')->user();
        $token = $user->AauthAcessToken()->get();
//        $token = json_decode($token);
        return response()->json($token);
    }


//get function to change password quickly
    public function resetpasswordTest($phone, $password)
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
        } else {
            return response()->json("Không tìm thấy số điện thoại " . $phone);
        }
    }

    public function resetPassword($phone)
    {
        try {
            $user = User::where('phone', $phone)->first();
            if ($user != null) {
                $password = Utilities::generateRandomString("0123456789abcdefghijklmnopqrstuvwxyz");
                $user->password = Hash::make($password);
                $this->dispatch(new SendSmsJob($phone, "Mat khau moi cua ban la " . $password));
                $this->updateUser($user);
                $successResponse = $this->getSuccessObj(200, "OK", "Đổi mật khẩu thành công", "No data");
                return response()->json($successResponse);
            } else {
                $error = $this->getErrorObj("Không tìm thấy tài khoản này ", "No exception");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }
    }


    public function sendFirebase()
    {
        try {
            $notification = new \stdClass();
            $notification->title = 'asdf';
            $notification->text = 'is is my text Tex';
            $notification->click_action = 'android.intent.action.MAIN';

            $data = new \stdClass();
            $data->keyname = 'sss';


            $requestObj = new \stdClass();
            $requestObj->notification = $notification;
            $requestObj->data = $data;
            $requestObj->to = '/topics/all';
            $client = new Client();
            $request = $client->request('POST', 'https://fcm.googleapis.com/fcm/send',
                [
                    'body' => json_encode($requestObj),
                    'Content-Type' => 'application/json',
                    'authorization' => 'key=AAAAUj5G2Bc:APA91bF8TkhDriuoevyt_I0G3G-qNniLSDdDHbULjcvsas4sHCuTKueiODRnuvVuYk6YkCHKLt3fr-Sw7UhZMzRSfmWMWzt2NZXzljYZxch39fg0v3NsBzQM5_QKUEy4bOdnnjigzaBX'
                ]
            );
//            $request->setBody($requestObj);
            $response = $request->getBody()->getContents();
            return response()->json($response);
        } catch (GuzzleException $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }

    public function updateNotifToken(Request $request)
    {
        try {
            $token = $request->input('noti_token');
            $phone = $request->input('phone');
            $this->updateUserFirebaseToken($phone, $token);
            $successResponse = $this->getSuccessObj(500, "OK", "Change notification token success", "Null data");
            return response()->json($successResponse, 200);
        } catch (\Exception $ex) {
            $errorResponse = $this->getErrorObj("Error when update firebase token", $ex);
            return response()->json($errorResponse, 500);
        }
    }

}