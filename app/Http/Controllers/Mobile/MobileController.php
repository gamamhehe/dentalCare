<?php

namespace App\Http\Controllers\Mobile;

use App\Helpers\AppConst;
use App\Helpers\Utilities;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\RequestAbsentBusinessFunction;
use App\Http\Controllers\BusinessFunction\StaffBusinessFunction;
use App\Http\Controllers\BusinessFunction\TreatmentHistoryBusinessFunction;
use App\Jobs\ExcCustomFuncJob;
use App\Jobs\SendFirebaseJob;
use App\Jobs\SendReminderJob;
use App\Jobs\SendSmsJob;
use App\Model\AnamnesisPatient;
use App\Model\Appointment;
use App\Model\CustomObjectJob;
use App\Model\FirebaseToken;
use App\Model\Patient;
use App\Model\Staff;
use App\Model\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Model\SendMessageRequest;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Thread;

class MobileController extends BaseController
{

    use AppointmentBussinessFunction;

    /**
     *Dummy code to test laravel function
     * @GET
     * @param Request $request
     */
    public function test(Request $request)
    {
        $id = $request->query('id');
        $appointment = $this->getAppointmentById($id);
        if ($appointment != null) {
            $crrDate = new DateTime();
            $appDate = new DateTime($appointment->start_time);
            if ($this->isUpCommingAppointment($crrDate, $appDate)) {
                return response()->json($appDate->format("Y-m-d H:i:s"));
            }
        }
        return response()->json('-__-');
    }

    public function handle()
    {
//        //call firebase notify patient
//        $currentDateTime = new \DateTime();
//        $appointments = $this->getAppointmentsByStartTime($currentDateTime->format('Y-m-d'));
//        $currentTimeStamp = $currentDateTime->getTimestamp();
//        foreach ($appointments as $appointment) {
//            $apptDateTime = (new \DateTime($appointment->start_time));
//            $apptTimeStamp = $apptDateTime->getTimestamp();
//            if ($apptTimeStamp > $currentTimeStamp) {
//                if ($this->isUpCommingAppointment($currentDateTime, $apptDateTime)) {
//                    Utilities::logDebug("FIND ONCE" . $minute . " date in db: " . $tmpDateTime->format('Y-m-d H:i:s'));
//                    Utilities::sendRemindingAppointment($appointment->phone);
//                }
//            }
//        }
    }

    public function getSastifyAppointmentDate()
    {
        $currentDate = new DateTime();
        $currentDate2 = new DateTime();
        $this->addTimeToDate($currentDate, '00:26:00');
        $this->addTimeToDate($currentDate2, '00:30:00');
        return "Time 1: " . $currentDate->format('Y-m-d H:i:s') . '<br> Date 2: ' . $currentDate2->format('Y-m-d H:i:s');

    }

    public function sendFirebase($phone, $content)
    {
        $requestObject = Utilities::getFirebaseRequestObj(
            AppConst::RESPONSE_PROMOTION,
            "test",
            $content, $content, '/topics/' . AppConst::TOPIC_PROMOTION);

        try {
            $response = Utilities::sendFirebase($requestObject);
            return response()->json($response, 200);
        } catch (Exception $e) {
        }
        return response()->json("SUCCESS");
    }

    public function sendFirebaseToPhone($phone, $content)
    {
        $userFbToken = FirebaseToken::where('phone', $phone)->first();
        $requestObject = Utilities::getFirebaseRequestObj(
            AppConst::RESPONSE_PROMOTION,
            "test",
            $content, $content, $userFbToken->noti_token);

        try {
            $response = Utilities::sendFirebase($requestObject);
            return response()->json($response, 200);
        } catch (Exception $e) {
        }
        return response()->json("SUCCESS");
    }

    use TreatmentHistoryBusinessFunction;

    public function test2(Request $request)
    {
        $bookingDateDBFormat = '2018-08-09';

        $listDentist = $this->getAvailableDentistAtDate($bookingDateDBFormat);
        $NUM_OF_DENTIST = count($listDentist);
        $this->logBugAppointment('NUM_DENTIST' . $NUM_OF_DENTIST);
        $listAppointment = $this->getAppointmentsByStartTime($bookingDateDBFormat);
//        $dentistObj = $this->getStaffById($dentistId);
//        $predictAppointmentDate = new \DateTime();
        $appointmentArray = $this->getListTopAppointment($listDentist, $bookingDateDBFormat);
        usort($appointmentArray, array($this, "sortByTimeStamp"));
        $equallyAppointment = [];
        $equallyAppointment[] = $appointmentArray[0];

        $this->arrangeEquallyAppointment($equallyAppointment, $appointmentArray, 1);


        $arrApp = "";
        foreach ($appointmentArray as $a) {
            $arrApp .= $a['id'] . "__";

        }
        $arrApp2 = "";
        foreach ($equallyAppointment as $a) {
            $arrApp2 .= $a['id'] . "__";

        }
        return $arrApp . '<br>' . $arrApp2;

    }


