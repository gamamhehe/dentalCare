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

Route::get('initData', 'Admin\AdminController@initData');
Route::get('logoutAdmin', 'Admin\AdminController@logout')->name('admin.logout');
Route::post('loginAdmin', 'Admin\AdminController@login')->name('admin.login.post');
Route::get('lara-admin', 'Admin\AdminController@loginGet')->name('admin.login');


// webuser phuc
Route::get('/', 'User\HomeController@HomePage');
Route::get('/doctorList', 'User\HomeController@DoctorInformation');
Route::get('/profile', 'User\HomeController@Profile');
// end webuser

Route::group(['prefix' => 'admin', 'middleware' => 'admins'], function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/create-News', 'Mobile\NewsController@loadcreateNews');

    Route::get('/getListNews','Admin\NewsController@getListNew');
    Route::get('/editNews/{id}','Admin\NewsController@loadEditNews');
    Route::get('/deleteNews/{id}','Admin\NewsController@deleteNews');
    Route::get('/list-News', 'Admin\NewsController@loadListNews');
    Route::get('/deleteNews/{id}', 'Admin\NewsController@deleteNews');
    Route::post('/create-News', 'Admin\NewsController@createNews');
    Route::post('/editNews/{id}', 'Admin\NewsController@createdNews')->name('admin.edit.news');
});

Route::get('/getDB','HomeController@getDB');
Route::get('/banggia','HomeController@BangGiaDichVu');
Route::get('/generateKey', 'BlockchainController@GenerateKey');
Route::get('/encrypt', 'BlockchainController@EncryptTreatmentHistory');



    Route::get('/getTreatmentHistory', 'User\TreatmentController@showTreatmentHistory');
Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'users'], function () {
});
Route::get('/getDB','User\HomeController@getDB');
Route::get('/banggia','User\HomeController@BangGiaDichVu');

//CRUD news

// Route::post('/createNews', 'HomeController@createNews');
//end CRUD new

