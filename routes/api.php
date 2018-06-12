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


Route::post("user/login", "Mobile\UserController@login");
Route::get("user/login", "Mobile\UserController@loginGET");
Route::post("user/register", "Mobile\UserController@register");
Route::post("user/bookAppointment", "Mobile\UserController@bookAppointment");

Route::get("city/all", "Mobile\AddressController@getAllCitites");
Route::get("city/{id}/districts/", "Mobile\AddressController@getDistrictsByCity");
Route::get("news/all", "Mobile\NewsController@getAllNews");
Route::get("news/loadmore", "Mobile\NewsController@loadMore");
//treatment category
Route::get("treatmentcategory/all", "Mobile\TreatmentCategoryController@getAll");

//treatment

Route::get("treatment/all" ,"Mobile\TreatmentController@getAll");
Route::get("treatment/{id}" ,"Mobile\TreatmentController@getById");

//appointment
Route::get("appointment/book", "Mobile\AppointmentController@bookAppointment");


