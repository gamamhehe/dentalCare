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

    public function getAppointmentByPhoneFutureClosest($phone)
    {
        $appointments = Appointment::where('phone', $phone)
            ->whereDate('start_time', '>=', Carbon::now()->format('Y-m-d'))->first();
        return $appointments;
    }

    public function getAppointmentByPhoneFuture($phone)
    {
        $appointments = Appointment::where('phone', $phone)
            ->whereDate('start_time', '>=', Carbon::now()->format('Y-m-d'))->get();
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

    public function attachFieldAppointment($appointment)
    {
        $appointment->dentist = $appointment->belongsToStaff()->first();
        $patientAppointment = $appointment->hasPatientOfAppointment()->first();;
        if ($patientAppointment != null) {
            $appointment->patient = $patientAppointment->belongsToPatient()->first();
        } else {
            $appointment->patient = null;
        }
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
     * @param null $status
     * @return Appointment[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|null
     */
    public function getUserAppointmentByDate($phone, $dateStr, $status = null)
    {
        $result = null;
        if ($status == null) {
            $result = Appointment::where('phone', $phone)
                ->whereDate('start_time', $dateStr)
                ->where('status', '!=', 4)
                ->orderBy('start_time', 'asc')
                ->get();
        } else {
            $result = Appointment::where('phone', $phone)
                ->whereDate('start_time', $dateStr)
                ->whereDate('status', $status)
                ->orderBy('start_time', 'asc')
                ->get();
        }
        return $result;
    }

    public function getAppointmentByDate($dateStr)
    {
        $result = Appointment::where('status', '!=', 4)
            ->whereDate('start_time', $dateStr)
            ->orderBy('start_time', 'asc')
            ->get();
        return $result;
    }

    /**
     * @param $bookingDate format: Y-m-d (ex: 2018-12-20)
     * @param $phone : 11 digits
     * @param $note
     * @param $dentistId
     * @param $patientId
     * @param $estimatedTimeStr
     * @param $name
     * @return Appointment|mixed|null
     * @throws \Exception
     */
    public function createAppointment($bookingDate, $phone, $note, $dentistId, $patientId, $estimatedTimeStr, $name, $allowOvertime = false)
    {
        DB::beginTransaction();
        try {
            $this->logBugAppointment("                                 ");
            $this->logBugAppointment("Begin createAppointment");
            $suitableDentistId = -1;
            $defaultEstimatedTime = "00:30";
            $defaultStartOfDay = "07:00:00";
            $defaultStartAfternoon = ' 13:00:00';
            $maxDateInStr = "2035-12-12";
            $bookingDateObj = new \DateTime($bookingDate);
            $bookingDateDBFormat = $bookingDateObj->format("Y-m-d");
            $listDentist = $this->getAvailableDentistAtDate($bookingDateDBFormat);
            $NUM_OF_DENTIST = count($listDentist);
            $this->logBugAppointment('NUM_DENTIST' . $NUM_OF_DENTIST);
            $listAppointment = $this->getAppointmentsByStartTime($bookingDateDBFormat);
            $dentistObj = $this->getStaffById($dentistId);
            $predictAppointmentDate = new \DateTime();
            $appointmentArray = $this->getListTopAppointment($listDentist, $bookingDateDBFormat);
            //sort descendent
            usort($appointmentArray, array($this, "sortByTimeStamp"));
            //'if statement' return the $predictAppointmentDate and $suitableDentistId for the code below it
            if (count($appointmentArray) < $NUM_OF_DENTIST) {
                if ($dentistId == null || $dentistId == 0) {
                    $this->logBugAppointment("INTO COUNT< NUMMOF DENTIST ___dentistId = null");
                    $predictAppointmentDate = $this->addTimeToDate($bookingDateObj, $defaultStartOfDay);
                    $listFreeDentists = $this->getFreeDentistsAtDate($listDentist, $bookingDateDBFormat);
                    $randomDentist = $this->getRandomDentist($listFreeDentists);
                    $suitableDentistId = $randomDentist->id;
                    $this->logBugAppointment('id of free dentist: ' . $randomDentist);
                } else if ($dentistId != null && $dentistObj == null) {//cannot find dentist
                    $this->logBugAppointment("Num apppointment < num dentist cannot find dentist obj in database");
                    return null;
                } else if ($dentistId != null && $dentistObj != null
                    && $this->isDentistAbsent($dentistObj, $bookingDateDBFormat)) {
                    $this->logBugAppointment("Num apppointment < num dentist ___dentistId != null, Dentist absent");
                    return null;
                } else {///neu nguoi dat la bac si
                    $this->logBugAppointment("Num apppointment < num dentist nguoi dat la bac si");
                    $suitableDentistId = $dentistId;
                    //lay ra lich cuoi cung cua bac si, vi lich nay chi co 1 hang nen trich tu list ra luon
                    $dentistAppointment = $this->getLastestAppointment($bookingDateDBFormat, $dentistId);
                    if ($dentistAppointment == null) {
                        $predictAppointmentDate = $this->addTimeToDate($bookingDateObj, "07:00:00");
                    } else {
                        $predictAppointmentDate = $this->getNextStartTime($dentistAppointment);
                    }
                }
            } else {
                if ($dentistId == null || $dentistObj == null || $dentistId == 0) {
                    $this->logBugAppointment("INTO COUNT >= NUMMOF DENTIST ___ Dentistt id == null");
                    $equallyAppointment = [];
                    $equallyAppointment[] = $appointmentArray[0];
                    $this->arrangeEquallyAppointment($equallyAppointment, $appointmentArray, 1);
                    if (count($equallyAppointment) > 1) {
                        $this->logBugAppointment("INTO COUNT EQUALLY > 1");
                        $appointment = $this->getRandomAppointment($equallyAppointment);
                        $predictAppointmentDate = $this->getNextStartTime($appointment);
                        $suitableDentistId = $appointment['staff_id'];
                    } else {
                        $maxdate = new \DateTime($maxDateInStr);
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
                        $this->logBugAppointment("INTO COUNT EQUALLY == 1" . "Min ApptID: " . $minAppId . " MinApp startTime: " . $minAppointment['start_time']);

                        // $predictAppointmentDate= the finish datetime of the previous patient;
                        $minAppointmentStartDateTime = new \DateTime($minAppointment['start_time']);
                        $predictAppointmentDate = $this->addTimeToDate($minAppointmentStartDateTime,
                            $minAppointment['estimated_time']);
                        $suitableDentistId = $minAppointment['staff_id'];
                    }
                } else if ($dentistId != null && $dentistObj == null) {
                    $this->logBugAppointment("Num apppointment < num dentist ___dentistId != null but cannot find dentist object in databse");
                    return null;
                } else if ($dentistId != null && $dentistObj != null
                    && $this->isDentistAbsent($dentistObj, $bookingDateDBFormat)) {
                    $this->logBugAppointment("Num apppointment < num dentist ___dentistId != null, Dentist absent");
                    return null;
                } else {
                    $this->logBugAppointment("INTO COUNT >= NUMMOF DENTIST ___ Dentistt id != null");
                    $suitableDentistId = $dentistId;
                    $dentistAppointment = $this->getLastestAppointment($bookingDateDBFormat, $dentistId);
                    $predictAppointmentDate = $this->getNextStartTime($dentistAppointment);
                }
                //if the predict time is in lunch break, add it to the afternoon start at 13h
            }
            ////////////////////////////VALIDATE START_TIME - variable: $predictAppointmentDate //////////////////////////////
            $estimatedTimeObj = new \DateTime($defaultEstimatedTime);
            if ($estimatedTimeStr != null) {
                $estimatedTimeObj = new DateTime($estimatedTimeStr);
            }
            $currentDateTime = new DateTime();
            //process when patient book appointment at the same day, and
//            $diffDate = ($currentDateTime->diff($predictAppointmentDate));
            if (($currentDateTime->getTimestamp() - $predictAppointmentDate->getTimeStamp()) > 0
                && !$this->isEndOfTheDay($currentDateTime)
                && !$this->isInEarlyDay($currentDateTime)
            ) {
//                $predictAppointmentDate = $this->addTimeToDate($currentDateTime, '00:10:00');
                $predictAppointmentDate = $currentDateTime;
                $arrayFreeDentist = $this->getFreeDentistsAtDate($listDentist, $bookingDateDBFormat);
                if (count($arrayFreeDentist) == 0) {
                    $randomDentist = $this->getRandomDentist($listDentist);
                } else {
                    $randomDentist = $this->getRandomDentist($arrayFreeDentist);
                }
                $suitableDentistId = $randomDentist['id'];
                $this->logBugAppointment("Predict appointment time before currentime (book appointment at currenday)"
                    . $predictAppointmentDate->format('Y-m-d H:i:s'));
            }
            $tmpPredictTime = clone $predictAppointmentDate;
            $endAppointmentTimeObj = $this->addTimeToDate($tmpPredictTime, $estimatedTimeObj->format("H:i:s"));
            if ($this->isInLunchBreak($predictAppointmentDate, $endAppointmentTimeObj)) {
                $this->logBugAppointment("IS in lunch");
                $predictAppointmentDate = new \DateTime($bookingDateDBFormat . $defaultStartAfternoon);
            } else if ($this->isEndOfTheDay($endAppointmentTimeObj) && !$allowOvertime) {
                $this->logBugAppointment("isEndOfTheDay: end time is: " . $endAppointmentTimeObj->format('H:i:s'));
                throw new \Exception ('isEndOfTheDay');
            }
            $listAppointmentToday = $this->getAppointmentsByStartTime($bookingDateDBFormat);
            $numericalOrder = $listAppointmentToday->count() + 1;
            $appointment = new Appointment();
            $appointment->lockForUpdate();
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
            DB::commit();
            $this->logBugAppointment("New appointment id" . ($appointment->id));
            $this->logBugAppointment("End createAppointment");
            return $appointment;
        } catch (Exception $exception) {
            $exception->getTrace();
            DB::rollback();
            return null;
        }
    }

    public function AppointmentOfPatient($patient_id, $appointment_id)
    {
        DB::beginTransaction();
        try {
            $patientAppointment = new PatientOfAppointment();
            $patientAppointment->appointment_id = $appointment_id;
            $patientAppointment->patient_id = $patient_id;
            $patientAppointment->save();
            DB::commit();
            return true;
        } catch (Exception $exception) {
            $exception->getTrace();
            DB::rollback();
            return null;
        }
    }

    public function updateStatusAppoinment($status, $appointment_id)
    {
        DB::beginTransaction();
        try {
            $appointment = Appointment::find($appointment_id);
            $appointment->status = $status;
            $appointment->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

        }

    }

    public function updateDentistAppoinment($id, $appointment_id)
    {
        DB::beginTransaction();
        try {
            $appointment = Appointment::find($appointment_id);
            $appointment->staff_id = $id;
            $appointment->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;

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

    public function attachTopAppointmentForDentist($listAvailableDentist, $dateStr)
    {
        foreach ($listAvailableDentist as $dentist) {
            $tmp = $this->getLastestAppointment($dateStr, $dentist->id);
            if ($tmp != null) {
                $dentist->appointment = $tmp;
            } else {
                $dentist->appointment = null;
            }
        }
        return $listAvailableDentist;
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
        foreach ($appointments as $appointment) {
            $appointment->patient = $appointment->hasPatientOfAppointment()->first();
        }
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

    private function logBugAppointment($message)
    {
        Log::info($message);
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

    private function isInLunchBreak($apptStartTime, $apptFinishTime)
    {
        $startTime = $apptStartTime->format('H:i:s');
        $endTime = $apptFinishTime->format('H:i:s');

        if (((strtotime($endTime) >= strtotime('12:15:00'))
                && (strtotime($endTime) <= strtotime('13:00:00'))
                && (strtotime($startTime) <= strtotime('12:00:00')))
            || ((strtotime($endTime) <= strtotime('13:00:00'))
                && (strtotime($startTime) >= strtotime('12:00:00')))
            || ((strtotime($endTime) >= strtotime('13:00:00'))
                && (strtotime($startTime) >= strtotime('12:00:00'))
                && (strtotime($startTime) <= strtotime('13:00:00'))
            )
            || ((strtotime($endTime) >= strtotime('13:00:00'))
                && (strtotime($startTime) <= strtotime('12:00:00')))
        ) {
            return true;
        }
        return false;
    }

    public function isEndOfTheDay($apptFinishTimeObj)
    {
        $time = $apptFinishTimeObj->format('H:i:s');
        if ((strtotime($time) > strtotime('19:15:00'))) {
            return true;
        }
        return false;
    }

    public function isInEarlyDay($apptFinishTimeObj)
    {
        $time = $apptFinishTimeObj->format('H:i:s');
        if ((strtotime($time) >= strtotime('00:00:00')) && (strtotime($time) < strtotime('07:00:00'))) {
            return true;
        }
        return false;
    }

    public function isInThePast($apptFinishTimeObj)
    {
        $date = $apptFinishTimeObj->format('Y-m-d');
        if ((strtotime($date) < strtotime('00:00:00'))) {
            return true;
        }
        return false;
    }

    public function updateAppointment($appointment)
    {
        try {
            $appointment->save();
            return true;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
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

    private function getFreeDentistsAtDate($listAvailableDentists, $dateStr)
    {
        //get all dentist that works at that day
//        $listAvailableDentists = $this->getAvailableDentistAtDate($date);
        $listFreeDentists = [];
        $appointments = $this->getAppointmentsByStartTime($dateStr);
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
//        $this->logBugAppointment($arrayDentist);
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

    public function getAvailableDentistAtDate($dateStr)
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
            if (!$this->isDentistAbsent($dentist, $dateStr)) {
                $availableDentist[] = $dentist;
            }
        }
        return $availableDentist;
    }

    /**
     * @param $dentist
     * @param $dateStr Ex: 2018-10-20
     * @return bool
     */
    public function isDentistAbsent($dentistObj, $dateStr)
    {
        $dentistRequestAbsent = $dentistObj->hasAbsent()
            ->whereDate('start_date', $dateStr)
            ->first();
        if ($dentistRequestAbsent != null) {
            $absentRecord = $dentistRequestAbsent->hasAbsent()->first();
            if ($absentRecord != null && $absentRecord->is_approved == 1) {
                return true;
            } else {
                return false;
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
        return $timestampAP1 > $timestampAP2;
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
                return $appointment;
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
                dd($listIdAppointmentNullPatient);
                return null;
            } else {
                foreach ($listIdAppointmentNullPatient as $appointmentNullPatient) {
                    $appointment = Appointment::where('id', $appointmentNullPatient)->first();
                    return $appointment;
                }
            }
        }
    }

    public function viewAppointmentForDentist($dentist_id)
    {
        return Appointment::where('staff_id', $dentist_id)
            ->get();
    }

    public function viewAppointmentInDateForDentist($dentist_id)
    {
//
        $dateString = Carbon::now()->format('Y-m-d');
        $newDate = date('Y-m-d', strtotime('+1 day', strtotime($dateString)));
        return Appointment::where('staff_id', $dentist_id)
            ->where('start_time', '>', Carbon::now()->format('Y-m-d'))
            ->where('start_time', '<', $newDate)
            ->get();
    }

    public
    function viewAppointmentForReception()
    {
        return Appointment::all();
    }

    public
    function viewAppointmentInDateForReception()
    {
        $dateString = Carbon::now()->format('Y-m-d');
        $newDate = date('Y-m-d', strtotime('+1 day', strtotime($dateString)));
        return Appointment::where('start_time', '>', Carbon::now()->format('Y-m-d'))
            ->where('start_time', '<', $newDate)
            ->get();
    }

    public
    function getCurrentFreeDentist()
    {
        $listAvailableDentist = $this->getAvailableDentistAtDate(Carbon::now());
        $listCurrentBusyAppointment = Appointment::whereDate('start_time', (new DateTime())->format('Y-m-d'))
            ->where('status', 2)->get();
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
        return count(Appointment::where('staff_id', $staff_id)->where('status', 1)->where('start_time', '>', Carbon::now()->format('Y-m-d'))->get());
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

    public function checkDoneAppointment($appointmentId)
    {
        $appointment = Appointment::where('id', $appointmentId)->first();
        if ($appointment->status == 2) {
            $appointment->status = 3;
            $appointment->save();
            return 1;
        }
        return 0;
    }

    public function startAppointment($id)
    {
        $appointment = Appointment::where('id', $id)->first();
        $appointment->status = 2;
        $appointment->save();
    }

    public function getOverdueAppointment($numDate)
    {
        $dateAgoObj = (new \DateTime())->modify('-' . $numDate . ' day');
        $appointmentAgo = Appointment::where('start_time', $dateAgoObj->format('Y-m-d'))
            ->where('status', 0)->get();


    }

    public function isHavingFreeSlotAtDate($dateStr)
    {
        $availableDentist = $this->getAvailableDentistAtDate($dateStr);
        $this->attachTopAppointmentForDentist($availableDentist, $dateStr);
        foreach ($availableDentist as $dentist) {
            $appointment = $dentist->appointment;
            if ($appointment == null) {
                return true;
            }
            $endApptTimeObj = new DateTime($appointment->start_time);
            $this->addTimeToDate($endApptTimeObj, $appointment->estimated_time);
            $endDayTimeObj = new DateTime($dateStr . ' 19:15:00');
            $diff = ($endDayTimeObj->diff($endApptTimeObj));
            if ($diff->i > 30) {
                return true;
            }
        }
        return false;
    }

    public function getUserNumAppointmentAtDate($phone, $dateStr)
    {
        $numAppointment = Appointment::where('phone', $phone)
            ->whereDate('start_time', $dateStr)
            ->count('id');
        return $numAppointment;
    }

    public function isMaxAppointmentAtDate($phone, $dateStr)
    {
        $numAppointment = $this->getUserNumAppointmentAtDate($phone, $dateStr);
        $this->logBugAppointment("NUM APPOINTMENT " . $numAppointment);
        if ($numAppointment > 5) {
            return true;
        }
        return false;
    }
}