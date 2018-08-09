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

Route::get('/cc', function () {
    return view('WebUser.User.Profile');
});
// webuser phuc
Route::get('/gioi-thieu', 'Admin\HomeController@aboutUs');
Route::get('/', 'Admin\HomeController@HomePage')->name('homepage');
Route::get('/danh-sach-bac-si', 'Admin\HomeController@DoctorInformation');
Route::get('/profile', 'Admin\HomeController@Profile');
Route::get('/getDB', 'Admin\HomeController@getDB');
Route::get('/bang-gia', 'Admin\HomeController@BangGiaDichVu');
Route::get('/tin-tuc/{id}', 'Admin\HomeController@getNewsWebUser');
Route::get('/su-kien', 'Admin\HomeController@eventLoad');
Route::get('/su-kien/{id}', 'Admin\HomeController@eventLoadByID');
Route::get('/thong-tin-ca-nhan', 'Admin\HomeController@myProfile');
Route::get('/danh-sach-chi-tra', 'Admin\PaymentController@getOfUser');
Route::get('/lich-su-benh-an', 'Admin\TreatmentHistoryController@showTreatmentHistory');
Route::get('/signOut', 'Admin\HomeController@logout');
Route::post('loginUser', 'Admin\PatientController@login')->name('admin.loginUser.post');
Route::get('changeCP/{id}', 'Admin\PatientController@changeCurrentPatient');
Route::post('/avatar-profile', 'Admin\PatientController@changeAvatar');
Route::get('/lien-he','Admin\HomeController@xxx');
Route::post('/create-appointment-user', 'Admin\AppointmentController@UserAppoinment');
// end webuser