    public function getDentistAppointment(Request $request)

    {
        $dentistId = $request->input('dentist_id');
        $dentist = Staff::where('id', $dentistId)->first();
        $list = $dentist->hasAppointment()->get();
        $count = $list->count();
        return response()->json(['count' => $count, 'list' => $list], 200);
    }

    /**
     * @param Request $request
     */
    public function test3(Request $request)
    {
        $date = $request->input('date');
        try {
            $availableDentists = $this->getAvailableDentistAtDate($date);
            $freeDentists = $this->getCurrentFreeDentist();
//            return response()->json($freeDentists);
            foreach ($availableDentists as $dentist) {
                if (in_array($dentist->id, $freeDentists)) {
                    $dentist->status = 'Đang rãnh';
                } else {
                    $dentist->status = 'Đang bận';
                }
            }
            return response()->json($availableDentists, 200);
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi máy chủ", $ex);
            return response()->json($error, 500);
        }
        for ($i = 3000; $i < 3500; $i++){
            $aa = new Appointment();
            $aa->start_time = '2018-08-20';
            $aa->numerical_order = $i;
            $aa->staff_id = 12;
            $aa->phone = '01214757979';
            $aa->estimated_time = (new DateTime())->format("H:i:s");
            $aa->save();
        }
        return response()->json($aa);
        if ($this->isHavingFreeSlotAtDate('2018-08-13')) {
            return response()->json("trong ");
        } else {
            return response()->json("khong trong");
        }
        $endApptTimeObj = new DateTime('2018-08-13 02:20:00');
//        $this->addTimeToDate($endApptTimeObj, $appointment->estimated_time);
        $endDayTimeObj = new DateTime('2018-08-13 03:55:00');
        $diff = ($endDayTimeObj->diff($endApptTimeObj));
        return response()->json($diff);
    }
    public function sendFirebaseReloadAppointment($phone)
    {
        $user = User::where('phone', $phone)->first();
        if ($user != null) {
            $staff = $user->belongToStaff()->first();
            if ($staff != null) {
                $staffFirebaseToken = FirebaseToken::where('phone', $staff->phone)->first();
                if ($staffFirebaseToken != null) {

                    $this->dispatch(new SendFirebaseJob(AppConst::RESPONSE_RELOAD,
                            $staff->id,
                            "No message",
                            AppConst::ACTION_RELOAD_APPOINTMENT,
                            $staffFirebaseToken->noti_token)
                    );
                }
                $this->logInfo("Send sendFirebaseReloadAppointment func");
            } else {
                $this->logInfo("staff in sendFirebaseReloadAppointment null");
            }
        }
    }

    public function test4()
    {
        //call firebase notify patient
        $currentDateTime = new \DateTime();
        $appointments = $this->getAppointmentsByStartTime($currentDateTime->format('Y-m-d'));
        $numOfReminder = 0;
        $apss = [];
        foreach ($appointments as $appointment) {
            $apptDateTime = (new \DateTime($appointment->start_time));
            if ($this->isUpCommingAppointment($currentDateTime, $apptDateTime)) {
                $numOfReminder++;
                Utilities::logDebug('Send for appointment id: ' . $appointment->id);
                $this->dispatch(new SendReminderJob($appointment->phone));
                $apss[] = $appointment;
            }
        }
        return response()->json($apss);
    }

    public function test5(Request $request)
    {
        $date = $request->query('date');
        $data = '' . $this->getColumnTime();
        $listDentists = $this->getAvailableDentistAtDate($date);
        $numDentist = 1;
        foreach ($listDentists as $dentist) {
            $appointments = $this->getDentistApptAtDate($dentist->id, $date);
            $dentistTemplate = '<div style="float:left;width:100px">';
            foreach ($appointments as $appointment) {
                $templateAppointment =
                    $this->getApptTemplate(
                        $appointment,
                        $numDentist);
                $dentistTemplate .= $templateAppointment;
            }
            $dentistTemplate .= '</div>';
            $data .= $dentistTemplate . '</div>';
            $numDentist++;
        }
        $data .= '</div>';
        return $data;
    }

