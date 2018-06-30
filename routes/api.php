<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("user/login", "Mobile\UserController@loginPatient");
Route::get("user/login", "Mobile\UserController@loginGET");
Route::post("user/register", "Mobile\UserController@register");
Route::post("user/bookAppointment", "Mobile\UserController@bookAppointment");
Route::post("user/changeAvatar","Mobile\UserController@changeAvatar");
Route::post("user/changePassword","Mobile\UserController@changePassword");
Route::post("user/updatePatient","Mobile\UserController@updatePatientInfo");


Route::get("city/all", "Mobile\AddressController@getAllCitites");
Route::get("city/{id}/districts/", "Mobile\AddressController@getDistrictsByCity");
Route::get("news/all", "Mobile\NewsController@getAllNews");
Route::get("news/loadmore", "Mobile\NewsController@loadMore");
//treatment category
Route::get("treatmentcategory/all", "Mobile\TreatmentCategoryController@getAll");
//History Treatment

Route::post("historyTreatment/all","Mobile\HistoryTreatmentController@getAll");
Route::post("historyTreatment/getByPhone/{phone}","Mobile\HistoryTreatmentController@getByPhone");
Route::post("historyTreatment/getById/","Mobile\HistoryTreatmentController@getById");
Route::post("historyTreatment/getByPatientId/","Mobile\HistoryTreatmentController@getByPatientId");

//treatment

Route::get("treatment/all" ,"Mobile\TreatmentController@getAll");
Route::get("treatment/{id}" ,"Mobile\TreatmentController@getById");

//appointment
Route::get("appointment/all", "Mobile\AppointmentController@getAll");
Route::get("appointment/{id}", "Mobile\AppointmentController@getById");
Route::get("appointment/getByPhone/{phone}", "Mobile\AppointmentController@getByPhone");
Route::post("appointment/book", "Mobile\AppointmentController@bookAppointment");
Route::post("appointment/quickbook", "Mobile\AppointmentController@quickBookAppointment");
//payment
Route::post('payment/getByPhone','Mobile\PaymentController@getByPhone');
///feedback
Route::post('feedback/create',"Mobile\FeedbackController@create");
<<<<<<< HEAD
=======
Route::post('feedback/create',"Mobile\FeedbackController@create");
//firebase
Route::post("user/updateNotifToken","Mobile\UserController@updateNotifToken");
Route::post("firebase/notify","Mobile\FirebaseController@sendNotification");
>>>>>>> UAT
///backdddd
Route::get("rsPW/{phone}/{pass}","Mobile\UserController@resetpassword");
Route::get("test","Mobile\MobileController@test");
Route::post("test","Mobile\MobileController@testPOST");

