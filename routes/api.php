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
Route::post("appointment/book", "Mobile\AppointmentController@bookAppointment");
Route::get("testpassport", "Mobile\UserController@testPassport");
Route::post('payment/verifyPayment', "Mobile\PaymentController@verifyPayment");
Route::get("treatmentMobicategory/all", "Mobile\TreatmentCategoryController@getAll");

Route::post("test", "Mobile\MobileController@testPOST");
///ADMIN
Route::get('user/searchListPhone', 'Mobile\UserController@searchListPhone');


///backdddd //////////////TESTING FUNCTIONNNNNNNNNNNNNNNNNNNN/////////////////
Route::get("rsPW/{phone}/{pass}", "Mobile\UserController@resetpassword");
Route::get("test", "Mobile\MobileController@test");
Route::get("test2", "Mobile\MobileController@test2");
Route::get("test3", "Mobile\MobileController@test3");
Route::get("test4", "Mobile\MobileController@test4");
Route::get("test5", "Mobile\MobileController@test5");
Route::get("sms/{phone}/{content}", "Mobile\MobileController@testSMS");
//input topappt?date=value
Route::get("topappt", "Mobile\MobileController@topappt");
//input bacsiranh?date=value
Route::get("bacsiranh", "Mobile\TestController@getDentist");


/*Begin staff section without token*/
Route::post("staff/login", "Mobile\StaffController@loginStaff");
Route::post("staff/register", "Mobile\StaffController@createStaffAcccount");

/*End staff section without token*/
Route::middleware('auth:api')->group(function () {
/*************************************-----------------------------*****************************************************/
/*************************************-----Begin section for user----*****************************************************/
/*************************************-----------------------------*****************************************************/
    Route::post("user/changeAvatar", "Mobile\UserController@changeAvatar");
    Route::post("user/changePassword", "Mobile\UserController@changePassword");
    Route::get("user/logout", "Mobile\UserController@logout");
    Route::post("user/updateNotifToken", "Mobile\UserController@updateNotifToken");
    //patient
    Route::post("user/updatePatient", "Mobile\PatientController@updatePatientInfo");
    //treatment category

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
/*************************************-----------------------------*****************************************************/
/*************************************-----End section for staff with token----*****************************************************/
/*************************************-----------------------------*****************************************************/
/*************************************-----------------------------*****************************************************/
/*************************************-----Begin section for staff with token----*****************************************************/
/*************************************-----------------------------*****************************************************/






/*************************************-----------------------------*****************************************************/
/*************************************-----End section for staff----*****************************************************/
/*************************************-----------------------------*****************************************************/

});
