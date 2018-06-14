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

Route::get('initAdmin', 'Admin\AdminController@initAdmin');
Route::get('initTreatment', 'Admin\AdminController@initTreatment');
Route::get('initTooth', 'Admin\AdminController@initTooth');
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
    Route::get('/create-News', 'Mobile\NewsController@loadcreateNews');

    Route::get('/getListNews','Mobile\NewsController@getListNew');
    Route::get('/editNews/{id}','Mobile\NewsController@loadEditNews');
    Route::get('/deleteNews/{id}','Mobile\NewsController@deleteNews');
    Route::get('/list-News', 'Mobile\NewsController@loadListNews');
    Route::get('/deleteNews/{id}', 'Mobile\NewsController@deleteNews');
    Route::post('/create-News', 'Mobile\NewsController@createNews');
    Route::post('/created-News', 'Mobile\NewsController@createdNews');
});


Route::get('/getTreatmentHistory', 'User\TreatmentController@showTreatmentHistory');
Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'users'], function () {
});
Route::get('/getDB','User\HomeController@getDB');
Route::get('/banggia','User\HomeController@BangGiaDichVu');

//CRUD news

// Route::post('/createNews', 'HomeController@createNews');
//end CRUD new
