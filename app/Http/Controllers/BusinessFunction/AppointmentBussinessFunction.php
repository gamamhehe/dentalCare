<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 12-Jun-18
 * Time: 21:13
 */

namespace App\Http\Controllers\BusinessFunction;


use App\Model\Appointment;
use App\Model\PatientOfAppointment;
use App\Model\Staff;
use App\Model\UserHasRole;
use App\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Carbon\Carbon;

trait AppointmentBussinessFunction
{


    use StaffBusinessFunction;

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

    /**
     * @param $phone
     * @param $date
     * @return List Appointment
     */
    public function getAppointmentByDate($phone, $date)
    {
        $result = Appointment::where('phone', $phone)
            ->whereDate('start_time', $date)->get();
        return $result;
    }

    public function createAppointment($bookingDate, $phone, $note, $dentistId, $patientId, $estimatedTimeStr, $name)
    {
        print_r('bookingDate--' . $bookingDate . "-phone-" . $phone . "-note-" . $note . "-dentistId-" . $dentistId . "-patientId-" . $patientId . "-estimatedTimeStr-" . $estimatedTimeStr . "-name-" . $name . "--");
        exit();
        DB::beginTransaction();
        try {
            $suitableDentistId = -1;
            $defaultEstimatedTime = "00:30";
            $defaultStartOfDay = "07:00:00";
            $defaultStartAfternoon = ' 13:00:00';
            $listDentist = $this->getAvailableDentistAtDate((new \DateTime())->format('Y-m-d'));
            $NUM_OF_DENTIST = count($listDentist);
            $this->logDebug('NUM_DENTIST' . $NUM_OF_DENTIST);
            $bookingDateNewFormat = (new \DateTime($bookingDate))->format("Y-m-d");
            $listAppointment = $this->getAppointmentsByStartTime($bookingDateNewFormat);
            $dentistObj = $this->getStaffById($dentistId);
            $this->logDebug(($dentistObj == null) ?
                ("DENTIST OBJ ID" . $dentistId . ' NULL') :
                "DENTIST OBJ NOT NULL");
            $predictAppointmentDate = new \DateTime();
            $bookingDateObj = new \DateTime($bookingDate);
            $appointmentArray = $this->getListTopAppointment($listDentist, $bookingDate);
            //sort descendent
            usort($appointmentArray, array($this, "sortByTimeStamp"));
            //'if statement' return the $predictAppointmentDate and $suitableDentistId for the code below it
            if (count($appointmentArray) < $NUM_OF_DENTIST) {
                // kieu j cung co loi
                if ($dentistId == null || $dentistId == 0) {
                    $this->logDebug("INTO COUNT< NUMMOF DENTIST ___dentistId = null");
                    $predictAppointmentDate = $this->addTimeToDate($bookingDateObj, $defaultStartOfDay);
                    $listFreeDentists = $this->getFreeDentistsAtDate($listDentist, $bookingDateNewFormat);
                    $randomDentist = $this->getRandomDentist($listFreeDentists);
                    $suitableDentistId = $randomDentist->id;
                } else if ($dentistId != null && $dentistObj == null) {//cannot find dentist
                    $this->logDebug("INTO COUNT < NUMMOF DENTIST ___dentistId != null but cannot find dentist object in databse");
                    return null;
                } else if ($dentistId != null && $dentistObj != null
                    && $this->isDentistAbsent($dentistObj, $bookingDateNewFormat)) {
                    $this->logDebug("INTO COUNT < NUMMOF DENTIST ___dentistId != null, Dentist absent");
                    return null;
                } else {///neu nguoi dat la bac si
                    $this->logDebug("INTO COUNT< NUMMOF DENTIST ___dentistId != null");
                    $suitableDentistId = $dentistId;
                    //lay ra lich cuoi cung cua bac si, vi lich nay chi co 1 hang nen trich tu list ra luon
                    $dentistAppointment = $this->getLastestAppointment($bookingDate, $dentistId);
                    if ($dentistAppointment == null) {
                        $predictAppointmentDate = $this->addTimeToDate($bookingDateObj, "07:00:00");
                    } else {
                        $predictAppointmentDate = $this->getNextStartTime($dentistAppointment);
                    }
                }
            } else {
                if ($dentistId == null || $dentistObj == null || $dentistId == 0) {
                    $this->logDebug("INTO COUNT >= NUMMOF DENTIST ___ Dentistt id == null");
                    $equallyAppointment = [];
                    $equallyAppointment[] = $appointmentArray[0];
                    $this->arrangeEquallyAppointment($equallyAppointment, $appointmentArray, 1);
                    if (count($equallyAppointment) > 1) {
                        $this->logDebug("INTO COUNT EQUALLY > 1");
                        $appointment = $this->getRandomAppointment($equallyAppointment);
                        $predictAppointmentDate = $this->getNextStartTime($appointment);
                        $suitableDentistId = $appointment['staff_id'];
                    } else {
                        $maxdate = new \DateTime("2035-12-12");
                        $minTimeStamp = $maxdate->getTimestamp() + $maxdate->getTimestamp();
                        $minAppointment = array();
                        foreach ($appointmentArray as $item) {
                            $appointmentTimeStamp = $this->getAppointmentTimeStamp($item);
                            if ($appointmentTimeStamp < $minTimeStamp) {
                                $minTimeStamp = $appointmentTimeStamp;
                                $minAppointment = $item;
                            }
                        }
                        $minAppId = $minAppointment->id;
                        $this->logDebug("INTO COUNT EQUALLY == 1" . "Min ApptID: " . $minAppId . " MinApp startTime: " . $minAppointment['start_time']);

                        // $predictAppointmentDate= the finish datetime of the previous patient;
                        $minAppointmentStartDateTime = new \DateTime($minAppointment['start_time']);
                        $predictAppointmentDate = $this->addTimeToDate($minAppointmentStartDateTime,
                            $minAppointment['estimated_time']);
                        $suitableDentistId = $minAppointment['staff_id'];
                    }
                } else if ($dentistId != null && $dentistObj == null) {
                    $this->logDebug("INTO COUNT < NUMMOF DENTIST ___dentistId != null but cannot find dentist object in databse");
                    return null;
                } else if ($dentistId != null && $dentistObj != null
                    && $this->isDentistAbsent($dentistObj, $bookingDateNewFormat)) {
                    $this->logDebug("INTO COUNT < NUMMOF DENTIST ___dentistId != null, Dentist absent");
                    return null;
                } else {
                    $this->logDebug("INTO COUNT >= NUMMOF DENTIST ___ Dentistt id != null");
                    $suitableDentistId = $dentistId;
                    $dentistAppointment = $this->getLastestAppointment($bookingDate, $dentistId);
                    $predictAppointmentDate = $this->getNextStartTime($dentistAppointment);
                }
                //if the predict time is in lunch break, add it to the afternoon start at 13h
            }
            ////////////////////////////VALIDATE START_TIME - variable: $predictAppointmentDate //////////////////////////////
            $estimatedTimeObj = new \DateTime($defaultEstimatedTime);
            if ($estimatedTimeStr != null) {
                $estimatedTimeObj = new DateTime($estimatedTimeStr);
            }
            $tmpPredictTime = clone $predictAppointmentDate;
            $currentDateTime = new DateTime();
            //process when patient book appointment at the same day, and
            $diffDate = ($currentDateTime->diff($predictAppointmentDate));
            if (($currentDateTime->getTimestamp() - $predictAppointmentDate->getTimeStamp()) > 0) {
                $predictAppointmentDate = $this->addTimeToDate($currentDateTime, '00:10:00');
                $arrayFreeDentist = $this->getFreeDentistsFromTime($listDentist, $currentDateTime, $currentDateTime);
                $randomDentist = $this->getRandomDentist($arrayFreeDentist);
                $suitableDentistId = $randomDentist['id'];
                $this->logDebug("ZZZ");
            }
            $endAppointmentTime = $this->addTimeToDate($tmpPredictTime, $estimatedTimeObj->format("H:i:s"));
            if ($this->isInLunchBreak($endAppointmentTime) || $this->isInLunchBreak($predictAppointmentDate)) {
                $this->logDebug("IS in lunch");
                $predictAppointmentDate = new \DateTime($bookingDateNewFormat . $defaultStartAfternoon);
            } else if ($this->isEndOfTheDay($predictAppointmentDate)) {
                $this->logDebug("isEndOfTheDay");
                throw new \Exception ('isEndOfTheDay');
            }
            $this->logDebug("Num : " . $listAppointment->count());
            $numericalOrder = $listAppointment->count() + 1;
            $appointment = new Appointment();
            $appointment->phone = $phone;
            $appointment->note = $note;
            $appointment->estimated_time = $estimatedTimeObj->format("H:i:s");
            $appointment->start_time = $predictAppointmentDate->format("Y-m-d H:i:s");
            $appointment->numerical_order = $numericalOrder;
            $appointment->staff_id = $suitableDentistId;
            $appointment->name = $name;
            $appointment->save();
            if ($patientId != null) {
                $patientAppointment = new PatientOfAppointment();
                $patientAppointment->appointment_id = $appointment->id;
                $patientAppointment->patient_id = $patientId;
                $patientAppointment->save();
            }
            $this->logDebug("Id new appointment: " . ($appointment->id));
            DB::commit();
            return $appointment;
        } catch (Exception $exception) {

            $exception->getTrace();
            DB::rollback();
            return null;
        }
    }

