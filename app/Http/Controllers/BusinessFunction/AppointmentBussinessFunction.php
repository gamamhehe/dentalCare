<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 12-Jun-18
 * Time: 21:13
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Appointment;
use App\Providers\AppServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

trait AppointmentBussinessFunction
{


    public function getAllAppointment()
    {
        $appointments = Appointment::orderBy('start_time','desc')->get();

        return $appointments;
    } public function getAppointmentByPhone($phone)
    {
        $appointments = Appointment::where('phone',$phone)->get();

        return $appointments;
    }

    public function getAppointmentById($id)
    {
        if ($id == null) {
            return null;
        } else {
            $appointment = Appointment::where('id', $id)->first();
            return $appointment;
        }
    }

    public function createAppointment($appointment)
    {
        $NUM_OF_DENTIST = 3;

        try {
            if ($appointment != null) {
                $appointmentDB = new Appointment();
                $dateBooking = (new \DateTime($appointment->date_booking))->format("Y-m-d");
                $listAppointment = $appointmentDB->where(
                    "date_booking", "=",
                    $dateBooking)->get();
//                    Carbon::today()->toDateString())->get();
                $predictAppointmentDate = new \DateTime();
                $estimatedTime = new \DateTime("00:30");
                $numericalOrder = $listAppointment->count() + 1;
                if ($listAppointment->count() < $NUM_OF_DENTIST) {
                    $bookingDateObj = new \DateTime($appointment->date_booking);
                    $predictAppointmentDate = $this->addTimeToDate($bookingDateObj, "07:00:00");
                } else {
                    $appointmentArray = $listAppointment->toArray();
                    usort($appointmentArray, array($this, "sortByTimeStamp"));
                    $topElement = array_slice($appointmentArray, 0, 3);
                    $maxdate = new \DateTime("2035-12-12");
                    $min = $maxdate->getTimestamp() + $maxdate->getTimestamp();
                    $minAppointment = array();
                    foreach ($topElement as $item) {
                        $appointmentTimeStamp = $this->getAppointmentTimeStamp($item);
                        if ($appointmentTimeStamp < $min) {
                            $min = $appointmentTimeStamp;
                            $minAppointment = $item;
                        }
                    }
                    // $predictAppointmentDate= the finish datetime of the previous patient;
                    $predictAppointmentDate = new \DateTime($minAppointment['start_time']);
//            $minAppointmentTime = new \DateTime($minAppointment['estimated_time']);
//            $intervalDate = $minAppointmentDate->diff(new \DateTime("00-00-00"))
                    $intervalTime = new \DateInterval('P0000-00-00T' . $minAppointment['estimated_time']);

                    $predictAppointmentDate->add($intervalTime);
                }
                $appointment->estimated_time = $estimatedTime->format("H:i:s");
                $appointment->start_time = $predictAppointmentDate->format("Y-m-d H:i:s");
                $appointment->numerical_order = $numericalOrder;
                $appointment->save();
                return $appointment;
            }
            return null;
        } catch (Exception $exception) {
//            $exception->getTrace();
            return null;
        }
    }

    private function addTimeToDate($date, $time)
    {
        $intervalTime = new \DateInterval('P0000-00-00T' . $time);
        $date->add($intervalTime);
        return $date;
    }

    private function sortByTimeStamp($appointment1, $appointment2)
    {

        $timestampAP1 = $this->getAppointmentTimeStamp($appointment1);
        $timestampAP2 = $this->getAppointmentTimeStamp($appointment2);
        return $timestampAP1 < $timestampAP2;
    }

    /**
     * @param $appointment
     * @return total timestamp of booking date and estimate time
     */
    private function getAppointmentTimeStamp($appointment)
    {
        $dateTimeAppointment = new \DateTime($appointment['start_time']);
        $timeAppointment = new \DateTime($appointment['estimated_time']);
        $timestampAP = $dateTimeAppointment->getTimestamp() + $timeAppointment->getTimestamp();
        return $timestampAP;
    }

}