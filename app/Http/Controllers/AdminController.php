<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    //
    public function checkSessionLogin(Request $request){
        $sessionUser = $request->session()->get('idAdmin', 'default');
        if($sessionUser == 'default'){
            return view('admin.login');
        }else{
            return view('admin.dashboard');
        }
    }
    public function checkLogin(Request $request){

    }
    public function dashboard(Request $request){
            return view('admin.dashboard');
    }
    public function logout(Request $request){
        $request->session()->remove('idFacebook');
        $request->session()->remove('nameUser');
        $request->session()->remove('image');
        $request->session()->remove('gmailAddress');
        return redirect()->route('main.page');
    }
}
