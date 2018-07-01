<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 12-Jun-18
 * Time: 21:13
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Appointment;
use App\Model\Staff;
use App\User;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

trait AppointmentBussinessFunction
{


    public function getAllAppointment()
    {
        $appointments = Appointment::orderBy('start_time', 'desc')->get();

        return $appointments;
    }

    public function getAppointmentByPhone($phone)
    {
        $appointments = Appointment::where('phone', $phone)
            ->orderBy('start_time', 'desc')->get();
        return $appointments;
    }

    public function getAppointmentById($id)
    {
        $appointment = Appointment::where('id', $id)->first();
        return $appointment;
    }

    public function getAppointmentsByStartTime($startTime)
    {
        $appointments = Appointment::whereDate('start_time', $startTime)->get();

        return $appointments;
    }

    public function createAppointment($bookingDate, $phone, $note, $dentistId, $estimatedTime)
    {
        $NUM_OF_DENTIST = 3;
        try {
            $suitableDentistId = -1;
            $listDentist = $this->getAvailableDentist((new \DateTime())->format('Y-m-d'));
            $bookingDateNewFormat = (new \DateTime($bookingDate))->format("Y-m-d");
            $listAppointment = $this->getAppointmentsByStartTime($bookingDateNewFormat);
            $predictAppointmentDate = new \DateTime();
            $bookingDateObj = new \DateTime($bookingDate);
            $appointmentArray = $listAppointment->toArray();
            usort($appointmentArray, array($this, "sortByTimeStamp"));
            if ($listAppointment->count() < $NUM_OF_DENTIST) {
                // kieu j cung co loi
                if ($dentistId == null) {
                    $this->logDebug("INTO COUNT< NUMMOF DENTIST ___ Dentistt id = null");
                    $predictAppointmentDate = $this->addTimeToDate($bookingDateObj, "07:00:00");
                    $listFreeDentists = $this->getFreeDentistsAtDate($bookingDateNewFormat);
                    $randomDentist = $this->getRandomDentist($listFreeDentists);
                    $suitableDentistId = $randomDentist->id;
                } else {///neu nguoi dat la bac si
                    $this->logDebug("INTO COUNT< NUMMOF DENTIST ___ Dentistt id != null");
                    $suitableDentistId = $dentistId;
                    $dentistAppointment = null;
                    //lay ra lich cuoi cung cua bac si, vi lich nay chi co 1 hang nen trich tu list ra luon
                    foreach ($appointmentArray as $appointment) {
                        if ($appointment['staff_id'] == $dentistId) {
                            $dentistAppointment = $appointment;
                            break;
                        }
                    }
                    $predictAppointmentDate = $this->getNextStartTime($dentistAppointment);
                }
            } else {
                if ($dentistId == null) {
                    $this->logDebug("INTO COUNT >= NUMMOF DENTIST ___ Dentistt id == null");
                    $topElement = $this->getAppointmentOnTop($appointmentArray, $NUM_OF_DENTIST);
                    $equallyAppointment = [];
                    $equallyAppointment[] = $topElement[0];
                    $this->arrangeEquallyAppointment($equallyAppointment, $topElement, 1);
                    if (count($equallyAppointment) > 1) {
                        $this->logDebug("INTO COUNT EQUALLY > 1");
                        $appointment = $this->getRandomAppointment($equallyAppointment);
                        $predictAppointmentDate = $this->getNextStartTime($appointment);
                        $suitableDentistId = $appointment['staff_id'];
                    } else {
                        $this->logDebug("INTO COUNT EQUALLY == 1");
                        $maxdate = new \DateTime("2035-12-12");
                        $minTimeStamp = $maxdate->getTimestamp() + $maxdate->getTimestamp();
                        $minAppointment = array();
                        foreach ($topElement as $item) {
                            $appointmentTimeStamp = $this->getAppointmentTimeStamp($item);
                            if ($appointmentTimeStamp < $minTimeStamp) {
                                $minTimeStamp = $appointmentTimeStamp;
                                $minAppointment = $item;
                            }
                        }
                        // $predictAppointmentDate= the finish datetime of the previous patient;
                        $minAppointmentStartDateTime = new \DateTime($minAppointment['start_time']);
                        $predictAppointmentDate = $this->addTimeToDate($minAppointmentStartDateTime,
                            $minAppointment['estimated_time']);
                        $suitableDentistId = $minAppointment['staff_id'];
                    }
                } else {
                    $this->logDebug("INTO COUNT >= NUMMOF DENTIST ___ Dentistt id != null");
                    $suitableDentistId = $dentistId;
                    $dentistAppointment = null;
                    //lay ra lich cuoi cung cua bac si, vi lich nay chi co 1 hang nen trich tu list ra luon
                    foreach ($appointmentArray as $appointment) {
                        if ($appointment['staff_id'] == $dentistId) {
                            $dentistAppointment = $appointment;
                            break;
                        }
                    }
                    $predictAppointmentDate = $this->getNextStartTime($dentistAppointment);
                }


                //if the predict time is in lunch break, add it to the afternoon start at 13h
            }
            if ($this->isInLunchBreak($predictAppointmentDate)) {
                $this->logDebug("IS in lunch");
                $predictAppointmentDate = new \DateTime($bookingDateNewFormat . ' 13:00:00');
            }else if($this->isEndOfTheDay($predictAppointmentDate)){
                $this->logDebug("isEndOfTheDay");
                return null;
            }
            if ($estimatedTime == null) {
                $estimatedTime = new \DateTime("00:30");
            }
            $numericalOrder = $listAppointment->count() + 1;

            $appointment = new Appointment();
            $appointment->phone = $phone;
            $appointment->note = $note;
            $appointment->estimated_time = $estimatedTime->format("H:i:s");
            $appointment->start_time = $predictAppointmentDate->format("Y-m-d H:i:s");
            $appointment->numerical_order = $numericalOrder;
            $appointment->staff_id = $suitableDentistId;
            $appointment->save();
            return $appointment;
        } catch (Exception $exception) {
            $exception->getTrace();
            return null;
        }
    }

