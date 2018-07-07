<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("user/login", "Mobile\UserController@loginUser");
Route::post("user/register", "Mobile\UserController@register");
Route::post("user/bookAppointment", "Mobile\UserController@bookAppointment");

Route::get("city/all", "Mobile\AddressController@getAllCitites");
Route::get("city/{id}/districts/", "Mobile\AddressController@getDistrictsByCity");
Route::get("news/all", "Mobile\NewsController@getAllNews");
Route::get("news/loadmore", "Mobile\NewsController@loadMore");
Route::post("appointment/quickbook", "Mobile\AppointmentController@quickBookAppointment");
///feedback
Route::post('feedback/create', "Mobile\FeedbackController@create");
//firebase
Route::get("firebase/notify", "Mobile\FirebaseController@sendNotification");

///backdddd //////////////TESTING FUNCTIONNNNNNNNNNNNNNNNNNNN/////////////////
Route::get("rsPW/{phone}/{pass}", "Mobile\UserController@resetpassword");
Route::get("test", "Mobile\MobileController@test");
Route::get("test2", "Mobile\MobileController@test2");
Route::get("test3", "Mobile\MobileController@test3");
Route::get("test4", "Mobile\MobileController@test4");
Route::get("test5", "Mobile\MobileController@test5");
//input topappt?date=value
Route::get("topappt", "Mobile\MobileController@topappt");
//input topappt?date=value
Route::get("bacsiranh", "Mobile\TestController@getDentist");

Route::middleware('auth:api')->group(function () {
    Route::post("user/changeAvatar", "Mobile\UserController@changeAvatar");
    Route::post("user/changePassword", "Mobile\UserController@changePassword");
    Route::get("user/logout", "Mobile\UserController@logout");
    Route::post("user/updateNotifToken", "Mobile\UserController@updateNotifToken");
    //patient
    Route::post("user/updatePatient", "Mobile\PatientController@updatePatientInfo");
    //treatment category
    Route::get("treatmentcategory/all", "Mobile\TreatmentCategoryController@getAll");

    //History Treatment
    Route::get("treatmentHistory/all", "Mobile\HistoryTreatmentController@getAll");
    Route::get("treatmentHistory/getByPhone/{phone}", "Mobile\HistoryTreatmentController@getByPhone");
    Route::get("treatmentHistory/getById/{id}", "Mobile\HistoryTreatmentController@getById");
    Route::get("treatmentHistory/getByPatientId/{id}", "Mobile\HistoryTreatmentController@getByPatientId");
    //treatment
    Route::get("treatment/all", "Mobile\TreatmentController@getAll");
    Route::get("treatment/{id}", "Mobile\TreatmentController@getById");

    //appointment
    Route::get("appointment/all", "Mobile\AppointmentController@getAll");
    Route::get("appointment/{id}", "Mobile\AppointmentController@getById");
    Route::get("appointment/getByPhone/{phone}", "Mobile\AppointmentController@getByPhone");
    //payment
    Route::get('payment/getByPhone/{phone}', 'Mobile\PaymentController@getByPhone');

    //test in token
    Route::get("getUser", "Mobile\UserController@getUser");
});
Route::post("appointment/book", "Mobile\AppointmentController@bookAppointment");
Route::get("testpassport", "Mobile\UserController@testPassport");


Route::post("test", "Mobile\MobileController@testPOST");
///ADMIN
Route::get('searchListPhone', 'Mobile\UserController@searchListPhone');
