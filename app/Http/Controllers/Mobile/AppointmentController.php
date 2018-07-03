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
use Illuminate\Http\Request;
use App\Model\Appointment;
use App\Model\Patient;
use App\Model\UserHasRole;
use App\User;
use DateTime;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
//use SMSGatewayMe\Client\ApiException;

class AppointmentController extends Controller
{
    use AppointmentBussinessFunction;
    use UserBusinessFunction;


    public function getAll()
    {
        try {
            $appointment = $this->getAllAppointment();
            return $appointment;
        } catch (Exception $exception) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra";
            $error->exception = $exception;
            return response()->json($error, 400);
        }
    }

    public function getById($id)
    {
        try {
            Log::info("IDDDDDDDDDD " . $id);
            $appointment = $this->getAppointmentById($id);
            return response()->json($appointment, 200);
        } catch (Exception $exception) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra";
            $error->exception = $exception;
            return response()->json($error, 400);

        }
    }

    public function getByPhone($phone)
    {
        try {
            $appointments = $this->getAppointmentByPhone($phone);
            return response()->json($appointments, 200);
        } catch (Exception $exception) {
            $error = new \stdClass();
            $error->error = "Có lỗi xảy ra";
            $error->exception = $exception;
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
            $estimatedTime = $request->input('estimated_time');
            $result = $this->createAppointment($bookingDate, $phone, $note, $dentistId, $estimatedTime);
            if ($result != null) {
                $listAppointment = $this->getAppointmentsByStartTime($bookingDate);
                $startDateTime = new DateTime($result->start_time);
                $smsSendingResult = Utilities::sendSMS(
                    $phone, AppConst::getSmsMSG($result->numerical_order, $startDateTime)
                );
                $smsDecode = json_encode($smsSendingResult);
                Utilities::logDebug($smsDecode);
                return response()->json($listAppointment, 200);
            } else {
                $error = Utilities::getErrorObj("Đã quá giờ đặt lịch, bạn vui lòng chọn ngày khác",
                    "Result is null, No exception");
                return response()->json($error, 400);
            }

        } catch (ApiException $e) {
            $error = Utilities::getErrorObj("Lỗi server", $e->getMessage());
            return response()->json($error, 400);
        }catch (\Exception $ex){
            $error = Utilities::getErrorObj("Lỗi server", $ex->getMessage());
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
        if ($this->getAppointmentByDate($phone, $oldBookingDate) && $this->checkExistUser($phone)) {
            $error = Utilities::getErrorObj("Bạn đã đặt lịch ngày " . $bookingDate . ' vui lòng kiểm tra lại tin nhắn',
                "No exception");
            return response()->json($error, 400);
        } else {
            $result = $this->createAppointment($bookingDate, $phone, $note, null, null);
            if ($result != null) {
                $listAppointment = $this->getAppointmentsByStartTime($bookingDate);
                $smsSendingResult = Utilities::sendSMS($phone, "Cam on ban da dat lich kham, so kham cua ban la " . $result->numerical_order);
                $smsDecode = json_encode($smsSendingResult);
                Utilities::logDebug($smsDecode);
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