Route::group(['prefix' => 'admin', 'middleware' => 'admins'], function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::group(['middleware' => 'superAdmin'], function () {

    });
    Route::group(['middleware' => 'dentist'], function () {
        //MedicineController
        Route::get('/get-list-medicines', 'Admin\MedicineController@getList');
        Route::get('/list-medicines', 'Admin\MedicineController@loadList')->name('admin.list.medicines');
        Route::get('/delete-medicines/{id}', 'Admin\MedicineController@delete');
        Route::get('/create-medicines', 'Admin\MedicineController@loadcreate')->name('admin.create.medicines');
        Route::post('/create-medicines', 'Admin\MedicineController@create');
        Route::get('/edit-medicines/{id}', 'Admin\MedicineController@loadedit');
        Route::post('/edit-medicines/{id}', 'Admin\MedicineController@edit')->name('admin.edit.medicines');
        //Patient
        Route::get('/appointment-detail/{id}', 'Admin\AppointmentController@detailAppointmentById');
        Route::get('/start-appointment/{id}', 'Admin\AppointmentController@startAppointmentController');

        //TreatmentController
        Route::get('/get-treatment/{id}', 'Admin\TreatmentController@getTreatmentByID');//ajax
        Route::get('/get-treatmentByCate/{id}', 'Admin\TreatmentController@getTreatmentByCategoryId');//ajax
        Route::get('/get-list-treatment', 'Admin\TreatmentController@getListTreatment');
        Route::get('/list-treatment', 'Admin\TreatmentController@loadListTreatment')->name('admin.list.treatment');
        Route::get('/delete-treatment/{id}', 'Admin\TreatmentController@delete');
        Route::get('/create-treatment', 'Admin\TreatmentController@loadcreate')->name('admin.create.treatment');
        Route::post('/create-treatment', 'Admin\TreatmentController@create');
        Route::get('/edit-treatment/{id}', 'Admin\TreatmentController@loadeditTreatment');
        Route::post('/edit-treatment/{id}', 'Admin\TreatmentController@edit')->name('admin.edit.treatment');
        //dentist


    });
    Route::group(['middleware' => 'receptionist'], function () {
        //NewsController
        Route::get('/create-news', 'Mobile\NewsController@loadcreateNews')->name('admin.create.news');
        Route::get('/get-list-news', 'Admin\NewsController@getList');
        Route::get('/edit-news/{id}', 'Admin\NewsController@loadEdit');
        Route::get('/list-news', 'Admin\NewsController@loadList')->name('admin.list.news');
        Route::get('/delete-news/{id}', 'Admin\NewsController@delete');
        Route::post('/create-news', 'Admin\NewsController@create');
        Route::post('/edit-news/{id}', 'Admin\NewsController@edit')->name('admin.edit.news');

        //AnamnesisController
        Route::get('/delete-anamnesis/{id}', 'Admin\AnamnesisController@delete');
        Route::get('/get-list-anamnesis', 'Admin\AnamnesisController@getList');
        Route::get('/list-anamnesis', 'Admin\AnamnesisController@loadList')->name('admin.list.anamnesis');
        Route::get('/create-anamnesis', 'Admin\AnamnesisController@loadcreate')->name('admin.create.anamnesis');
        Route::post('/create-anamnesis', 'Admin\AnamnesisController@create');
        Route::get('/edit-anamnesis/{id}', 'Admin\AnamnesisController@loadEdit');
        Route::post('/edit-anamnesis/{id}', 'Admin\AnamnesisController@edit')->name('admin.edit.anamnesis');

        //EventController
        Route::get('/get-list-event', 'Admin\EventController@getListEvent');
        Route::get('/list-event', 'Admin\EventController@loadListEvent')->name('admin.list.event');
        Route::get('/create-event', 'Admin\EventController@loadcreateEvent')->name('admin.create.event');
        Route::post('/create-event', 'Admin\EventController@create');
        Route::get('/delete-event/{id}', 'Admin\EventController@deleteEvent');
        Route::get('/edit-event/{id}', 'Admin\EventController@loadeditEvent');
        Route::post('/edit-event/{id}', 'Admin\EventController@edit')->name('admin.edit.event');
        //patient
        Route::post('/create-patient', 'Admin\PatientController@create');

        //payment
        Route::get('/get-payment-detail', 'Admin\PaymentController@getDetail')->name('getPaymentDetail');
        Route::get('/admin-payment', 'Admin\PaymentController@getList')->name('admin.payment');
        Route::get('/create-payment', 'Admin\PaymentController@viewCreate');
        Route::post('/create-payment', 'Admin\PaymentController@create')->name('create.payment');
        Route::get('/get-payment-detail', 'Admin\PaymentController@getDetail')->name('getPaymentDetail');
        Route::get('/search-payment/{searchValue}', 'Admin\PaymentController@search');

        //EventController
        Route::get('/get-list-event', 'Admin\EventController@getListEvent');
        Route::get('/list-event', 'Admin\EventController@loadListEvent')->name('admin.list.event');
        Route::get('/create-event', 'Admin\EventController@loadcreateEvent')->name('admin.create.event');
        Route::post('/create-event', 'Admin\EventController@create');
        Route::get('/delete-event/{id}', 'Admin\EventController@deleteEvent');
        Route::get('/edit-event/{id}', 'Admin\EventController@loadeditEvent');
        Route::post('/edit-event/{id}', 'Admin\EventController@edit')->name('admin.edit.event');
    });

    //UserController
//    Route::get('/register', 'Admin\Usercontroller@registerGet');
//    Route::post('/register', 'Admin\Usercontroller@registerPost');
    Route::get('/profile-staff', 'Admin\Staffcontroller@profile');
    //


    //FeedbackController  //FeedbackController
    Route::get('/delete-feedback/{id}', 'Admin\FeedbackController@delete');
    Route::get('/views-feedback/{id}', 'Admin\FeedbackController@getViewsFeedback')->name('admin.views.feedback');
    Route::get('/details-feedback/{id}', 'Admin\FeedbackController@getDetailsFeedback')->name('admin.details.feedback');
    Route::post('/details-feedback/{id}', 'Admin\FeedbackController@edit')->name('admin.edit.feedback');
    Route::get('/get-list-feedback', 'Admin\FeedbackController@getListFeedback');
    Route::get('/list-feedback', 'Admin\FeedbackController@loadListFeedback')->name('admin.list.feedback');

    //MedicineController
    Route::get('/get-list-medicines', 'Admin\MedicineController@getList');
    Route::get('/list-medicines', 'Admin\MedicineController@loadList')->name('admin.list.medicines');
    Route::get('/delete-medicines/{id}', 'Admin\MedicineController@delete');
    Route::get('/create-medicines', 'Admin\MedicineController@loadcreate')->name('admin.create.medicines');
    Route::post('/create-medicines', 'Admin\MedicineController@create');
    Route::get('/edit-medicines/{id}', 'Admin\MedicineController@loadedit');
    Route::post('/edit-medicines/{id}', 'Admin\MedicineController@edit')->name('admin.edit.medicines');
    //NurseW
    Route::get('/live-search', 'Admin\PatientController@index')->name('admin.AppointmentPatient.index');
    Route::get('/live-search/{searchValue}', 'Admin\PatientController@action1')->name('admin.AppointmentPatient.search');
    Route::get('/list-appointment/{id}', 'Admin\PatientController@receive')->name('admin.listAppointment.patient');
    //Treatment
    Route::get('/get-treatment-by-cate/{id}', 'Admin\TreatmentController@getTreatmentByCategoryId');


    Route::get('/medicine-search/{id}', 'Admin\MedicineController@ajaxSearch');

    Route::get('/prescription', 'Admin\MedicineController@createPrescriptionForTreatmentDetail')->name('prescription');

    //Patient
    Route::get('/thong-tin-benh-nhan/{id}', 'Admin\PatientController@getInfoPatientById');//ajax
    Route::get('/get-list-patient/{id}', 'Admin\PatientController@getListPatientById');//ajax
    // Route::get('/create-Patient', 'Admin\PatientController@create');
    //Dentist
    Route::get('/list-appointment', 'Admin\StaffController@viewAppointment')->name('admin.listAppointment.dentist');
    Route::get('/list-appointment-in-date', 'Admin\StaffController@viewAppointmentInDate')->name('admin.listAppointmentInDate.dentist');
    Route::get('/get-appointment', 'Admin\StaffController@getListAppointmentForStaff');
    Route::get('/get-dentist', 'Admin\StaffController@getStaff');
    Route::get('/create-dentist', 'Admin\StaffController@createStaff');
    Route::post('/create-dentist', 'Admin\StaffController@create');
    Route::get('/get-appointment-in-date', 'Admin\StaffController@getListAppointmentInDateForStaff');
    Route::get('/add-post', 'Admin\StaffController@addPost');
    Route::post('/edit-post', 'Admin\StaffController@editPost');
    Route::get('/delete-post', 'Admin\StaffController@deletePost');

    Route::get('/create-treatment/{id}', 'Admin\StaffController@createTreatmentByStaff')->name('create.treatmentHistory');
    Route::get('/check-coming/{id}', 'Admin\StaffController@checkComingPatient');
    Route::get('/check-done/{id}', 'Admin\AppointmentController@checkDone');
    Route::post('/create-treatment-history-patient', 'Admin\TreatmentHistoryController@createTreatmentHistory')->name('admin.createTreatmentHistoryPatient.dentist');
    Route::get('/get-treatment-history-patient/{id}', 'Admin\TreatmentHistoryController@getTreatmentHistoryByPatient');

    //Step
    Route::get('/step-treatment', 'Admin\StepController@create')->name('admin.stepTreatment'); //view
    Route::get('/treatment-history-detail/{id}', 'Admin\TreatmentDetailController@updateTreatmentDetail')->name('admin.stepTreatmentUpdate'); //view

    Route::post('/create-step', 'Admin\StepController@add');
    //Absent searchAbsent
    Route::get('/searchAbsent', 'Admin\AbsentController@searchAbsent'); //ajax search
    Route::get('/create-absent', 'Admin\AbsentController@loadcreate')->name('create.Absent');
    Route::post('/create-absent', 'Admin\AbsentController@create');
    Route::get('/manage-absent', 'Admin\AbsentController@loadView')->name('admin.Manage.Absent');
    Route::get('/get-list-absent', 'Admin\AbsentController@showListAbsentDatatable');//for staff
    Route::get('/delete-absent', 'Admin\AbsentController@deleteAbsent');
    Route::get('/get-list-absent-admin', 'Admin\AbsentController@showListAbsentDatatableAdmin');//for admin
    Route::post('/approve-absent', 'Admin\AbsentController@approve');
    Route::get('/valid-absent', 'Admin\AbsentController@count');
    Route::get('/admin-absent', 'Admin\AbsentController@changeView')->name('admin.absent');

    //TreatmentDetail
    Route::post('/create-treatment-detail', 'Admin\TreatmentDetailController@createTreatmentDetailController');//add
    Route::post('/update-step', 'Admin\TreatmentDetailController@update');//update
    Route::get('/treatment-detail/{id}', 'Admin\TreatmentDetailController@viewTreatmentDetailController');
    //appointment
    Route::post('/create-appointment', 'Admin\AppointmentController@add');
    Route::get('/create-appointment', 'Admin\StaffController@createAppointmentByStaff');//new Page


    //treatmentHistory
    Route::get('/treatment-history', 'Admin\TreatmentHistoryController@getList')->name('admin.treatmentHistory');
    Route::get('/get-treatment-history-detail', 'Admin\TreatmentHistoryController@getDetail')->name('gettreatmentHistoryDetail');


    //city
    Route::get('/get-district/{id}', 'Admin\PatientController@getDistrictbyCity');
    Route::get('/change-session', 'Admin\StaffController@changeSession');

});