    public function getAppointmentOnTop($sortArrayAppointment, $numDentist)
    {
        $topAppointment = [];
        foreach ($sortArrayAppointment as $item) {
            if (count($topAppointment) == 0) {
                $topAppointment[] = $item;
            } else {
                $flag = true;
                foreach ($topAppointment as $top) {

                    $this->logDebug($top['id'] . '_____' . $top['staff_id'] . '==' . $item['staff_id']);
                    if ($top['staff_id'] == $item['staff_id']) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    $topAppointment[] = $item;
                    if (count($topAppointment) == $numDentist) {
                        $reverse = array_reverse($topAppointment);
                        return $reverse;
                    }
                }
            }
        }
        return null;
    }

    public function getNextStartTime($appointment)
    {
        if ($appointment == null) {
            return null;
        }
        $startTime = new \DateTime($appointment['start_time']);
        $estimatedTime = ($appointment['estimated_time']);
        $intervalTime = new \DateInterval('P0000-00-00T' . $estimatedTime);
        return $this->addTimeToDate($startTime, $estimatedTime);
    }

    private function arrangeEquallyAppointment(&$equallyAppointment, $arrayAppointment, $index)
    {
        $this->logDebug('ccc');
        if ($index == count($arrayAppointment)) {
            return;
        }
        $currentAppointment = $arrayAppointment[$index - 1];
        $nextAppointment = $arrayAppointment[$index];
        $currentTimeStamp = $this->getAppointmentTimeStamp($currentAppointment);
        $nextTimeStamp = $this->getAppointmentTimeStamp($nextAppointment);

        if ($currentTimeStamp == $nextTimeStamp) {
            $equallyAppointment[] = $arrayAppointment[$index];
            $this->arrangeEquallyAppointment($equallyAppointment, $arrayAppointment, $index + 1);
        }
    }

    private function logDebug($message)
    {
        Log::info("LOG_DEBUG_Appointment: " . $message);
    }

    public function isInLunchBreak($appointmentEndDateTime)
    {
        $time = $appointmentEndDateTime->format('H:i:s');
        if ((strtotime($time) > strtotime('12:00:00'))
            && (strtotime($time) < strtotime('13:00:00'))) {
            return true;
        }
        return false;
    }

