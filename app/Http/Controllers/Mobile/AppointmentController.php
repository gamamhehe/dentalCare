<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 12-Jun-18
 * Time: 21:56
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Http\Controllers\Controller;
use App\Model\Appointment;
use App\Model\Patient;
use App\Model\UserHasRole;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

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
        $phone = $request->input('phone');
        $note = $request->input('note');
        $bookingDate = $request->input('booking_date');
        $result = $this->createAppointment($bookingDate, $phone, $note,null, null);
        if ($result != null) {
            $listAppointment = $this->getAppointmentByPhone($phone);
            return response()->json($listAppointment, 200);
        } else {

            $error = new \stdClass();
            $error->error = "Get appointment null from server";
            $error->exception = "No exception";
            return response()->json($error, 400);
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
                $user->password=Hash::make($phone);

                $patient->phone = $phone;
                $patient->name = $name;

                $userHasRole->phone = $phone;
                $userHasRole->role_id=1;
                $registerPatientResult =$this->registerPatient($user,$patient,$userHasRole);
                $resgisterResult = $this->registerUser($user);
                if ($resgisterResult) {
                    Log::info("Appointment register user success");
                }if ($registerPatientResult) {
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