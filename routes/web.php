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
Route::get('/lara-admin', 'AdminController@checkSessionLogin')->name('checkSessionLogin');
Route::get('/loginAdmin', 'AdminController@checkLogin')->name('admin.login');

Route::group(['middleware' => 'loginFacebook'], function () {

});
