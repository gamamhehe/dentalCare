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
<<<<<<< HEAD
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
Route::get('/logout', 'AdminController@logout')->name('admin.logout');
Route::get('/lara-admin', 'AdminController@checkSessionLogin')->name('checkSessionLogin');
Route::post('/loginAdmin', 'AdminController@checkLogin')->name('admin.login');
=======
Route::get('/lara-admin', 'AdminController@checkSessionLogin')->name('checkSessionLogin');
Route::get('/loginAdmin', 'AdminController@checkLogin')->name('admin.login');
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de

Route::group(['middleware' => 'loginFacebook'], function () {

});
