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

Route::post("user/login", "Mobile\UserController@login");
Route::post("user/register", "Mobile\UserController@register");
Route::post("user/bookAppointment", "Mobile\UserController@bookAppointment");
Route::get("user/resetPassword/{phone}", "Mobile\UserController@resetPassword");


Route::get("city/all", "Mobile\AddressController@getAllCitites");
Route::get("city/{id}/districts/", "Mobile\AddressController@getDistrictsByCity");
Route::get("news/all", "Mobile\NewsController@getAllNews");
Route::get("news/loadmore", "Mobile\NewsController@loadMore");
Route::post("appointment/quickbook", "Mobile\AppointmentController@quickBookAppointment");
//treatment
Route::get("treatment/all", "Mobile\TreatmentController@getAll");
Route::get("treatment/{id}", "Mobile\TreatmentController@getById");
//medicine
Route::get("medicine/all", "Mobile\MedicineController@getAll");

///feedback
Route::post('feedback/create', "Mobile\FeedbackController@create");
//firebase
Route::post("firebase/notify", "Mobile\FirebaseController@sendNotification");
Route::post("appointment/book", "Mobile\AppointmentController@bookAppointment");
Route::get("testpassport", "Mobile\UserController@testPassport");
Route::post('payment/verifyPayment', "Mobile\PaymentController@verifyPaymentPaypal");
Route::get("treatmentcategory/all", "Mobile\TreatmentCategoryController@getAll");
Route::get("tooth/all", "Mobile\ToothController@getAll");
Route::get("symptom/all", "Mobile\SymptomController@getAll");

Route::post("test", "Mobile\MobileController@testPOST");
///ADMIN
Route::get('user/searchListPhone', 'Mobile\UserController@searchListPhone');


///backdddd //////////////TESTING FUNCTIONNNNNNNNNNNNNNNNNNNN/////////////////
Route::get("rsPW/{phone}/{pass}", "Mobile\UserController@resetpasswordTest");
Route::get("test", "Mobile\MobileController@test");
Route::post("test", "Mobile\MobileController@test");
Route::get("test2", "Mobile\MobileController@test2");
Route::post("test2", "Mobile\MobileController@test2");
Route::get("test3", "Mobile\MobileController@test3");
Route::post("test3", "Mobile\MobileController@test3");
Route::get("test4", "Mobile\MobileController@test4");
Route::post("test4", "Mobile\MobileController@test4");
Route::get("test5", "Mobile\MobileController@test5");
Route::get("testAppointment", "Mobile\MobileController@testAppointment");
Route::post("test5", "Mobile\MobileController@test5");
Route::post("test5", "Mobile\MobileController@test5");
Route::get("deleteUser/", "Mobile\MobileController@deleteUser");
Route::get("dentistAppointment", "Mobile\MobileController@getDentistAppointment");
Route::get("token/{phone}", "Mobile\TestController@getToken");
Route::get("sms/{phone}/{content}", "Mobile\MobileController@testSMS");
Route::get("firebase/send/{phone}/{content}", "Mobile\MobileController@sendFirebaseToPhone");
Route::get("firebase/{topic}/{content}", "Mobile\MobileController@sendFirebase");
//input topappt?date=value
Route::get("topappt", "Mobile\MobileController@topappt");

Route::get("reload/{phone}", "Mobile\MobileController@sendFirebaseReloadAppointment");
Route::get("reloadappt", "Mobile\MobileController@sendFirebaseReloadClinicAppointment");
//input bacsiranh?date=value
Route::get("bacsiranh", "Mobile\TestController@getDentist");
Route::get("reminder", "Mobile\MobileController@sendReminder");


/*Begin staff section without token*/
Route::post("staff/login", "Mobile\StaffController@loginStaff");
Route::post("staff/register", "Mobile\StaffController@createStaffAcccount");

