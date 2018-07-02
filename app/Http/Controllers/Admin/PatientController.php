<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\AppointmentBussinessFunction;
use App\Http\Controllers\BusinessFunction\PatientBusinessFunction;
use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use App\Model\Patient;
use App\Model\Payment;
use App\Model\User;
use App\Model\UserHasRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    use UserBusinessFunction;
    use PatientBusinessFunction;
    use AppointmentBussinessFunction;
    public function login(Request $request){

        $this->validate($request, [
            'phone' => 'required|min:10|max:11',
            'password' => 'required|min:6'
        ]);
        $user = $this->checkLogin($request->phone, $request->password);
        if ($user != null) {
            $roleID = $user->hasUserHasRole()->first()->belongsToRole()->first()->id;
            if ($roleID == 4) {
                session(['currentUser' => $user]);
                $listPatient = $user->hasPatient()->get();
                session(['listPatient' => $listPatient]);
                session(['currentPatient' => $listPatient[0]]);

                return redirect()->intended(route('homepage'));
            }
            return redirect()->back()->with('fail', '* You do not have permission for this page')->withInput($request->only('phone'));
        }
        return redirect()->back()->with('fail', '* Wrong phone number or password')->withInput($request->only('phone'));
    }
    public function createBoth(Request $request){
        $checkExist = $this->checkExistUser($request->phone);
        if($checkExist){
            return false;
        }
        $patient = new Patient();
        $userHasRole = new UserHasRole();
        $user = new User();
        $userHasRole->phone = $request->phone;
        $userHasRole->role_id = 4;
        $userHasRole->start_time = Carbon::now();
        $patient->name = $request->name;
        $patient->address = $request->address;
        $patient->phone = $request->phone;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->gender = $request->gender;
        $patient->avatar = $request->avatar;
        $patient->district_id = $request->district_id;
        $patient->is_parent = $request->is_parent;
        $user->phone = $user->phone;
        $user->password = Hash::make($user->phone);
        $this->createUserWithRole($user,$patient, $userHasRole);
    }

    public function create(Request $request){
        $patient = new Patient();
        $userHasRole = new UserHasRole();
        $userHasRole->phone = $request->phone;
        $userHasRole->role_id = 4;
        $userHasRole->start_time = Carbon::now();
        $patient->name = $request->name;
        $patient->address = $request->address;
        $patient->phone = $request->phone;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->gender = $request->gender;
        $patient->avatar = $request->avatar;
        $patient->district_id = $request->district_id;
        $patient->is_parent = $request->is_parent;
        $this->createPatient($patient, $userHasRole);

    }

    public function get($phone){
        return $this->getPatient($phone);
    }

    public function update(Request $request){
        $idPatient = $request->patient_id;
        $this->updatePatient($request, $idPatient);

    }

    public function getList(){
        return $this->getListPatient();
    }

    public function receive(Request $request){
        $appointment = $this->checkAppointmentForPatient($request->phone);
    }
}