    public function isEndOfTheDay($appointmentEndDateTime)
    {
        $time = $appointmentEndDateTime->format('H:i:s');
        if ((strtotime($time) > strtotime('19:00:00'))) {
            return true;
        }
        return false;
    }

    private function getAppointments($dentistId, $date)
    {
        $dateNoTime = (new \DateTime($date))->format("Y-m-d");
        $appointments = Appointment::where('staff_id', $dentistId)
            ->where('start_time', $dateNoTime)
            ->get();
        return $appointments;
    }


    public function getFreeDentistsAtDate($date)
    {
        //get all dentist that works at that day
        $listAvailableDentists = $this->getAvailableDentist($date);
        $listFreeDentists = [];
        //find dentist that doesn't treat for patient at the first of the day
        foreach ($listAvailableDentists as $availableDentist) {
            if (!($this->isDentistBusy($availableDentist->id, $date))) {
                $listFreeDentists[] = $availableDentist;
            }
        }
        return $listFreeDentists;
    }

    public function isDentistBusy($dentistId, $date)
    {
        $appointments = $this->getAppointmentsByStartTime($date);
        foreach ($appointments as $appointment) {
            if ($appointment->staff_id == $dentistId) {
                return true;
            }
        }
        return false;
    }

    public function isExistDentistID($listAllDentist, $id)
    {
        foreach ($listAllDentist as $item) {
            if ($item->id == $id) {
                return true;
            }
            return false;
        }
    }

    public function getRandomDentist($arrayDentist)
    {
        $sizeList = sizeof($arrayDentist);
//        $this->logDebug($arrayDentist);
        $index = rand(0, $sizeList - 1);
        $randomDentist = $arrayDentist[$index];
        return $randomDentist;
    }

    public function getRandomAppointment($arrayAppointment)
    {
        $sizeList = sizeof($arrayAppointment);
        $index = rand(0, $sizeList - 1);
        $randomAppointment = $arrayAppointment[$index];
        return $randomAppointment;
    }

    private function getAvailableDentist($date)
    {
//        $roleDentist = 1;
//        $dentists = DB::table('tbl_staffs')
//            ->join('tbl_user_has_role', 'tbl_user_has_role.phone', 'tbl_staffs.phone')
//            ->join('tbl_request_absent', 'tbl_request_absent.staff_id', 'tbl_staffs.id')
//            ->where('tbl_user_has_role.role_id', $roleDentist)
//            ->where(function ($query) use ($date) {
//                $query
//                    ->where('tbl_request_absent.start_date', '>', $date)
//                    ->orWhere('tbl_request_absent.end_date', '<', $date);
//            })
//            ->distinct()
//            ->select('tbl_staffs.*')
//            ->get();
        $dentists = Staff::all();
        return $dentists;
    }

    private
    function getRandomDentistId($arrayAppointment)
    {
        $index = rand(0, sizeof($arrayAppointment));
        return $arrayAppointment[$index];
    }

    private
    function addTimeToDate($date, $time)
    {
        $intervalTime = new \DateInterval('P0000-00-00T' . $time);
        $date->add($intervalTime);
        return $date;
    }

    private
    function sortByTimeStamp($appointment1, $appointment2)
    {

        $timestampAP1 = $this->getAppointmentTimeStamp($appointment1);
        $timestampAP2 = $this->getAppointmentTimeStamp($appointment2);
        return $timestampAP1 < $timestampAP2;
    }

    /**
     * @param $appointment
     * @return total timestamp of booking date and estimate time
     */
    private
    function getAppointmentTimeStamp($appointment)
    {
        $dateTimeAppointment = new \DateTime($appointment['start_time']);
        $timeAppointment = new \DateTime($appointment['estimated_time']);
        $timestampAP = $dateTimeAppointment->getTimestamp() + $timeAppointment->getTimestamp();
        return $timestampAP;
    }

    public
    function getAppointmentOfUser($phone)
    {
        $listAppointment = User::where('phone', $phone)->first()->hasAppointment()->get();
        $max = 0;
        $result = false;
        foreach ($listAppointment as $appointment) {
            $dateTimeAppointment = new \DateTime($appointment['start_time']);
            if ($max < $dateTimeAppointment->getTimestamp()) {
                $result = $appointment;
            }
        }
        return $result;
    }
}