<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 08-Jul-18
 * Time: 16:04
 */

namespace App\Http\Controllers\Mobile;


use App\Helpers\AppConst;
use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\RequestAbsentBusinessFunction;
use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Jobs\SendFirebaseJob;
use App\Jobs\SendSmsJob;
use App\Model\AnamnesisPatient;
use App\Model\FirebaseToken;
use App\Model\Patient;
use App\Model\RequestAbsent;
use App\Model\Staff;
use App\Model\User;
use App\Model\UserHasRole;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use SMSGatewayMe\Client\ApiException;

class StaffController extends BaseController
{
    use UserBusinessFunction;
    use PatientBusinessFunction;
    use AppointmentBussinessFunction;
    use RequestAbsentBusinessFunction;
    use TreatmentHistoryBusinessFunction;

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
                $this->updateUserFirebaseToken($phone, $notifToken);
                $this->updateUser($result);//update notification token
                $staffProfile = $result->belongToStaff()->first();
                $staffProfile->district = $staffProfile->belongsToDistrict()->first();
                $staffProfile->role_id = $result->hasUserHasRole()->first()->role_id;
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
                    $staffProfile->token_created_date = $result->tokens()->first()->created_at;
                }
                return response()->json($staffProfile, 200);
            } else {
                $error = $this->getErrorObj(
                    "Số điện thoại hoặc mật khẩu không chính xác"
                    , "No exception");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            Log::info($ex->getTraceAsString());
            return response()->json($this->getErrorObj('Lỗi server', $ex), 400);
        }
    }


    public function doneTreatment($tmHistory)
    {
        try {
            $dateStr = (new DateTime())->format("Y-m-d");
            $tmDetails = $this->getListTmDetailByDate($tmHistory->id, $dateStr);
            $treatment = $tmHistory->belongsToTreatment()->first();
            $count = 0;
            if ($tmDetails != null) {
                $this->logInfo(" tmDetails != null");
                foreach ($tmDetails as $detail) {
                    $count++;
                    $feedback = $detail->hasFeedback()->first();
                    if ($feedback == null) {
                        $this->logInfo("$feedback == null");
                        $dentist = Staff::where('id', $detail->staff_id)->first();
                        $patientId = $tmHistory->patient_id;
                        $phone = Patient::where('id', $patientId)->first()->phone;
                        $firebaseToken = FirebaseToken::where('phone', $phone)->first();
                        if ($firebaseToken != null) {
                            $feedbackObj = Utilities::getFeedbackObject(
                                $dentist->name,
                                $patientId,
                                $detail->id,
                                $dentist->avatar,
                                $treatment->name,
                                $detail->created_date);
                            $this->dispatch(new SendFirebaseJob(
                                AppConst::RESPONSE_FEEDBACK,
                                "Thông báo",
                                "Đánh giá dịch vụ " . $treatment->name . ' lần ' . $count,
                                json_encode($feedbackObj),
                                $firebaseToken->noti_token
                            ));
                            $this->logInfo("Send feedback to" . $phone);
                        } else {
                            $this->logInfo("Fire base null");
                        }
                    }
                }
            }
            return response()->json($this->getSuccessObj(200, "OK", "Gửi khảo sát thành công", "No data"));
        } catch (Exception $ex) {
            $errorObj = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($errorObj, 500);
        }
    }

    public function updateAppointmentStatus(Request $request)
    {
        try {
            $status = $request->input('status');
            $appointmentId = $request->input('appointment_id');
            $appointment = $this->getAppointmentById($appointmentId);
            $appointment->status = $status;
            $this->updateAppointment($appointment);
            $successResponse = $this->getSuccessObj(200, "OK", "Sửa lịch thành công", "No data");
            if ($status == AppConst::APPT_STATUS_DONE) {
                $tmHistories = $this->getPatientTreatmentHistory(
                    $appointment->staff_id,
                    $appointment->hasPatientOfAppointment()->first()->patient_id,
                    (new DateTime())->format('Y-m-d')
                );
                foreach ($tmHistories as $tmHistory) {
                    $this->doneTreatment($tmHistory);
                }
            }
            return response()->json($successResponse);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj('Lỗi máy chủ', $ex);
            return response()->json($error, 500);
        }
    }

    public function receiveAppointmentManually(Request $request)
    {
        try {
            $patientId = $request->input('patient_id');
            $appointmentId = $request->input('appointment_id');
            $appointment = $this->getAppointmentById($appointmentId);
            if ($appointment->status != 0) {
                $errorResponse = $this->getErrorObj("Trạng thái lịch hẹn không hợp lệ", "No exception");
                return response()->json($errorResponse, 400);
            }

            $patientAppointment = $appointment->hasPatientOfAppointment()->first();
            if ($patientAppointment != null) {
                $errorResponse = $this->getErrorObj("Bệnh nhân đã được nhận khám", "No exception");
                return response()->json($errorResponse, 400);
            } else {
                $appointment->status = 1;
                $this->saveAppointment($appointment, $patientId);
                $this->updateNumAppWebsite($appointment);
                $this->sendFirebaseReloadMobile($appointment->staff_id, AppConst::ACTION_RELOAD_DENTIST_APPOINTMENT);
                $successResponse = $this->getSuccessObj(200, "OK", "Change status success", "No data");
                $this->logInfo("VO reload else");
                return response()->json($successResponse, 200);
            }
        } catch (Exception $exception) {
            $errorResponse = $this->getErrorObj("Lỗi server", $exception);
            return response()->json($errorResponse, 500);
        }
    }

    public function receiveAppointment(Request $request)
    {
        $patientId = $request->input('patient_id');
        $phone = $this->getPhoneOfPatient($patientId);
        $isExamination = $this->checkPatientIsExamination($patientId);
        if ($isExamination) {
            $error = $this->getErrorObj("Bệnh nhân đã được nhận khám", 400);
            return response()->json($error, 400);
        } else {
            $appointment = $this->checkAppointmentForPatient($phone, $patientId);
            if ($appointment === null) {
                $error = $this->getErrorObj("Bệnh nhân chưa có lịch hẹn", "No Exception");
                return response()->json($error, 417);
            } else {
                $appointment->status = 1;
                $this->saveAppointment($appointment, $patientId);
                $this->updateNumAppWebsite($appointment);
                $this->sendFirebaseReloadMobile($appointment->staff_id, AppConst::ACTION_RELOAD_DENTIST_APPOINTMENT);
                $successResponse = $this->getSuccessObj(200, "OK", "Nhận bệnh thành công", "No Exception");
                return response()->json($successResponse, 200);
            }
        }
    }

    public function changeDentist(Request $request)
    {
        try {
            $dentistId = $request->input('staff_id');
            $appointmentId = $request->input('appointment_id');
            $appointment = $this->getAppointmentById($appointmentId);
            $appointment->staff_id = $dentistId;
            $this->updateAppointment($appointment);
            $this->sendFirebaseReloadMobile($dentistId, AppConst::ACTION_RELOAD_DENTIST_APPOINTMENT);
            $this->updateNumAppWebsite($appointment);
            $successResponse = $this->getSuccessObj(200, "OK", "Đổi nha sĩ thành công", "No data");
            return response()->json($successResponse);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj('Lỗi máy chủ', $ex);
            return response()->json($error, 500);
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
//        var_dump($request->all());
//        $this->logDebug(print_r($request->all(),true));
//        return;
        try {
            $phone = $request->input('phone');
            $user = $this->getUserByPhone($phone);
            $newAccount = false;
            if ($user == null) {
                $user = new User();
                $user->phone = $phone;
                $user->password = Hash::make($phone);
                $newAccount = true;
            }
            $name = $request->input('name');
            $gender = $request->input('gender');
            $birthday = $request->input('date_of_birth');
            $districtId = $request->input('district_id');
            $address = $request->input('address');
            $listAnamnesisId = $request->input('anamnesis[]');
            $patient = new Patient();
            $patient->phone = $phone;
            $patient->date_of_birth = $birthday;
            $patient->gender = $gender;
            $patient->district_id = $districtId;
            $patient->name = $name;
            $patient->address = $address;


            $userHasRole = new UserHasRole();
            $userHasRole->phone = $phone;
            $userHasRole->role_id = AppConst::ROLE_PATIENT;
            $userHasRole->start_time = Carbon::now();
            $result = null;
            if ($newAccount) {
                $result = $this->createUserWithAnamnesis($user, $patient, $userHasRole, $listAnamnesisId);
                $this->logBugAppointment("CREATE NEW USE");
            } else {
                $result = $this->updatePatientWithAnamnesis($patient, $listAnamnesisId);
                $this->logBugAppointment("CREATE NEW PATIENT");
            }
            if ($result) {
                return response()->json($patient, 200);
            } else {
                $error = $this->getErrorObj("Không thễ tạo hồ sơ bệnh nhân, vui lòng thử lại",
                    "result false, no exception");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = $this->getErrorObj(
                "Không thể đăng kí thông tin người dùng", $ex);
            return response()->json($error, 400);
        }
    }

//allow staff to book in the end of the day.
    public function bookAppointment2(Request $request)
    {
        //get role of staff
//        $userObj = $dentistObj->belongsToUser()->first();
//        $userObj->hasUserHasRole()->where('role_id', AppConst::ROLE_DENTIST)
//            ->orWhere('role_id', AppConst::ROLE_RECEPTIONIST)->first();


    }

    //query chart
    public function getChartTreatmentData(Request $request)
    {
        $staffId = $request->input('staff_id');
        $month = $request->input('month');
        $year = $request->input('year');

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

    public function bookAppointment(Request $request)
    {
        $phone = $request->input('phone');
        $note = $request->input('note');
        $bookingDate = $request->input('booking_date');
        $dentistId = $request->input('dentist_id');
        $patientId = $request->input('patient_id');
        $patientName = $request->input('name');
        $allowOvertime = $request->input('is_allow_overtime');
        $estimatedTime = $request->input('estimated_time');
        $appdateObj = new DateTime($bookingDate);
        try {
//            $dentist = $this->getStaffById($dentistId);
//            if ($dentist == null) {
//                $error = $this->getErrorObj("Không thể tìm thấy số điện thoại nha sĩ",
//                    "No exception");
//                return response()->json($error, 400);
//            }
            $patient = $this->getPatientById($patientId);
//            if ($patient == null) {
//                $error = $this->getErrorObj("Không thể tìm thấy bệnh nhân",
//                    "No exception");
//                return response()->json($error, 400);
//            }
            $result =
                $this->createAppointment($bookingDate, $phone, $note, $dentistId, $patientId, $estimatedTime, $patientName, $allowOvertime == 1);
            if ($allowOvertime == 0 && $result !=null) {
                $newApptDateObj = new DateTime($result->start_time);
                $this->dispatch(new SendSmsJob($phone,
                  AppConst::getStaffSMSForAppt($result->numerical_order, $newApptDateObj)));
            }
            return response()->json($result, 200);
        } catch (ApiException $e) {
            $error = Utilities::getErrorObj("Lỗi server", $e);
            return response()->json($error, 400);
        } catch (\Exception $ex) {
            if ($ex->getMessage() == "isEndOfTheDay" && ($allowOvertime == 0)) {
                $currentTime = new DateTime();
                if ($this->isEndOfTheDay($currentTime)) {
                    $error = $this->getErrorObj("Đã quá thời gian đặt lịch, bạn vui lòng chọn ngày khác", $ex);
                } else {
                    $error = $this->getErrorObj("Lịch hẹn ngày " . $appdateObj->format('d-m-Y') . " đã đầy, bạn vui lòng chọn ngày khác", $ex);
                }
                return response()->json($error, 400);
            } else {
                $error = Utilities::getErrorObj("Lỗi server", $ex);
                return response()->json($error, 400);
            }
        }
    }

    public function getStaffAppointmentByMonth(Request $request)
    {
        try {
            $dentistId = $request->input('dentist_id');
            $month = $request->input('month');
            $year = $request->input('year');
            if ($dentistId == null || $month == null) {
                $error = $this->getErrorObj("Vui lòng điền đầy đủ id nha sĩ và tháng", "No exception");
                return response()->json($error, 400);
            }
            $appointments = $this->getAppointmentsInMonth($dentistId, $year, $month);

            return $appointments;
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 500);
        }
    }

    public function getAvailableDentist(Request $request)
    {
        $date = $request->input('date');
        try {
            $dentists = $this->getAvailableDentistAtDate($date);
            return response()->json($dentists, 200);
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }

    }

    public function getCurrentFreeDentists(Request $request)
    {
        $date = $request->input('date');
        try {
            $availableDentists = $this->getAvailableDentistAtDate($date);
            $freeDentists = $this->getCurrentFreeDentist();
            foreach ($availableDentists as $dentist) {
                if (in_array($dentist->id, $freeDentists)) {
                    $dentist->status = 'Đang rãnh';
                } else {
                    $dentist->status = 'Đang bận';
                }
            }
            return response()->json($availableDentists, 200);
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }

    }

    public function getListRequestAbsent(Request $request)
    {
        try {
            $staffId = $request->input('staff_id');
            $listRequestAbsents = $this->getListStaffRequestAbsent($staffId);
            return response()->json($listRequestAbsents, 200);
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }
    }

    public function getListRequestAbsentByTime(Request $request)
    {
        try {
            $staffId = $request->input('staff_id');
            $month = $request->input('month');
            $year = $request->input('year');

            $listRequestAbsents = $this->getListStaffRequestAbsentByTime($staffId, $month, $year);
            return response()->json($listRequestAbsents, 200);
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }
    }

    public function updateStaffInfo(Request $request)
    {
        try {
            $staffId = $request->input('id');
            $name = $request->input('name');
            $gender = $request->input('gender');
            $email = $request->input('email');
            $birthday = $request->input('date_of_birth');
            $address = $request->input('address');
            $degree = $request->input('degree');
            $districtId = $request->input('district_id');
            $staff = $this->getStaffById($staffId);
            if ($staff != null) {
                $staff->id = $staffId;
                $staff->name = $name;
                $staff->email = $email;
                $staff->gender = $gender;
                $staff->date_of_birth = $birthday;
                $staff->address = $address;
                $staff->degree = $degree;
                $staff->district_id = $districtId;
                $result = $this->updateStaffProfile($staff);
                if ($result == true) {
                    $successResponse = new \stdClass();
                    $successResponse->status = "OK";
                    $successResponse->code = 200;
                    $successResponse->message = "Sửa tài khoản thành công";
                    $successResponse->data = $staff;
                    return response()->json($successResponse, 200);
                } else {
                    $error = $this->getErrorObj("Không thể sửa đổi thông tin người dùng", "No exception");
                    return response()->json($error, 400);
                }
            } else {
                $error = $this->getErrorObj("Không thể tìm thấy id bệnh nhân", "No exception");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 400);
        }
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

    public function getPatientAppointmentByDate(Request $request)
    {
        $dateStr = $request->input('date');
        $dentistId = $request->input('staff_id');
        try {
            $appointments = $this->getDentistApptAtDate($dentistId, $dateStr);
            foreach ($appointments as $appointment) {
                $patientAppointment = $appointment->hasPatientOfAppointment()->first();
                if ($patientAppointment != null) {
                    $appointment->patient = $patientAppointment->belongsToPatient()->first();
                } else {
                    $appointment->patient = null;
                }
            }
            return response()->json($appointments);
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }
    }

    public function changeAvatar(Request $request)
    {
        try {
            $id = $request->input('id');
            $image = $request->file('image');
            $tmpStaff = $this->getStaffById($id);
            if ($tmpStaff != null) {
                $timestamp = (new DateTime())->getTimestamp();
                $urlImg = Utilities::saveFile($image, AppConst::AVATAR_PATH, $timestamp);
                $tmpStaff->avatar = $urlImg;
                $this->updateStaffProfile($tmpStaff);
                $response = new \stdClass();
                $response->status = "OK";
                $response->message = "Chỉnh sửa avatar thành côngs";
                $response->data = $tmpStaff->avatar;
                return response()->json($response, 200);
            } else {
                $error = $this->getErrorObj("Không thể tìm thấy bệnh nhân ", "Nothing");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 400);
        }
    }

    public function requestAbsent(Request $request)
    {
        try {
            $staffId = $request->input('staff_id');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $reason = $request->input('reason');
            $requestAbsentObj = new RequestAbsent();
            $requestAbsentObj->staff_id = $staffId;
            $requestAbsentObj->reason = $reason;
            $requestAbsentObj->start_date = $startDate;
            $requestAbsentObj->end_date = $endDate;
            $this->createRequestAbsent($requestAbsentObj);
            $absentObj = $this->getAbsentObject($requestAbsentObj);
            if ($absentObj != null) {
                $requestAbsentObj->staff_approve = $absentObj->belongsToStaff() == null ?
                    null : $absentObj->belongsToStaff()->first();
                $requestAbsentObj->message_from_staff = $absentObj->message_from_staff;
                $requestAbsentObj->created_time = $absentObj->created_time;
                $requestAbsentObj->is_approved = $absentObj->is_approved == null ? 0 : $absentObj->is_approved;
            } else {
                $requestAbsentObj->staff_approve = null;
                $requestAbsentObj->message_from_staff = null;
                $requestAbsentObj->created_time = null;
                $requestAbsentObj->is_approved = 0;
            }
            return response()->json($requestAbsentObj, 200);
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }
    }
}