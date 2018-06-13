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
use Mockery\Exception;

trait AppointmentBussinessFunction
{
    public function createAppointment($phone, $note, $datebooking)
    {
        try {
            $appointmentDB = new Appointment();
            $listAppointment = $appointmentDB->where(
                'date_booking', ">=",
                Carbon::today()->toDateString());

            usort($listAppointment->toArray(), "sortByTimeStamp");
            $topTenElement = $listAppointment->take(10);

            $min = PHP_INT_MAX;
            $minAppointment = new \stdClass();
            foreach ($topTenElement as $item) {
                $currentTimeStamp = $this->getAppointmentTimeStamp($item);
                if ($currentTimeStamp < $min) {
                    $min = $currentTimeStamp;
                    $minAppointment = $item;
                }
            }

            $minAppointmentDate = new \DateTime($minAppointment->date_booking);
            $minAppointmentTime = new \DateTime($minAppointment->estimated_time);

            $intervalTime = $minAppointmentTime->diff(new \DateTime("00:00:00"));

            $minAppointmentDate->add($intervalTime);

            $appointment = new Appointment();
            $appointment->phone = $phone;
            $appointment->note = $note;
            $appointment->date_booking = $minAppointmentDate;
            $appointment->estimated_time = new \DateTime("00:30");
            $appointment->numerical_order = $listAppointment->count();
//        ->format("Y-m-d H:i:s");

            $appointment->save();
            return $appointment;
        }catch (Exception $exception){
            return null;
        }
    }

    private function sortByTimeStamp($appointment1, $appointment2)
    {
//        $dateTimeAppointment1 = new \DateTime($appointment1->date_booking);
//        $timeAppointment1 = new \DateTime($appointment1->estimated_time);
////        $dateTimeAppointment2 = new \DateTime($appointment2->date_booking);
//        $timeAppointment2 = new \DateTime($appointment2->estimated_time);
//        $timestampAP1 = $dateTimeAppointment1->getTimestamp() + $timeAppointment1->getTimestamp();
//        $timestampAP2 = $dateTimeAppointment2->getTimestamp() + $timeAppointment2->getTimestamp();

        $timestampAP1 = $this->getAppointmentTimeStamp($appointment1);
        $timestampAP2 = $this->getAppointmentTimeStamp($appointment2);
        return $timestampAP1 > $timestampAP2;
    }

    private function getAppointmentTimeStamp($appointment)
    {
        $dateTimeAppointment = new \DateTime($appointment->date_booking);
        $timeAppointment = new \DateTime($appointment->estimated_time);
        $timestampAP = $dateTimeAppointment->getTimestamp() + $timeAppointment->getTimestamp();
        return $timestampAP;
    }

}