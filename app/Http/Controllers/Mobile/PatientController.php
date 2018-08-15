<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 02-Jul-18
 * Time: 17:38
 */

namespace App\Http\Controllers\Mobile;


use App\Helpers\AppConst;
use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Jobs\SendFirebaseJob;
use App\Model\FirebaseToken;
use App\Model\PatientOfAppointment;
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
            $listAnamnesisId = $request->input('anamnesis[]');
            $patient = $this->getPatientById($patientId);
            if ($patient != null) {
                $patient->name = $name;
                $patient->gender = $gender;
                $patient->date_of_birth = $birthday;
                $patient->address = $address;
                $patient->district_id = $districtId;
                $result = $this->updatePatientWithAnamnesis($patient, $listAnamnesisId);
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
//            $staffId = $request->input("dentist_id");
            $user = $this->getUserByPhone($phone);
            if ($user == null) {
                $error = $this->getErrorObj("Số điện thoại chưa được đăng kí", "No exception");
                return response()->json($error, 400);
            }
            $patients = $this->getPatientByPhone($phone);
            $user->patients = $patients;
            $user->appointments = $this->getUserApptByDate($phone, (new \DateTime())->format('Y-m-d'));
            foreach ($user->appointments as $appointment) {
                $this->attachFieldAppointment($appointment);
            }
            return $user;
        } catch (Exception $ex) {
            $error = $this->getErrorObj("Lỗi server", $ex);
            return response()->json($error, 500);
        }
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


    public function changeAvatar(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $id = $request->input('id');
                $image = $request->file('image');
                $tmpPatient = $this->getPatientById($id);
                if ($tmpPatient != null) {
                    if ($this->editAvatar($image, $id)) {
                        $patient = $this->getPatientById($id);
                        $response = new \stdClass();
                        $response->status = "OK";
                        $response->message = "Chỉnh sửa avatar thành công";
                        $response->data = $patient->avatar;
                        return response()->json($response, 200);
                    } else {
                        $error = new \stdClass();
                        $error->error = "Có lỗi xảy ra, không thể chỉnh sửa avatar";
                        $error->exception = "Nothing";
                        return response()->json($error, 400);
                    }
                } else {
                    $error = new \stdClass();
                    $error->error = "Không thể tìm thấy bệnh nhân ";
                    $error->exception = "Nothing";
                    return response()->json($error, 400);
                }
            } else {
                $error = new \stdClass();
                $error->error = "Lỗi khi nhận hình ảnh ";
                $error->exception = "Nothing";
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = new \stdClass();
            $error->error = "Lỗi máy chủ";
            $error->exception = $ex->getMessage();
            return response()->json($error, 400);
        }
    }

    public function getListPatientByPhone(Request $request)
    {
        try {
            $phone = $request->input('phone');
            $user = $this->getUserByPhone($phone);
            if ($user == null) {
                $error = $this->getErrorObj("Số điện thoại chưa được đăng kí", "No exception");
                return response()->json($error, 400);
            }
            $patients = $this->getPatientByPhone($phone);
            return response()->json($patients);
        } catch (\Exception $ex) {
            $error = $this->getErrorObj("Có lỗi xảy ra", $ex);
            return response()->json($error, 500);
        }
    }
}