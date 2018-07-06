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
Route::get('logoutAdmin', 'Admin\StaffController@logout')->name('admin.logout');
Route::post('loginAdmin', 'Admin\StaffController@login')->name('admin.login.post');
Route::get('lara-admin', 'Admin\StaffController@loginGet')->name('admin.login');


// webuser phuc
Route::get('/', 'Admin\HomeController@HomePage')->name('homepage');
Route::get('/doctorList', 'Admin\HomeController@DoctorInformation');
Route::get('/profile', 'Admin\HomeController@Profile');
Route::get('/getDB','Admin\HomeController@getDB');
Route::get('/banggia','Admin\HomeController@BangGiaDichVu');
Route::get('/tintuc/{id}','Admin\HomeController@getNewsWebUser');
Route::get('/event','Admin\HomeController@eventLoad');
Route::get('/event/{id}','Admin\HomeController@eventLoadByID');
Route::get('/myProfile/{id}','Admin\HomeController@myProfile');
Route::get('/gioithieu','Admin\HomeController@aboutUs');
Route::get('/danhsachchitra','Admin\PaymentController@getOfUser');
Route::get('/lichsubenhan','Admin\TreatmentHistoryController@showTreatmentHistory');
Route::get('/signOut','Admin\HomeController@logout');
Route::post('loginUser', 'Admin\PatientController@login')->name('admin.loginUser.post');
Route::get('changeCP/{id}', 'Admin\PatientController@changeCurrentPatient');


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
    Route::get('/getListNews','Admin\NewsController@getList');
    Route::get('/editNews/{id}','Admin\NewsController@loadEdit');
    Route::get('/list-News', 'Admin\NewsController@loadList')->name('admin.list.news');
    Route::get('/deleteNews/{id}', 'Admin\NewsController@delete');
    Route::post('/create-News', 'Admin\NewsController@create');
    Route::post('/editNews/{id}', 'Admin\NewsController@edit')->name('admin.edit.news');
    //AnamnesisController
    Route::get('/deleteAnamnesis/{id}', 'Admin\AnamnesisController@delete');
    Route::get('/getListAnamnesis','Admin\AnamnesisController@getList');
    Route::get('/list-Anamnesis', 'Admin\AnamnesisController@loadList')->name('admin.list.anamnesis');
    Route::get('/create-Anamnesis', 'Admin\AnamnesisController@loadcreate')->name('admin.create.anamnesis');
    Route::post('/create-Anamnesis', 'Admin\AnamnesisController@create');
    Route::get('/editAnamnesis/{id}','Admin\AnamnesisController@loadEdit');
    Route::post('/editAnamnesis/{id}', 'Admin\AnamnesisController@edit')->name('admin.edit.anamnesis');
    //FeedbackController
    Route::get('/deleteFeedback/{id}', 'Admin\FeedbackController@delete');
    Route::get('/viewsFeedback/{id}','Admin\FeedbackController@getViewsFeedback')->name('admin.views.feedback');
    Route::get('/detailsFeedback/{id}','Admin\FeedbackController@getDetailsFeedback')->name('admin.details.feedback');
    Route::post('/detailsFeedback/{id}','Admin\FeedbackController@edit')->name('admin.edit.feedback');
    Route::get('/getListFeedback','Admin\FeedbackController@getListFeedback');
    Route::get('/list-Feedback', 'Admin\FeedbackController@loadListFeedback')->name('admin.list.feedback');
    //EventController
    Route::get('/getListEvent','Admin\EventController@getListEvent');
    Route::get('/list-Event', 'Admin\EventController@loadListEvent')->name('admin.list.event');
    Route::get('/create-Event', 'Admin\EventController@loadcreateEvent')->name('admin.create.event');
    Route::post('/create-Event', 'Admin\EventController@create');
    Route::get('/deleteEvent/{id}', 'Admin\EventController@deleteEvent');
    Route::get('/editEvent/{id}', 'Admin\EventController@loadeditEvent');
    Route::post('/editEvent/{id}', 'Admin\EventController@edit')->name('admin.edit.event');
    //MedicineController
    Route::get('/getListMedicines','Admin\MedicineController@getList');
    Route::get('/list-Medicines', 'Admin\MedicineController@loadList')->name('admin.list.medicines');
    Route::get('/deleteMedicines/{id}', 'Admin\MedicineController@delete');
    Route::get('/create-Medicines', 'Admin\MedicineController@loadcreate')->name('admin.create.medicines');
    Route::post('/create-Medicines', 'Admin\MedicineController@create');
    Route::get('/editMedicines/{id}', 'Admin\MedicineController@loadedit');
    Route::post('/editMedicines/{id}', 'Admin\MedicineController@edit')->name('admin.edit.medicines');
    //TreatmentController
    Route::get('/getTreatment/{id}','Admin\TreatmentController@getTreatmentByID');//ajax
    Route::get('/getTreatmentByCate/{id}','Admin\TreatmentController@getTreatmentByCategoryId');//ajax
    Route::get('/getListTreatment','Admin\TreatmentController@getListTreatment');
    Route::get('/list-Treatment', 'Admin\TreatmentController@loadListTreatment')->name('admin.list.treatment');
    Route::get('/deleteTreatment/{id}', 'Admin\TreatmentController@delete');
    Route::get('/create-Treatment', 'Admin\TreatmentController@loadcreate')->name('admin.create.treatment');
    Route::post('/create-Treatment', 'Admin\TreatmentController@create');
    Route::get('/editTreatment/{id}', 'Admin\TreatmentController@loadeditTreatment');
    Route::post('/editTreatment/{id}', 'Admin\TreatmentController@edit')->name('admin.edit.treatment');
    //Nurse
    Route::get('/live_search', 'Admin\PatientController@index')->name('admin.AppointmentPatient.index');
    Route::get('/live_search/{xx}', 'Admin\PatientController@action1') ;
    Route::get('/list-Appointment/{id}', 'Admin\PatientController@receive')->name('admin.listAppointment.patient');
    //TreatmentCategory

    //Patient
    Route::get('/create-Patient', 'Admin\PatientController@create');
    //Dentist  
    Route::get('/list-Appointment', 'Admin\StaffController@viewAppointment')->name('admin.listAppointment.dentist');
    Route::get('/getAppointment', 'Admin\StaffController@getListAppointmentByDentist');
    Route::get('/create-Dentist', 'Admin\StaffController@create');
    Route::get('/addPost','Admin\StaffController@addPost');
    Route::post('/editPost','Admin\StaffController@editPost');
    Route::get('/deletePost','Admin\StaffController@deletePost');
    Route::get('/createAppointment','Admin\StaffController@createAppointmentByStaff');
    Route::get('/createTreatment/{id}','Admin\StaffController@createTreatmentByStaff');
    Route::post('/createTreatmentHistoryPatient','Admin\TreatmentHistoryController@createTreatmentHistory')->name('admin.createTreatmentHistoryPatient.dentist');
    Route::get('/getTreatmentHistoryPatient/{id}','Admin\TreatmentHistoryController@getTreatmentHistoryByPatient');

    //Step
    Route::get('/stepTreatment','Admin\StepController@create'); //view

    //Absent
    Route::get('/createAbsent','Admin\AbsentController@loadcreate');


});

Route::post('/api/call', 'Admin\PatientController@login')->name('user.login');
Route::get('/getDB','HomeController@getDB');
Route::get('/banggia','HomeController@BangGiaDichVu');
Route::get('/generateKey', 'BlockchainController@GenerateKey');
Route::get('/encrypt', 'BlockchainController@EncryptTreatmentHistory');


Route::post('/loginUser', 'Admin\PatientController@login')->name('user.login');

    Route::get('/getTreatmentHistory', 'Admin\TreatmentController@showTreatmentHistory');
Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'users'], function () {
});

//CRUD news

// Route::post('/createNews', 'HomeController@createNews');
//end CRUD new
Route::get('/testFunction','Admin\StaffController@viewAppointment')->name('testFunction');
Route::get('/startTreatment', 'Admin\TreatmentController@startTreatment')->name('start.treatment');