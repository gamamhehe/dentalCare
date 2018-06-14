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

Route::get('initAdmin', 'Admin\AdminController@initAdmin')->name('admin.login.initAdmin');
Route::get('initTreatment', 'Admin\AdminController@initTreatment')->name('admin.login.initTreatment');
Route::get('logoutAdmin', 'Admin\AdminController@logout')->name('admin.logout');
Route::post('loginAdmin', 'Admin\AdminController@login')->name('admin.login.post');
Route::get('lara-admin', 'Admin\AdminController@loginGet')->name('admin.login');


// webuser phuc
Route::get('/', 'User\HomeController@HomePage');
Route::get('/doctorList', 'User\HomeController@DoctorInformation');
// end webuser

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admins'], function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::get('/getDB', 'User\HomeController@getDB');
Route::get('/banggia', 'User\HomeController@BangGiaDichVu');

Route::get('/getTreatmentHistory', 'User\TreatmentController@showTreatmentHistory');
Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'users'], function () {
});