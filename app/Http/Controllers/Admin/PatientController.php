<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BusinessFunction\UserBusinessFunction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    use UserBusinessFunction;
    //
    use UserBusinessFunction;
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
}
