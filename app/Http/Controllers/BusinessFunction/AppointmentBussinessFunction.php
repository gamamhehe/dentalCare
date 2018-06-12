<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 12-Jun-18
 * Time: 21:13
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Appointment;

trait AppointmentBussinessFunction
{
    public function createAppointment($phone, $note, $datebooking)
    {
        $appointment = new Appointment();
        $appointment->phone = $phone;
        $appointment->note = $note;
        $appointment->date_booking = $datebooking;
        $appointment->save();
        return $appointment;
    }
}