    public function sendReminder(Request $request)
    {
        $appID = $request->input('id');
        $appointment = $this->getAppointmentById($appID);
        if ($appointment == null) {
            return response()->json(['error' => "Khong tim thay " . $appID], 200);
        }
        $this->dispatch(new SendReminderJob($appointment));
        return response()->json(['success' => "Gui thanh cong " . $appID], 200);

    }

    public function testSMS($phone, $content)
    {
        $result = Utilities::sendSMS($phone, $content);
        return response()->json($result, 200);
    }

    public function testCustomFunc(Request $request)
    {
        $customObj = new CustomObjectJob();
//        $customObj->handle2 = function () {
//            Log::info("INFO OOO");
//        };
        $ser = serialize($customObj);
        Log::info("SER" . $ser);
//        $this->dispatch(new ExcCustomFuncJob(serialize($customObj)));
    }

    public function helloPassing()
    {
        Log::info("Hello passing");

    }

    public function getApptTemplate($appointment, $numDentist)
    {
        $standardDate = new DateTime($appointment->start_time);
        $standardDate->setTime(0, 0);
        $bookingDate = new DateTime($appointment->start_time);
        $estimatedTimeObj = new DateTime($appointment->estimated_time);
        $diff = $bookingDate->diff($standardDate);
        $hour = $diff->h;
        $minute = $diff->i;
        $startMinute = $hour * 60;
        $startMinute += $minute;

        $topPixel = $startMinute * 5;//1 minute = 5pixel;
        $leftPosition = $numDentist * 170;
        $heightPixel = (intval($estimatedTimeObj->format('i'))
                + intval($estimatedTimeObj->format('H') * 60)) * 5;
        $phone = intval($appointment->phone);
        $width = 150;
        $colorCodeR = ($phone) % 200 + 50;
        $colorCodeG = ($phone * 10) % 255;
        $colorCodeB = ($phone * 100) % 255;
        $textColor = '#000000';
//        $colorCodeR =  255;
//        $colorCodeG = 255;
//        $colorCodeB =   255;
        $bgcolor = 'rgb(' . $colorCodeR . ', ' . $colorCodeG . ', ' . $colorCodeB . ')';
//        $bgcolor = 'white';

        ///get column apointment
        $template = '<div style="position:absolute;top:' . $topPixel .
            'px;left:' . $leftPosition . 'px' .//background:' . $color .
            ';width:' . $width . 'px;height:' . $heightPixel . 'px;border:1px solid black;">' .
            ' <span style=" ;color:' . $textColor . '">' . $appointment->id . '</span>' .
            ' <span style=" ;color:' . $textColor . '">DentistID:' . $appointment->staff_id . '</span><br>' .
            '  <span style="background:' . $bgcolor . ';color:white">' . $appointment->phone . '</span><br>' .
            ' <span style=" ;color:' . $textColor . '">StartTime: ' . $bookingDate->format('H:i') . '</span> ' .
            '<span style=" ;color:' . $textColor . '">Estimate: ' . $appointment->estimated_time . '</span> ' .
            ' <span style=" ;color:' . $textColor . '">Order: ' . $appointment->numerical_order . '</span> ' .
            '</div>';

        return $template;

    }

    public function getColumnTime()
    {
        $date = new DateTime();

        $template = '<div style="float:left;width:100px">';
        for ($i = 0; $i < 1440; $i += 30) {
            $bgColor = '#20d8b3';
            if (($i >= 720 && $i < 780) || ($i < 420) || ($i >= 1140)) {
                $bgColor = '#333300';
            }
            $topPos = $i * 5;
            $heightPx = 30 * 5;
            $date->setTime(intval(($i / 60)), $i % 60);
//            $this->logDebug("I " .(7 + intval(($i / 60))));
//            $this->logDebug(($date->format('H:i')));
            $template .= '<div style="border:1px solid white;position:absolute;top:'
                . $topPos .
                'px;background:'
                . $bgColor .
                ';width:100px;height:'
                . $heightPx .
                'px"><span style="color:#ffffff">StartAt:'
                . ($date->format('H:i')) .
                '</span> 
    </div>';
        }
        return ($template .= '</div>');
    }

