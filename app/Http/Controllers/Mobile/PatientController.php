<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 02-Jul-18
 * Time: 17:38
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\RequestAbsentBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Patient;
use Exception;
use Illuminate\Http\Request;
use Pusher\Pusher;

class PatientController extends BaseController
{
    use UserBusinessFunction;
    use PatientBusinessFunction;
    use AppointmentBussinessFunction;

    public function updatePatientInfo(Request $request)
    {
        try {
            $patientId = $request->input('id');
            $name = $request->input('name');
            $gender = $request->input('gender');
            $birthday = $request->input('date_of_birth');
            $address = $request->input('address');
            $districtId = $request->input('district_id');
            $patient = $this->getPatientById($patientId);
            if ($patient != null) {
                $patient->name = $name;
                $patient->gender = $gender;
                $patient->date_of_birth = $birthday;
                $patient->address = $address;
                $patient->district_id = $districtId;
                $result = $this->updatePatient($patient);
                if ($result == true) {
                    $successResponse = new \stdClass();
                    $successResponse->status = "OK";
                    $successResponse->code = 200;
                    $successResponse->message = "Sửa tài khoản thành công";
                    $successResponse->data = $patient;
                    return response()->json($successResponse, 200);
                } else {
                    $error = new \stdClass();
                    $error->error = "Không thể sửa đổi thông tin người dùng";
                    $error->exeption = null;
                    return response()->json($error, 400);
                }
            } else {
                $error = new \stdClass();
                $error->error = "Không thể tìm thấy id bệnh nhân";
                $error->exeption = null;
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Lỗi máy chủ";
            $error->exception = $ex->getMessage();
            return response()->json($error, 400);
        }
    }

    public function getByPhone(Request $request)
    {
        try {
            $phone = $request->input("phone");
            $user = $this->getUserByPhone($phone);
            if ($user == null) {
                $error = $this->getErrorObj("Số điện thoại chưa được đăng kí", "No exception");
                return response()->json($error, 400);
            }
            $patients = $this->getPatientByPhone($phone);
            return $patients;
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 500);
        }
    }

    public function receive(Request $request)
    {

        $patientId = $request->input('patient_id');
        $phone = $this->getPhoneOfPatient($patientId);
        $isExamination = $this->checkPatientIsExamination($patientId);
        if ($isExamination) {
            $error = $this->getErrorObj("Bệnh nhân đang khám theo lịch hẹn này", 400);
            return response()->json($error, 400);
        } else {
            $appointment = $this->checkAppointmentForPatient($phone, $patientId);
            if ($appointment === null) {
                $error = $this->getErrorObj("Bệnh nhân chưa có lịch hẹn", "No Exception");
                return response()->json($error, 400);
            } else if ($appointment) {
                $appointment->status = 1;
                $this->saveAppointment($appointment, $patientId);
//                $options = array(
//                    'cluster' => 'ap1',
//                    'encrypted' => true
//                );
//                $pusher = new Pusher(
//                    'e3c057cd172dfd888756',
//                    '993a258c11b7d6fde229',
//                    '562929',
//                    $options
//                );
//                $pusher->trigger('receivePatient', 'ReceivePatient', $appointment);
                $successResponse = $this->getSuccessObj(200, "OK","Nhận bệnh thành công", "No Exception");
                return response()->json($successResponse, 200);
            } else {
                $error = $this->getErrorObj("Lỗi không xác dịnh", "No Exception");
                return response()->json($error, 400);
            }
        }
    }

}