<?php
/**
 * Created by PhpStorm.
 * User: Luc
 * Date: 02-Jul-18
 * Time: 17:38
 */

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Patient;
use Illuminate\Http\Request;

class PatientController extends BaseController
{
    use UserBusinessFunction;
    use PatientBusinessFunction;
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

    public function createProfile(Request $request)
    {
        try {
            $phone = $request->input('phone');
            $user = $this->getUserByPhone($phone);
            if ($user != null) {
                $name = $request->input('name');
                $gender = $request->input('gender');
                $birthday = $request->input('birthday');
                $districtId = $request->input('districtId');
                $address = $request->input('address');
                $patient = new Patient();
                $patient->phone = $phone;
                $patient->date_of_birth = $birthday;
                $patient->gender = $gender;
                $patient->district_id = $districtId;
                $patient->name = $name;
                $patient->address = $address;
                $result = $this->updateUser($patient);
                if($result){
                    return response()->json($patient, 200);
                }else{
                    $error = $this->getErrorObj("Không thễ tạo hồ sơ bệnh nhân, vui lòng thử lại",
                        "result false, no exception");
                    return response()->json($error, 400);
                }
            } else {
                $error = $this->getErrorObj(
                    "Số diện thoại chưa được đăng kí",
                    "No Exception");
                return response()->json($error, 400);
            }
        } catch (\Exception $ex) {
            $error = $this->getErrorObj(
                "Không thể đăng kí thông tin người dùng", $ex);
            return response()->json($error, 400);
        }
    }

}