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
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
Route::get('/logout', 'AdminController@logout')->name('admin.logout');
Route::get('/lara-admin', 'AdminController@checkSessionLogin')->name('checkSessionLogin');
Route::post('/loginAdmin', 'AdminController@checkLogin')->name('admin.login');

Route::group(['middleware' => 'loginFacebook'], function () {

});