/*End staff section without token*/
Route::middleware('auth:api')->group(function () {
    /*************************************-----------------------------*****************************************************/
    /*************************************-----Begin section for user----*****************************************************/
    /*************************************-----------------------------*****************************************************/
    Route::get("user/logout", "Mobile\UserController@logout");
    Route::post("user/updateNotifToken", "Mobile\UserController@updateNotifToken");
    Route::post("user/changePassword", "Mobile\UserController@changePassword");
    Route::post("patient/changeAvatar", "Mobile\PatientController@changeAvatar");
    Route::post("patient/updatePatient", "Mobile\PatientController@updatePatientInfo");
    //patient
    //nt category

    //History Treatment
    Route::get("treatmentHistory/all", "Mobile\TreatmentHistoryController@getAll");
    Route::get("treatmentHistory/getByPhone/{phone}", "Mobile\TreatmentHistoryController@getByPhone");
    Route::get("treatmentHistory/getById/{id}", "Mobile\TreatmentHistoryController@getById");
    Route::get("treatmentHistory/getTreatmentHistoryReport", "Mobile\TreatmentHistoryController@getTreatmentHistoryReport");
    Route::get("treatmentHistory/getByPatientId/{id}", "Mobile\TreatmentHistoryController@getByPatientId");
    Route::post("treatmentHistory/create", "Mobile\TreatmentHistoryController@create");
    Route::post("treatmentDetail/create", "Mobile\TreatmentDetailController@create");
    //treatment
    //appointment
    Route::get("appointment/all", "Mobile\AppointmentController@getAll");
    Route::get("appointment/getById/{id}", "Mobile\AppointmentController@getById");
    Route::get("appointment/getByDate", "Mobile\AppointmentController@getByDate");
    Route::get("appointment/getByPhone/{phone}", "Mobile\AppointmentController@getByPhone");
    Route::get("appointment/getUserAppointmentByCurrentDate/", "Mobile\AppointmentController@getUserAppointmentByCurrentDate");
    //payment
    Route::get('payment/getByPhone/{phone}', 'Mobile\PaymentController@getByPhone');
    Route::get('payment/getPaymentReport/', 'Mobile\PaymentController@getPaymentReport');
    Route::post('payment/updatePaymentPrice/', 'Mobile\PaymentController@updatePaymentPrice');
    //staff
  
    Route::post("staff/createPatient", "Mobile\StaffController@createPatient");
    Route::get("staff/getAppointmentByMonth", "Mobile\StaffController@getStaffAppointmentByMonth");
    Route::post("staff/bookAppointment", "Mobile\StaffController@bookAppointment");
    Route::post("staff/changeAvatar", "Mobile\StaffController@changeAvatar");
    Route::post("staff/changePassword", "Mobile\StaffController@changePassword");
    Route::post("staff/changeAppointmentStatus", "Mobile\StaffController@updateAppointmentStatus");
    Route::post("staff/changeAppointmentDentist", "Mobile\StaffController@changeDentist");
    Route::post("staff/doneTreatment/{tmId}", "Mobile\StaffController@doneTreatment");
    /*************************************-----------------------------*****************************************************/
    /*************************************-----End section for staff with token----*****************************************************/
    /*************************************-----------------------------*****************************************************/
    /*************************************-----------------------------*****************************************************/
    /*************************************-----Begin section for staff with token----*****************************************************/
    /*************************************-----------------------------*****************************************************/

    Route::post('patient/createProfile', "Mobile\PatientController@createProfile");
    Route::post("patient/update", "Mobile\PatientController@updatePatientInfo");
    Route::get('patient/getByPhone', "Mobile\PatientController@getByPhone");
    Route::get('patient/getListPatientByPhone', "Mobile\PatientController@getListPatientByPhone");
    Route::get('staff/getPatientAppointmentByDate', "Mobile\StaffController@getPatientAppointmentByDate");
    Route::post("staff/receiveApptManually", "Mobile\StaffController@receiveAppointmentManually");
    Route::post("staff/receiveAppt", "Mobile\StaffController@receiveAppointment");
    ////////Anamesis
    Route::get('anamnesisCatalog/all','Mobile\AnamnesisController@getAll');
    Route::get('staff/getAvailableDentist', 'Mobile\StaffController@getAvailableDentist');
    Route::get('staff/getCurrentFreeDentist', 'Mobile\StaffController@getCurrentFreeDentists');
    Route::get('staff/getListRequestAbsent', 'Mobile\StaffController@getListRequestAbsent');
    Route::get('staff/getListRequestAbsentByTime', 'Mobile\StaffController@getListRequestAbsentByTime');
    Route::post('staff/requestAbsent', 'Mobile\StaffController@requestAbsent');
    Route::post('staff/updateStaffInfo', 'Mobile\StaffController@updateStaffInfo');
    Route::post('requestAbsent/changeStatusDelete/{req_id}', 'Mobile\RequestAbsentController@changeStatusDelete');
    /*************************************-----------------------------*****************************************************/
    /*************************************-----End section for staff----*****************************************************/
    /*************************************-----------------------------*****************************************************/

});