    public function getListTopAppointment($listAvailableDentist, $dateStr)
    {
        $appoinements = [];
        foreach ($listAvailableDentist as $dentist) {
            $tmp = $this->getLastestAppointment($dateStr, $dentist->id);
            if ($tmp != null) {
                $appoinements[] = $tmp;
            }
        }
        return $appoinements;
    }

    private function getLastestAppointment($dateStr, $dentistId)
    {
        $appointment = Appointment::where('staff_id', $dentistId)
            ->whereDate('start_time', $dateStr)
            ->orderBy('start_time', 'desc')
            ->first();
        return $appointment;
    }

    public function getAppointmentsInMonth($dentistId, $yearInNumber, $monthInNumber)
    {
        $appointments = Appointment::where('staff_id', $dentistId)
            ->whereMonth('start_time', $monthInNumber)
            ->whereYear('start_time', $yearInNumber)
            ->get();
        return $appointments;
    }

    private function getNextStartTime($appointment)
    {
        if ($appointment == null) {
            return null;
        }
        $startTime = new \DateTime($appointment['start_time']);
        $estimatedTime = ($appointment['estimated_time']);
        return $this->addTimeToDate($startTime, $estimatedTime);
    }

    private function arrangeEquallyAppointment(&$equallyAppointment, $arrayAppointment, $index)
    {
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

    public function isUpCommingAppointment($currentDateObj, $appointmentDateObj)
    {

        $currentTimeStamp = $currentDateObj->getTimestamp();
        $apptTimeStamp = $appointmentDateObj->getTimestamp();
        if ($apptTimeStamp > $currentTimeStamp) {
            $diffTime = $currentDateObj->diff($appointmentDateObj);
            $hours = $diffTime->h;
            $minute = $diffTime->i;
            if ($hours == 0 && $minute >= 28 && $minute <= 30) {
                return true;
            }
        }
        return false;
    }

    private function isInLunchBreak($apptFinishTime)
    {
        $time = $apptFinishTime->format('H:i:s');
        if ((strtotime($time) > strtotime('12:15:00'))
            && (strtotime($time) < strtotime('13:00:00'))) {
            return true;
        }
        return false;
    }

    public function isEndOfTheDay($apptFinishTimeObj)
    {
        $time = $apptFinishTimeObj->format('H:i:s');
        if ((strtotime($time) > strtotime('19:00:00'))) {
            return true;
        }
        return false;
    }

    /**
     * @param $time
     * @return array dentist id int[]
     */
    public function getFreeDentistsFromTime($listAvailableDentist, $atDate, $fromTime)
    {

        $appointment = new Appointment();
        $appointments = $appointment
            ->whereDate(
                'start_time', '=', $atDate->format("Y-m-d"))
            ->where(
                'start_time', '>=', $fromTime->format("Y-m-d H:i:s")
            )
            ->get();
        if ($appointments->count() == 0) {
            return $listAvailableDentist;
        } else {
            $dentistArray = [];
            foreach ($listAvailableDentist as $dentist) {
                if (!$this->isDentistBusy($appointments, $dentist->id)) {
                    $dentistArray[] = $dentist;
                }
            }
            return $dentistArray;
        }
    }

    private function getFreeDentistsAtDate($listAvailableDentists, $date)
    {
        //get all dentist that works at that day
//        $listAvailableDentists = $this->getAvailableDentistAtDate($date);
        $listFreeDentists = [];
        $appointments = $this->getAppointmentsByStartTime($date);
        //find dentist that doesn't treat for patient at the first of the day
        foreach ($listAvailableDentists as $availableDentist) {
            if (!($this->isDentistBusy($appointments, $availableDentist->id))) {
                $listFreeDentists[] = $availableDentist;
            }
        }
        return $listFreeDentists;
    }

    private function isDentistBusy($appointments, $dentistId)
    {
        foreach ($appointments as $appointment) {
            if ($appointment->staff_id == $dentistId) {
                return true;
            }
        }
        return false;
    }

    private function getRandomDentist($arrayDentist)
    {
        $sizeList = sizeof($arrayDentist);
//        $this->logDebug($arrayDentist);
        $index = rand(0, $sizeList - 1);
        $randomDentist = $arrayDentist[$index];
        return $randomDentist;
    }

    private function getRandomAppointment($arrayAppointment)
    {
        $sizeList = sizeof($arrayAppointment);
        $index = rand(0, $sizeList - 1);
        $randomAppointment = $arrayAppointment[$index];
        return $randomAppointment;
    }

    public function getAvailableDentistAtDate($date)
    {
        $roleDentist = 2;
        $dentists = UserHasRole::where('role_id', $roleDentist)->get();
        $totalDentists = [];
        foreach ($dentists as $d) {
            $user = $d->belongsToUser()->first();
            if ($user != null) {
                $totalDentists[] = $user->belongToStaff()->first();
            }
        }
        $availableDentist = [];
        foreach ($totalDentists as $dentist) {
            if (!$this->isDentistAbsent($dentist, $date)) {
                $availableDentist[] = $dentist;
            }
        }
        return $availableDentist;
    }

    public function isDentistAbsent($dentist, $dateStr)
    {
        $dentistRequestAbsent = $dentist->hasAbsent()->get();
        if ($dentistRequestAbsent != null) {
            if ($dentistRequestAbsent->count() == 0) {
                return false;
            }
            foreach ($dentistRequestAbsent as $requestAbsent) {
                $approveAbsentRecord = $requestAbsent->hasAbsent()->first();
                if (strtotime($requestAbsent->start_date) <= strtotime($dateStr)
                    && strtotime($requestAbsent->end_date) >= strtotime($dateStr)
                    && $approveAbsentRecord != null) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $date
     * @param $time in string
     * @return mixed
     * @throws \Exception
     */
    private function addTimeToDate($date, $timeStr)
    {
        $intervalTime = new \DateInterval('P0000-00-00T' . $timeStr);
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

    public function getAppointmentOfUser($phone)
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

    public function getDentistApptAtDate($id, $date)
    {
        $appointments = Appointment::where('staff_id', $id)
            ->whereDate('start_time', $date)
            ->get();
        return $appointments;
    }

    public function saveAppointment($appointment, $patientId)
    {
        DB::beginTransaction();
        try {
            $appointment->save();
            $patientOfAppointment = PatientOfAppointment::where('appointment_id', $appointment->id)->first();
            if (!$patientOfAppointment) {
                PatientOfAppointment::create([
                    'appointment_id' => $appointment->id,
                    'patient_id' => $patientId
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function checkPatientIsExamination($idPatient)
    {
        $listAppointmentComing = Appointment::where('status', 2)->get();
        $listPatientIsExamination = [];
        foreach ($listAppointmentComing as $appointment) {
            $patientOfAppointment = PatientOfAppointment::where('appointment_id', $appointment->id)->first();
            if ($patientOfAppointment != null) {
                $listPatientIsExamination[] = $patientOfAppointment->patient_id;
            }
        }
        if (in_array($idPatient, $listPatientIsExamination)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkAppointmentForPatient($phone, $idPatient)
    {
        $listCurrentFreeDentist = $this->getCurrentFreeDentist();
        $listIdAppointmentOfPhone = Appointment::where('phone', $phone)
            ->whereDate('start_time', Carbon::now()->format('Y-m-d'))
            ->where('status', 0)
            ->pluck('id');
        if (count($listIdAppointmentOfPhone) == 0) {
            return null;
        } else {
            $AppointmentOfPatient = PatientOfAppointment::
            where('patient_id', $idPatient)
                ->whereIn('appointment_id', $listIdAppointmentOfPhone)
                ->first();
            if ($AppointmentOfPatient) {
                $appointment = Appointment::where('id', $AppointmentOfPatient->appointment_id)->first();
                if (in_array($appointment->staff_id, $listCurrentFreeDentist)) {
                    return $appointment;
                } else {
                    return false;
                }
            }
            $listIdAppointmentNullPatient = [];
            foreach ($listIdAppointmentOfPhone as $idAppointmentOfPhone) {
                $appointment_id = PatientOfAppointment::
                where('appointment_id', $idAppointmentOfPhone)
                    ->first();
                if (!$appointment_id) {
                    $listIdAppointmentNullPatient[] = $idAppointmentOfPhone;
                }
            }
            if (count($listIdAppointmentNullPatient) == 0) {
                return null;
            } else {
                foreach ($listIdAppointmentNullPatient as $appointmentNullPatient) {
                    $appointment = Appointment::where('id', $appointmentNullPatient)->first();
                    if (in_array($appointment->staff_id, $listCurrentFreeDentist)) {
                        return $appointment;
                    }
                }
                return false;
            }
        }
    }

    public function viewAppointmentForDentist($dentist_id)
    {
        return Appointment::where('staff_id', $dentist_id)
            ->where('start_time', '>=', Carbon::now()->format('Y-m-d'))
            ->get();
    }

    public
    function viewAppointmentForReception()
    {
        return Appointment::where('start_time', '>=', Carbon::now()->format('Y-m-d'))
            ->get();
    }

    public
    function getCurrentFreeDentist()
    {
        $listAvailableDentist = $this->getAvailableDentistAtDate(Carbon::now());
        $listCurrentBusyAppointment = Appointment::where('status', 2)->get();
        $listCurrentBusyDentist = [];
        foreach ($listCurrentBusyAppointment as $appointment) {
            $listCurrentBusyDentist[] = $appointment->staff_id;
        }
        $listCurrentFreeDentist = [];
        foreach ($listAvailableDentist as $dentist) {
            if (!in_array($dentist->id, $listCurrentBusyDentist)) {
                $listCurrentFreeDentist[] = $dentist->id;
            }
        }
        return $listCurrentFreeDentist;
    }

    public function checkAppointmentComing($appointmentId)
    {
        $appointment = Appointment::where('id', $appointmentId)->first();
        if ($appointment->status == 1) {
            $patient_id = PatientOfAppointment::where('appointment_id', $appointment->id)->first()->patient_id;
            return $patient_id;
        }
        return false;
    }

    public function getCurrentAppointmentComming($staff_id)
    {
        return count(Appointment::where('staff_id', $staff_id)->where('status', 1)->get());
    }

    public function checkAppointmentExistPatient($appointmentId)
    {
        $appointment = Appointment::where('id', $appointmentId)->first();
        $existPatient = PatientOfAppointment::where('appointment_id', $appointmentId)->first();
        if ($existPatient) {
            return ($existPatient->patient_id);
        } else {
            return 0;
        }

    }
}