Route::post('/api/call', 'Admin\PatientController@login')->name('user.login');


Route::get('/generateKey', 'BlockchainController@GenerateKey');
Route::get('/encrypt', 'BlockchainController@EncryptTreatmentHistory');


Route::post('/loginUser', 'Admin\PatientController@login')->name('user.login');

Route::get('/getTreatmentHistory', 'Admin\TreatmentHistoryController@showTreatmentHistory');
Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => 'users'], function () {
});

//CRUD news

// Route::post('/createNews', 'HomeController@createNews');
//end CRUD new
Route::get('/testFunction', 'Admin\AppointmentController@testFunction')->name('testFunction');
Route::get('/startTreatment', 'Admin\TreatmentController@startTreatment')->name('start.treatment');

//Route::get('paywithpaypal','Admin\PaypalController@payWithPaypal');
// route for post request
Route::get('paypal/{amount}/{id}', 'Admin\PaypalController@postPaymentWithpaypal')->name('paypal');
// route for check status responce
Route::get('paypal', 'Admin\PaypalController@getPaymentStatus')->name('status');

Route::get('not-permission', function () {
    return view('notPermission');
});

Route::get('/broadcastDentist', function () {
    return view('eventLis');
});

use App\Events\ReceiveAppointment;

Route::get('/broadcastReception', 'Admin\HomeController@testFunction');

//blockchain
Route::get('/addToQueue', 'Blockchain\QueueController@addToQueue');
Route::get('/saveNewLedger', 'Blochchain\BlockchainController@saveNewLedger');
Route::get('/checkStatus', 'Blockchain\QueueController@checkStatusOfRecord');
Route::get('/test', 'Blockchain\BlockchainController@test');
Route::get('/threadQueue', 'Blockchain\QueueController@threadQueue');

use App\Model\NodeInfo;
Route::get('/getAllNode', function (){
    return NodeInfo::all();
});
