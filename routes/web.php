<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('initAdmin', 'AdminController@initAdmin')->name('admin.login.initAdmin');
Route::get('initAdmin2', 'AdminController@initAdmin2')->name('admin.login.initAdmin');
Route::get('initTreatmentCate', 'AdminController@initTreatmentCate')->name('admin.login.initAdmin');
Route::get('initTreatment', 'AdminController@initTreatment')->name('admin.login.initAdmin');
Route::get('logout', 'AdminController@logout')->name('admin.logout');
Route::get('lara-admin', 'AdminController@checkSessionLogin')->name('checkSessionLogin');
Route::post('loginAdmin', 'AdminController@checkLogin')->name('admin.login');

// webuser phuc
Route::get('/','HomeController@HomePage');
Route::get('/doctorList','HomeController@DoctorInformation');
// end webuser

Route::group(['middleware' => 'admins'], function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::get('/getDB','HomeController@getDB');
Route::get('/banggia','HomeController@BangGiaDichVu');