    public
    function tests22(Request $request)
    {// Configure client
        $config = Configuration::getDefaultConfiguration();
        $smsApiToken = env('SMS_API_TOKEN', false);
        $smsDeviceId = env('SMS_DEVICE_ID', false);
        $deviceNumber = env('SMS_DEVICE_NUMBER', false);
        $config->setApiKey('Authorization', $smsApiToken);
        $apiClient = new ApiClient($config);
        $messageClient = new MessageApi($apiClient);
        $order = 999;
        $message = 'Cam on ban da dat lich, so thu tu cua ban la ' . $order;
        $sendMessageRequest1 = new SendMessageRequest([
            'phoneNumber' => $deviceNumber,
            'message' => $message,
            'deviceId' => $smsDeviceId
        ]);
        $sendMessageRequest2 = new SendMessageRequest([
            'phoneNumber' => '07791064781',
            'message' => 'Cam on ban da dat lich, so thu tu cua ban la ' . $order,
            'deviceId' => 95056
        ]);
        $sendMessages = $messageClient->sendMessages([
            $sendMessageRequest1
        ]);
        $result = json_decode($sendMessages[0]);
        return response()->json($result);
    }

    public function topappt(Request $request)
    {
        $date = $request->query('date');
        $listDentsit = $this->getAvailableDentistAtDate($date);
        $listApps = $this->getListTopAppointment($listDentsit, $date);
        $response = new \stdClass();
        $response->numDentist = count($listDentsit);
        $response->numAppts = count($listApps);
        $response->appointments = $listApps;
        return response()->json($response);
    }

    use PatientBusinessFunction;

    public function testAppointment(Request $request)
    {
        try {
            $numAppt = 0;
            $timeRnd = ["00:25:00", "00:30:00", "00:35:00", "00:45:00", "00:55:00", "01:30:00"];
            $timeNum = count($timeRnd);
            $dateStr = $request->input('date');
            $listPatient = $this->getListPatient();
            $arrayPatient = $listPatient->toArray();
            $listAvDentist = $this->getAvailableDentistAtDate($dateStr);
            $listPhone = [];
            foreach ($listPatient as $patient) {
                $listPhone[] = $patient->belongsToUser()->first()->phone;
            }
            $isStaff = $request->input('staff');
            $rndIsStaff = false;
            $i = 0;
            $sizeOfPatient = $listPatient->count();
            $sizeOfPhone = count($listPhone);
            $sizeOfDentist = count($listAvDentist);
            $this->logInfo("SIZE PHONE: " . $sizeOfPhone);
            $this->logInfo("SIZE DENTIST: " . $sizeOfDentist);
//            while ($this->isHavingFreeSlotAtDate($dateStr)) {
            while ($i < 200) {
                $patientPhone = $listPhone[rand(0, $sizeOfPhone - 1)];
                if ($rndIsStaff || $isStaff) {
                    $this->logInfo("Staff false: " .
                        " dateStr: " . $dateStr .
                        " patientPhone: " . $patientPhone .
                        " note : "
                    );
                    try {
                        $appt =$this->createAppointment($dateStr, $patientPhone, "No note", null, null, null, null);
                        if($appt != null){$numAppt++;}
                    } catch (Exception $e) {
                        Log::info('MobileController ex1: ' . $e->getMessage());
                    }
                } else {
                    $rndTime = $timeRnd[rand(0, $timeNum - 1)];
                    $patient = $arrayPatient[rand(0, $sizeOfPatient - 1)];
                    $dentist = $listAvDentist[rand(0, $sizeOfDentist - 1)];
                    $this->logInfo("Staff true: " .
                        " patientPhone: " . $patientPhone .
                        " note : " .
                        " dentist id: " . $dentist['id'] .
                        " patient id: " . $patient['id'] .
                        " rndTime id: " . $rndTime
                    );
                    try {
                        $appt = $this->createAppointment($dateStr, $patientPhone, "No note", $dentist['id'], $patient['id'], $rndTime, 'lucu');
                        if($appt != null){$numAppt++;}
                    } catch (Exception $e) {
                        Log::info('MobileController ex2: ' . $e->getMessage());
                    }
                }
                $num = rand(0, 1);
                if ($num == 0) {
                    $rndIsStaff = false;
                } else {
                    $rndIsStaff = true;
                }

                $i++;
            }
            Log::info("Total appt created: " .$numAppt);
            return response()->json("SUCCESS");
        } catch (\Exception $exception) {
            return response()->json($this->getErrorObj("loi server", $exception));
        }
    }

    public
    function testPOST(Request $request)
    {
        return response()->json("Success", 200);
    }
}
