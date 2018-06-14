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
        $bookingDate = $request->input('date_booking');
//        $phone = '01678589696';
//        $note = "nothiansdfoasdmf";
//        $bookingDate = "2018-06-13";
        $appointment = new Appointment();
        $appointment->phone = $phone;
        $appointment->note = $note;
        $appointment->date_booking = $bookingDate;

        $result = $this->createAppointment($appointment);
        if ($result != null) {
            return response()->json($result, 200);
        } else {

            $error = new \stdClass();
            $error->error = "Get appointment null from server";
            $error->exception = "No exception";
            return response()->json($error, 400);
        }
    }

    public function quickBookAppointment(Request $request)
    {
        $error = new \stdClass();
        $phone = $request->input('phone');
        $note = $request->input('note');
        $bookingDate = $request->input('date_booking');
        $appointment = new Appointment();
        $appointment->phone = $phone;
        $appointment->note = $note;
        $appointment->date_booking = $bookingDate;

        $name = $request->input("name");
        $user = new User();
        $user->phone = $phone;
        $user->name = $name;
        $resgisterResult = $this->registerUser($user);
        if (strcmp($resgisterResult, "SUCCESS") ||
            strcmp($resgisterResult, "USER_IS_EXIST")) {

            $bookingResult = $this->createAppointment($appointment);
            if ($bookingResult != null) {
                return response()->json($bookingResult, 200);
            } else {
                $error->error = "Cannot save appointment, appointment is null";
                $error->exception = "No exception";
                return response()->json($error, 400);
            }
        } else {
            $error->error = "Get appointment null from server";
            $error->exception = "No exception";
            return response()->json($error, 400);
        }
    }


}