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
Route::get('initNews', 'Admin\AdminController@initNews');
Route::get('initStep', 'Admin\AdminController@initStep');
Route::get('initData', 'Admin\AdminController@initData');
Route::get('logoutAdmin', 'Admin\AdminController@logout')->name('admin.logout');
Route::post('loginAdmin', 'Admin\AdminController@login')->name('admin.login.post');
Route::get('lara-admin', 'Admin\AdminController@loginGet')->name('admin.login');


// webuser phuc
Route::get('/', 'Admin\HomeController@HomePage')->name('homepage');
Route::get('/doctorList', 'Admin\HomeController@DoctorInformation');
Route::get('/profile', 'Admin\HomeController@Profile');
Route::get('/getDB','Admin\HomeController@getDB');
Route::get('/banggia','Admin\HomeController@BangGiaDichVu');
Route::get('/tintuc/{id}','Admin\HomeController@getNewsWebUser');
Route::get('/event','Admin\HomeController@eventLoad');
Route::get('/myProfile/{id}','Admin\HomeController@myProfile');
Route::get('/gioithieu','Admin\HomeController@aboutUs');
Route::get('/danhsachchitra','Admin\PaymentController@getPaymentOfUser');
Route::get('/lichsubenhan','Admin\TreatmentController@showTreatmentHistory');
Route::get('/signOut','Admin\HomeController@logout');


// end webuser

Route::group(['prefix' => 'admin', 'middleware' => 'admins'], function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    //UserController
    Route::get('/register', 'Admin\Usercontroller@registerGet');
    Route::post('/register', 'Admin\Usercontroller@registerPost');
    //NewsController
    Route::get('/create-News', 'Mobile\NewsController@loadcreateNews')->name('admin.create.news');
    Route::get('/getListNews','Admin\NewsController@getListNew');
    Route::get('/editNews/{id}','Admin\NewsController@loadEditNews');
    Route::get('/list-News', 'Admin\NewsController@loadListNews')->name('admin.list.news');
    Route::get('/deleteNews/{id}', 'Admin\NewsController@deleteNews');
    Route::post('/create-News', 'Admin\NewsController@createNews');
    Route::post('/editNews/{id}', 'Admin\NewsController@createdNews')->name('admin.edit.news');
    //AnamnesisController
    Route::get('/deleteAnamnesis/{id}', 'Admin\AnamnesisController@deleteAnamnesis');
    Route::get('/getListAnamnesis','Admin\AnamnesisController@getListAnamnesis');
    Route::get('/list-Anamnesis', 'Admin\AnamnesisController@loadListAnamnesis')->name('admin.list.anamnesis');
    Route::get('/create-Anamnesis', 'Admin\AnamnesisController@loadcreateAnamnesis')->name('admin.create.anamnesis');
    Route::post('/create-Anamnesis', 'Admin\AnamnesisController@createAnamnesis');
    Route::get('/editAnamnesis/{id}','Admin\AnamnesisController@loadEditAnamnesis');
    Route::post('/editAnamnesis/{id}', 'Admin\AnamnesisController@editdAnamnesis')->name('admin.edit.anamnesis');
    //FeedbackController
    Route::get('/deleteFeedback/{id}', 'Admin\FeedbackController@deleteFeedback');
    Route::get('/viewsFeedback/{id}','Admin\FeedbackController@getViewsFeedback')->name('admin.views.feedback');
    Route::get('/detailsFeedback/{id}','Admin\FeedbackController@getDetailsFeedback')->name('admin.details.feedback');
    Route::post('/detailsFeedback/{id}','Admin\FeedbackController@editFeedback')->name('admin.edit.feedback');
    Route::get('/getListFeedback','Admin\FeedbackController@getListFeedback');
    Route::get('/list-Feedback', 'Admin\FeedbackController@loadListFeedback')->name('admin.list.feedback');
    //EventController
    Route::get('/getListEvent','Admin\EventController@getListEvent');
    Route::get('/list-Event', 'Admin\EventController@loadListEvent')->name('admin.list.event');
    Route::get('/create-Event', 'Admin\EventController@loadcreateEvent')->name('admin.create.event');
    Route::post('/create-Event', 'Admin\EventController@createEvent');
    Route::get('/deleteEvent/{id}', 'Admin\EventController@deleteEvent');
    Route::get('/editEvent/{id}', 'Admin\EventController@loadeditEvent');
    Route::post('/editEvent/{id}', 'Admin\EventController@editEvent')->name('admin.edit.event');
    //MedicineController
    Route::get('/getListMedicines','Admin\MedicineController@getListMedicines');
    Route::get('/list-Medicines', 'Admin\MedicineController@loadListMedicines')->name('admin.list.medicines');
    Route::get('/deleteMedicines/{id}', 'Admin\MedicineController@deletMedicines');
    Route::get('/create-Medicines', 'Admin\MedicineController@loadcreateMedicines')->name('admin.create.medicines');
    Route::post('/create-Medicines', 'Admin\MedicineController@createMedicines');
    Route::get('/editMedicines/{id}', 'Admin\MedicineController@loadeditMedicines');
    Route::post('/editMedicines/{id}', 'Admin\MedicineController@editMedicines')->name('admin.edit.medicines');
    //TreatmentController
    Route::get('/getListTreatment','Admin\TreatmentController@getListTreatment');
    Route::get('/list-Treatment', 'Admin\TreatmentController@loadListTreatment')->name('admin.list.treatment');
    Route::get('/deleteTreatment/{id}', 'Admin\TreatmentController@deleteTreatment');
    Route::get('/create-Treatment', 'Admin\TreatmentController@loadcreateMedicines')->name('admin.create.treatment');
    Route::post('/create-Treatment', 'Admin\TreatmentController@createTreatment');
    Route::get('/editTreatment/{id}', 'Admin\TreatmentController@loadeditTreatment');
    Route::post('/editTreatment/{id}', 'Admin\TreatmentController@editTreatment')->name('admin.edit.treatment');
    //Nurse
    Route::get('/manageUserCalendar','Admin\AdminController@getManageUserCalendar');

    Route::get('/live_search', 'Admin\AdminController@index');
    Route::get('/live_search/action', 'Admin\AdminController@action')->name('live_search.action');

});

Route::post('/api/call', 'Admin\PatientController@login')->name('user.login');

    Route::get('/getTreatmentHistory', 'Admin\TreatmentController@showTreatmentHistory');
Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'users'], function () {
});

//CRUD news

// Route::post('/createNews', 'HomeController@createNews');
//end CRUD new
Route::get('/testFunction','Admin\AbsentController@approve')->name('testFunction');
Route::get('/startTreatment', 'Admin\TreatmentController@startTreatment')->name('start.treatment');