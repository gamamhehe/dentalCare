<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 12-Jun-18
 * Time: 21:56
 */

namespace App\Http\Controllers\Mobile;


use App\Helpers\AppConst;
use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Jobs\SendSmsJob;
use App\Model\Appointment;
use App\Model\Patient;
use App\Model\UserHasRole;
use App\Model\User;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use SMSGatewayMe\Client\ApiException;

//use SMSGatewayMe\Client\ApiException;

class AppointmentController extends BaseController
{
    use AppointmentBussinessFunction;
    use UserBusinessFunction;


    public function getAll()
    {
        try {
            $appointment = $this->getAllAppointment();
            return $appointment;
        } catch (Exception $exception) {
            $error = $this->getErrorObj("Có lỗi xảy ra", $exception);
            return response()->json($error, 400);
        }
    }

    public function getUserAppointmentByCurrentDate(Request $request)
    {
        try {
            $phone = $request->input('phone');
            $dateStr = (new \DateTime())->format('Y-m-d');
            $appointments = $this->getUserAppointmentByDate($phone, $dateStr);
            foreach ($appointments as $appointment) {
                $this->attachFieldAppointment($appointment);
            }
            return response()->json($appointments, 200);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Có lỗi xảy ra", $ex);
            return response()->json($error, 500);
        }
    }

    public function getByDate(Request $request)
    {
        try {
            $date = $request->input('date');
            $appointments = $this->getAppointmentByDate($date);
            foreach ($appointments as $appointment) {
                $this->attachFieldAppointment($appointment);
            }
            return response()->json($appointments, 200);
        } catch (\Exception $exception) {
            $error = $this->getErrorObj("Có lỗi xảy ra", $exception);
            return response()->json($error, 500);
        }
    }
    public function getById($id)
    {
        try {
            $appointment = $this->getAppointmentById($id);
            $response = $this->attachFieldAppointment($appointment);
            return response()->json($response, 200);
        } catch (Exception $exception) {
            $error = $this->getErrorObj("Có lỗi xảy ra", $exception);
            return response()->json($error, 400);

        }
    }

    public function getByPhone($phone)
    {
        try {
            $appointments = $this->getAppointmentByPhone($phone);
            foreach ($appointments as $appointment) {
                $this->attachFieldAppointment($appointment);
            }
            return response()->json($appointments, 200);
        } catch (Exception $exception) {
            $error = $this->getErrorObj("Có lỗi xảy ra", $exception);
            return response()->json($error, 400);

        }
    }



    public function bookAppointmentStaff(Request $request)
    {
        try {
            $phone = $request->input('phone');
            $note = $request->input('note');
            $bookingDate = $request->input('booking_date');
            $dentistId = $request->input('dentist_id');
            $this->logBugAppointment("DEN: " . $dentistId);
            $patientId = $request->input('patient_id');
            $estimatedTime = $request->input('estimated_time');
            $currentDay = new DateTime();
//            $appdateObj = new DateTime($bookingDate);
            $dentistObj = $this->getStaffById($dentistId);
            if ($dentistObj == null) {
                $error = $this->getErrorObj("Không tìm thấy id nha sĩ",
                    "No exception");
                return response()->json($error, 400);
            }
            if ($this->isEndOfTheDay($currentDay)) {
                $error = $this->getErrorObj("Dã quá giờ đặt lịch, bạn vui lòng chọn ngày khác",
                    "No Excepton");
                return response()->json($error, 400);
            }
            $result = $this->createAppointment($bookingDate, $phone, $note, $dentistId, $patientId, $estimatedTime);
            if ($result != null) {
                $listAppointment = $this->getAppointmentsByStartTime($bookingDate);
                $startDateTime = new DateTime($result->start_time);
                $smsMessage = AppConst::getSmsMSG($result->numerical_order, $startDateTime);
                $this->dispatch(new SendSmsJob($phone, $smsMessage));
                return response()->json($listAppointment, 200);
            } else {
                $error = $this->getErrorObj("Đã quá giờ đặt lịch, bạn vui lòng chọn ngày khác",
                    "Result is null, No exception");
                return response()->json($error, 400);
            }

        } catch (ApiException $e) {
            $error = $this->getErrorObj("Lỗi server", $e->getMessage());
            return response()->json($error, 400);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex->getMessage());
            return response()->json($error, 400);
        }
    }

    public function editAppointment(Request $request)
    {
        $phone = $request->input('phone');
        $note = $request->input('note');
        $bookingDate = $request->input('booking_date');
        $result = $this->createAppointment($bookingDate, $phone, $note);
        if ($result != null) {
            return response()->json($result, 200);
            $oldBookingDate = $request->input('booking_date');
            if ($this->getUserAppointmentByDate($phone, $oldBookingDate) && $this->checkExistUser($phone)) {
                $error = $this->getErrorObj("Bạn đã đặt lịch ngày " . $bookingDate . ' vui lòng kiểm tra lại tin nhắn',
                    "No exception");
                return response()->json($error, 400);
            } else {
                $result = $this->createAppointment($oldBookingDate, $phone, $note, null, null);
                if ($result != null) {
                    $listAppointment = $this->getAppointmentsByStartTime($bookingDate);
                    $smsSendingResult = Utilities::sendSMS($phone, "Cam on ban da dat lich kham, so kham cua ban la " . $result->numerical_order);
                    $smsDecode = json_encode($smsSendingResult);
                    Utilities::logInfo($smsDecode);
                    return response()->json($listAppointment, 200);
                } else {

                    $error = new \stdClass();
                    $error->error = "Đã quá giờ đặt lịch, bạn vui lòng chọn ngày khác";
                    $error->exception = "Result is null, No exception";
                    return response()->json($error, 400);
                }
            }
        }
    }

    public function quickBookAppointment(Request $request)
    {
        try {
            $error = new \stdClass();
            $phone = $request->input('phone');
            $note = $request->input('note');
            $bookingDate = $request->input('booking_date');
            $name = $request->input("name");
            $userExist = $this->checkExistUser($phone);
            if (!$userExist) {
                $user = new User();
                $patient = new Patient();
                $userHasRole = new UserHasRole();

                $user->phone = $phone;
                $user->password = Hash::make($phone);

                $patient->phone = $phone;
                $patient->name = $name;

                $userHasRole->phone = $phone;
                $userHasRole->role_id = 1;
                $registerPatientResult = $this->registerPatient($user, $patient, $userHasRole);
                $resgisterResult = $this->registerUser($user);
                if ($resgisterResult) {
                    Log::info("Appointment register user success");
                }
                if ($registerPatientResult) {
                    Log::info("Appointment register patient success");
                }
            } else {
                $bookingResult = $this->createAppointment($bookingDate, $phone, $note);
                if ($bookingResult != null) {
                    return response()->json($bookingResult, 200);
                } else {
                    $error->error = "Cannot save appointment, appointment is null";
                    $error->exception = "No exception";
                    return response()->json($error, 400);

                }


            }
        } catch (Exception $exception) {
            $error->error = "Get appointment null from server";
            $error->exception = "No exception";
            return response()->json($error, 400);
        }
    }
}