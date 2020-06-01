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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/front/mypage');
});
Route::get('/admin', function () {
    return redirect('/admin/home');
});

Route::get('/top_admin', function () {
    return redirect('/top_admin/home');
});

Auth::routes();

// Super Admin page no login
Route::group(['prefix' => 'top_admin', 'namespace' => 'TopAdmin', 'as' => 'top_admin.'], function () {
    Route::get('/', function () {
        return redirect('/top_admin/school');
    });
    Route::get('login', 'Auth\TopAdminLoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\TopAdminLoginController@login')->name('login.post');
});

// Super Admin page login
Route::group(['as' => 'top_admin.', 'namespace' => 'TopAdmin', 'middleware' => 'auth:topadmin', 'prefix' => 'top_admin'], function () {
    // Route::resource('school', 'SchoolController')->except(['show']);
    Route::get('/school', 'SchoolController@create')->name('school.create');
    Route::post('/school/create_confirm', 'SchoolController@createConfirm')->name('school.create_confirm');
    Route::post('/school/store', 'SchoolController@store')->name('school.store');
   
    
    Route::get('/school/detail/{id}', 'SchoolController@detail')->name('school.detail');
    // Route::post('/school/update/{id}', 'SchoolController@update')->name('school.update');
    Route::delete('/school/destroy', 'SchoolController@destroy')->name('school.destroy');

    Route::get('/school/index', 'SchoolController@index')->name('school.index');

    Route::get('/school/edit/{id}', 'SchoolController@edit')->name('school.edit');
    Route::post('/school/edit_confirm/{school}', 'SchoolController@editConfirm')->name('school.edit_confirm');
    Route::post('/school/update/{school}', 'SchoolController@update')->name('school.update');

    Route::post('/school/school_code/{id}', 'SchoolController@updateSchoolCode')->name('school.school_code');
    
    Route::get('/setting', 'TopAdminSettingController@changePassword')->name('setting.index');
    Route::post('/setting/reset_password', 'TopAdminSettingController@resetPassword')->name('setting.reset_password');
    
    Route::get('/calendar', 'CalendarController@calendar')->name('calendar.index');
    Route::post('/calendar/create', 'CalendarController@create')->name('calendar.create');
    Route::get('/calendar/edit_calendar', 'CalendarController@edit')->name('calendar.edit_calendar');
    Route::post('/calendar/edit_calendar/update/{id}', 'CalendarController@update')->name('calendar.edit_calendar.update');
    Route::post('/calendar/edit_calendar/destroy/{id}', 'CalendarController@destroy')->name('calendar.edit_calendar.destroy');

    Route::post('/logout', 'Auth\TopAdminLoginController@logout')->name('logout');

    //Route::resource('holiday', 'Admin\HolidayController');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return redirect('/admin/home');
    });
    Route::get('/login', 'Admin\Auth\SchoolLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\Auth\SchoolLoginController@login')->name('admin.login.post');
});

Route::group(['middleware' => 'auth:schooladmin', 'prefix' => 'admin'], function () {
    // Admin page
    Route::get('/home', 'Admin\HomeController@index')->name('home');
    //Route::get('/logout', 'Admin\Auth\SchoolLoginController@logout')->name('logout');
    Route::post('/logout', 'Admin\Auth\SchoolLoginController@logout')->name('logout');

    Route::group(['as' => 'admin.', 'namespace' => 'Admin'], function () {
        // お手紙

        Route::get('letter/{letter_id}/class/{class}', 'LetterController@class')->name('letter.class');
        Route::get('letter/{letter}/class', 'LetterController@classes')->name('letter.classes');

        Route::get('letter/{letter}/students', 'LetterController@students')->name('letter.students');

        Route::get('letter/scheduling', 'LetterController@scheduling')->name('letter.scheduling');

        Route::get('letter/select_people', 'LetterController@showSelectPeople')->name('letter.select_people');
        Route::post('letter/confirm/{letter?}', 'LetterController@confirm')->name('letter.confirm');
        Route::resource('letter', 'LetterController');

        // お知らせ
        Route::post('message/confirm/{message?}', 'MessageController@confirm')->name('message.confirm');
        Route::get('message/sent_list', 'MessageController@sentList')->name('message.sent_list');
        Route::resource('message', 'MessageController');

        // 回答必要通知
        Route::post('require_feedback/confirm/{requireFeedback?}', 'RequireFeedbackController@confirm')->name('require_feedback.confirm');
        Route::get('require_feedback/list', 'RequireFeedbackController@list')->name('require_feedback.list');
        Route::get('require_feedback/{require_feedback}/class/{class}', 'RequireFeedbackController@class')->name('require_feedback.class');
        Route::get('require_feedback/{require_feedback}/class/{class}/search', 'RequireFeedbackController@search')->name('require_feedback.class.search');
        Route::get('require_feedback/{require_feedback}/class', 'RequireFeedbackController@classes')->name('require_feedback.classes');
        Route::resource('require_feedback', 'RequireFeedbackController');

        Route::post('teacher/confirm/{teacher?}', 'TeacherController@confirm')->name('teacher.confirm');
        Route::get('teacher/list', 'TeacherController@list')->name('teacher.list');
        Route::resource('teacher', 'TeacherController');

        // リサイクル 未作成
        Route::post('recycle/confirm/{recycleProduct?}', 'RecycleController@confirm')->name('recycle.confirm');
        Route::post('recycle/massDelete', 'RecycleController@massDelete')->name('recycle.massDelete');
        Route::get('recycle/admin', 'RecycleController@admin')->name('recycle.admin');
        Route::resource('recycle', 'RecycleController');
        Route::resource('recycle_place', 'RecyclePlaceController')->only(['store']);

        // 連絡網
        Route::get('contact/class/{schoolClass}', 'ContactController@class')->name('contact.class');
        Route::post('contact/massDelete', 'ContactController@massDelete')->name('contact.massDelete');

        Route::resource('contact', 'ContactController')->only('index');

        // クラスグループ設定
        Route::post('cgroup/delete-multi', 'ClassGroupController@deleteMulti')->name('cgroup.delete-multi');
        Route::post('cgroup/confirm/{classGroup?}', 'ClassGroupController@confirm')->name('cgroup.confirm');
        Route::resource('cgroup', 'ClassGroupController');

        Route::post('department_setting/confirm/{department?}', 'DepartmentSettingController@confirm')->name('department_setting.confirm');
        Route::get('department_setting/list-department', 'DepartmentSettingController@showList')->name('department_setting.list-department');
        Route::resource('department_setting', 'DepartmentSettingController');

        // クラス一覧
        Route::post('class/{class}/passcode', 'ClassController@passcode')->name('class.passcode');
        Route::resource('class', 'ClassController');

        // 生徒登録設定
        Route::post('student_setting/class/{schoolClass}/import', 'StudentSettingController@import')->name('student_setting.import');
        Route::post('student_setting/class/{schoolClass}/verify', 'StudentSettingController@verify')->name('student_setting.verify');
        Route::get('student_setting/class/{schoolClass}/confirm', 'StudentSettingController@confirm')->name('student_setting.confirm');

        Route::get('student_setting/class/{schoolClass}', 'StudentSettingController@viewClass')->name('student_setting.class');

        Route::delete('student_setting/delete', 'StudentSettingController@massDelete')->name('student_setting.massDelete');
        Route::resource('student_setting', 'StudentSettingController')->only(['index', 'store']);

        // 講座
        Route::post('seminar/confirm/{seminar?}', 'SeminarController@confirm')->name('seminar.confirm');

        Route::resource('seminar', 'SeminarController');

        Route::get('meeting/{meeting_id}/class/{class}', 'MeetingController@class')->name('meeting.class');
        Route::get('meeting/{meeting}/class', 'MeetingController@classes')->name('meeting.classes');

        Route::get('meeting/{meeting}/students', 'MeetingController@students')->name('meeting.students');

        Route::get('meeting/scheduling', 'MeetingController@scheduling')->name('meeting.scheduling');

        Route::get('meeting/select_people', 'MeetingController@showSelectPeople')->name('meeting.select_people');

        Route::post('meeting/confirm/{meeting?}', 'MeetingController@confirm')->name('meeting.confirm');
        Route::resource('meeting', 'MeetingController');

        Route::post('school_event/confirm/{schoolEvent?}', 'SchoolEventController@confirm')->name('school_event.confirm');

        Route::resource('school_event', 'SchoolEventController');

        Route::get('urgent_contact', 'SeminarController@index')->name('urgent_contact.index');

        // カレンダー
        Route::resource('calendar', 'CalendarController')->only(['index']);
        Route::resource('event', 'EventController')->except(['index']);

        // 学校設定
        Route::get('school_setting', 'SchoolSettingController@index')->name('school_setting.index');
        Route::post('school_setting/update/{id}', 'SchoolSettingController@update')->name('school_setting.update');

        Route::resource('year_close', 'YearCloseController'); //dummy class
    });

    // Route::resource('corporate', 'Admin\CorporateController');

    Route::resource('admin_setting', 'Admin\AdminSettingController');

//    Route::get('mock/require_feedback/confirm', 'Admin\RequireFeedbackController@showConfirm')->name('require_feedback.confirm');
//    Route::get('mock/require_feedback/store', 'Admin\RequireFeedbackController@showComplete')->name('require_feedback.store');

    // Route::resource('recycle', 'Admin\RecycleController'); //dummy class
    // Route::resource('mock/student_setting', 'Admin\StudentSettingController'); //dummy class
    // Route::resource('admin_setting', 'Admin\AdminSettingController'); //dummy class
    // Route::resource('department_setting', 'Admin\DepartmentSettingController'); //dummy class

    // Route::resource('mock/advertises', 'Admin\AdvertisesController'); //dummy class
    // Route::post('mock/advertises/create', 'Admin\AdvertisesController@store')->name('advertises.store');
    // Route::get('mock/advertises/edit/{id}', 'Admin\AdvertisesController@edit')->name('advertises.edit');
    // Route::post('mock/advertises/edit/{id}', 'Admin\AdvertisesController@update')->name('advertises.update');
//    Route::post('mock/advertises/destroy/{id}','Admin\AdvertisesController@destroy')->name('advertises.destroy');
});

Route::group(['prefix' => 'front'], function () {
    Route::get('/register', 'Front\Auth\RegisterController@index')->name('register.index');
    Route::get('/register/school-passcode', 'Front\Auth\RegisterController@schoolPassCode')->name('register.schoolpasscode');
    Route::post('/register/school-passcode', 'Front\Auth\RegisterController@postSchoolPassCode')->name('register.schoolpasscode.post');

    Route::get('/register/passcode', 'Front\Auth\RegisterController@passCode')->name('register.passcode');
    Route::post('/register/passcode', 'Front\Auth\RegisterController@postPassCode')->name('register.passcode.post');
    Route::get('/register/email', 'Front\Auth\RegisterController@inputEmail')->name('register.email');
    Route::post('/register/email', 'Front\Auth\RegisterController@postEmail')->name('register.email.post');
    Route::get('/register/password/{id}', 'Front\Auth\RegisterController@inputPassword')->name('register.password');
    Route::post('/register/password', 'Front\Auth\RegisterController@postPassword')->name('register.password.post');
    Route::get('/register/success', 'Front\Auth\RegisterController@success')->name('register.success');
    Route::get('/register/faq', 'Front\Auth\RegisterController@showGuide')->name('register.faq');

    Route::get('/login', 'Front\Auth\CustomerLoginController@showLoginForm')->name('customer.login');
    Route::post('/login', 'Front\Auth\CustomerLoginController@login')->name('customer.login.post');
    Route::get('/logout', 'Front\Auth\CustomerLoginController@logout')->name('customer.logout');

    Route::get('forget-password', 'Front\ResetPasswordController@forgetPassword')->name('customer.forget-password');
    Route::post('reset-password', 'Front\ResetPasswordController@sendMail')->name('customer.resetpassword.post');
    Route::get('reset-password/{token}', 'Front\ResetPasswordController@inputPassword')->name('customer.change-password');
    Route::post('reset-password/{token}', 'Front\ResetPasswordController@reset')->name('customer.reset-password.post');

    Route::get('email/resend', 'Front\Auth\VerificationController@resend')->name('verification.resend');
    Route::get('email/verify', 'Front\Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}', 'Front\Auth\VerificationController@verify')->name('verification.verify');

    Route::get('email-contact', 'Front\MailController@index')->name('email-contact');
    Route::post('email-contact', 'Front\MailController@postEmail')->name('email-contact.post');
    Route::group(['middleware' => ['parents', 'verified.parents']], function () {
        Route::get('/regist-device-token', 'Front\RegistDeviceTokenController@store');

        Route::get('choose-school', 'Front\SchoolController@chooseSchool')->name('front.school.choose');
        Route::get('passcode-school', 'Front\SchoolController@schoolPassCode')->name('front.school.passcodeschool');
        Route::post('passcode-school', 'Front\SchoolController@postSchoolPassCode')->name('front.school.passcodeschool.post');
        Route::get('passcode-student', 'Front\SchoolController@studentPassCode')->name('front.school.passcodestudent');
        Route::post('passcode-student', 'Front\SchoolController@postStudentPassCode')->name('front.school.passcodestudent.post');

        Route::get('/', function () {
            return redirect()->route('front.mypage.index');
        });

        Route::get('/mypage', 'Front\MyPageController@index')->name('front.mypage.index');
        Route::get('/letters/view/{student_id}/{id}', 'Front\LetterController@view')->name('front.letters.view');
        Route::get('/letters/{student_id}/{status?}', 'Front\LetterController@index')->name('front.letters.index');
        Route::post('letter/updateLetterType', 'Front\LetterController@updateLetterType')->name('front.letter.updateLetterType');
        Route::post('letter/deleteOneLetter', 'Front\LetterController@deleteOneLetter')->name('front.letter.deleteLetter');
        Route::post('letter/removeLetterFavorite', 'Front\LetterController@removeLetterFavorite')->name('front.letter.removeLetterFavorite');
        Route::post('letter/removeLetterTrash', 'Front\LetterController@removeLetterTrash')->name('front.letter.removeLetterTrash');

        Route::get('/notification/{student_id}', 'Front\NotificationController@index')->name('front.notification.index');

        Route::get('action-choose-school/{school_id}', 'Front\SchoolController@actionChooseSchool')->name('front.school.action');
        Route::get('lang/{lang}', 'Front\LanguageController@index')->name('front.mypage.lang');
        Route::get('setting', 'Front\SettingController@index')->name('setting');
        Route::get('class', 'Front\ClassController@index')->name('class');

        Route::get('/departments', 'Front\DepartmentController@index')->name('departments.index');
        Route::get('/departments/student/{student_id}', 'Front\DepartmentController@getList')->name('departments.list');
        Route::post('/departments/success', 'Front\DepartmentController@success')->name('departments.success');

        Route::get('setting', 'Front\SettingController@index')->name('setting.index');
        Route::post('setting/success', 'Front\SettingController@success')->name('setting.success');

        Route::get('contact/student/', 'Front\ContactController@index')->name('front.contact.index');
        Route::get('contact/student/{studentId}', 'Front\ContactController@getList')->name('front.contact.list');
        Route::get('contact/student/{studentId}/create', 'Front\ContactController@create')->name('front.contact.create');
        Route::post('contact/student/{studentId}/complete', 'Front\ContactController@complete')->name('front.contact.complete');
        Route::get('contact/student/{currentStudentId}/show/{studentId}', 'Front\ContactController@show')->name('front.contact.show');
        Route::get('contact/student/{studentId}/edit/{contactId}', 'Front\ContactController@edit')->name('front.contact.edit');
        Route::post('contact/student/{studentId}/edit/{contactId}/save', 'Front\ContactController@save')->name('front.contact.save');
        Route::delete('contact/student/{studentId}/edit/{contactId}/delete', 'Front\ContactController@delete')->name('front.contact.delete');

        Route::get('attendance/{studentId}', 'Front\AttendanceController@attendance')->name('front.student.attendance');
        Route::get('absence/{studentId}', 'Front\AttendanceController@absence')->name('front.student.absence');
        Route::post('attendance/{studentId}/complete', 'Front\AttendanceController@complete')->name('front.attendance.complete');
        Route::get('attendance/{attendanceId}/success', 'Front\AttendanceController@success')->name('front.attendance.success');

        Route::get('require_feedback/{studentId}/list', 'Front\RequireFeedbackController@getList')->name('front.require_feedback.list');
        Route::post('require_feedback/{studentId}/confirm/{feedbackId}', 'Front\RequireFeedbackController@success')->name('front.require_feedback.success');
        Route::get('qa/complete', 'Front\QaController@complete')->name('front.qa.complete');
        Route::get('qa/reask', 'Front\QaController@reAsk')->name('front.qa.reask');

        //Route::get('help', 'Front\HelpController@index')->name('help');
        Route::get('subject', 'Front\SubjectController@index')->name('subject');
        Route::get('subject/create', 'Front\SubjectController@create')->name('subject.create');

        Route::get('calendar', 'Front\CalendarController@index')->name('front.calendar.index');
        Route::get('calendar/share', 'Front\CalendarController@share')->name('front.calendar.share');
        Route::post('calendar/share', 'Front\CalendarController@shareSave')->name('front.calendar.share-save');
        Route::get('calendar/edit', 'Front\CalendarController@edit')->name('front.calendar.edit');
        Route::patch('calendar/updatetheme', 'Front\CalendarController@updateTheme')->name('front.calendar.updatetheme');
        Route::get('calendar/uploadimage/{id}', 'Front\CalendarController@uploadImage')->name('front.calendar.uploadimage');
        Route::post('calendar/storeimage/{id}', 'Front\CalendarController@storeImage')->name('front.calendar.storeimage');
        Route::get('calendar/filter-complete', 'Front\CalendarController@filterComplete')->name('front.calendar.filter-complete');
        Route::get('calendar/usereventcreate/{date?}/', 'Front\CalendarController@userEventCreate')->name('front.calendar.usereventcreate');
        Route::patch('calendar/usereventstore', 'Front\CalendarController@userEventStore')->name('front.calendar.usereventstore');
        Route::get('calendar/usereventedit/{id}', 'Front\CalendarController@userEventEdit')->name('front.calendar.usereventedit');
        Route::post('calendar/usereventupdate/{id}', 'Front\CalendarController@userEventUpdate')->name('front.calendar.usereventupdate');
        Route::post('calendar/usereventdestroy/{id}', 'Front\CalendarController@userEventDestroy')->name('front.calendar.usereventdestroy');
        Route::post('calendar/usereventclick', 'Front\CalendarController@showEventByClickCalendar')->name('front.calendar.usereventclick');
        Route::get('calendar/showeventbymonth', 'Front\CalendarController@showEventByMonth')->name('front.calendar.showeventbymonth');
        Route::get('calendar/event-detail/{id}', 'Front\CalendarController@eventDetail')->name('front.calendar.event-detail');
        Route::get('student', 'Front\StudentController@index')->name('student.index');
        Route::get('student/passcodeschool', 'Front\StudentController@passcodeSchool')->name('student.passcodeschool');
        Route::post('student/passcodeschool', 'Front\StudentController@postSchoolPassCode')->name('student.postpasscodeschool');
        Route::get('student/passcode', 'Front\StudentController@passcodeShow')->name('student.passcode');
        Route::post('student/completepasscode', 'Front\StudentController@passcodeComplete')->name('student.passcodecomplete');
        Route::get('student/showedit', 'Front\StudentController@showEdit')->name('student.showedit');
        Route::patch('student/confirmedit/{id}', 'Front\StudentController@confirmEdit')->name('student.confirmedit');
        Route::get('student/confirmdelete/{id}', 'Front\StudentController@confirmDelete')->name('student.confirmdelete');
        Route::patch('student/update/{id}', 'Front\StudentController@update')->name('student.update');
        Route::get('student/edit/{id}', 'Front\StudentController@edit')->name('student.edit');
        Route::delete('student/destroy/{id}', 'Front\StudentController@destroy')->name('student.destroy');

        Route::get('recycle/notice', 'Front\RecycleController@notice')->name('front.recycle.notice');
        Route::get('recycle/provide', 'Front\RecycleController@provide')->name('front.recycle.provide.index');
        Route::post('recycle/provide/cancel/{id}', 'Front\RecycleController@cancelProvide')->name('front.recycle.provide.cancel');
        Route::post('recycle/provide/delete/{id}', 'Front\RecycleController@deleteProvide')->name('front.recycle.provide.delete');
        Route::get('recycle/provide/confirm/{id}', 'Front\RecycleController@confirmProvide')->name('front.recycle.provide.confirm');
        Route::post('recycle/provide/confirm/{id}', 'Front\RecycleController@confirmProvidePost')->name('front.recycle.provide.confirm.post');
        Route::get('recycle/listprovide', 'Front\RecycleController@listProvide')->name('recycle.listprovide');
        Route::get('recycle/listreceive', 'Front\RecycleController@listReceive')->name('recycle.listreceive');
        Route::get('recycle/listpace/{id}', 'Front\RecycleController@listPlace')->name('recycle.listpace');
        Route::get('recycle/showPlace/{id}', 'Front\RecycleController@showPlace')->name('recycle.showPlace');
        Route::get('recycle-product/register', 'Front\RecycleController@productRegister')->name('recycle.productregister');
        Route::get('recycle-product/remove-done', 'Front\RecycleController@productDelete')->name('recycle.productDelete');
        Route::get('recycle-product', 'Front\RecycleController@productStatus')->name('recycle.productstatus');
        Route::get('recycle/{id}/show', 'Front\RecycleController@showProduct')->name('front.recycle.show');
        Route::post('recycle/{id}/apply', 'Front\RecycleController@apply')->name('front.recycle.apply');
        Route::get('recycle-product/create', 'Front\RecycleController@productCreate')->name('recycle.productcreate');
        Route::get('recycle-product/edit/{id}', 'Front\RecycleController@productEdit')->name('recycle.productEdit');
        Route::post('recycle-product/store', 'Front\RecycleController@productStore')->name('recycle.product.store');
        Route::patch('recycle-product/update/{id}', 'Front\RecycleController@productUpdate')->name('recycle.product.update');
        Route::get('recycle-product/form-sent', 'Front\RecycleController@productComplete')->name('recycle.product.sent');
        Route::get('recycle-product/completeForm', 'Front\RecycleController@UpdateComplete')->name('recycle.product.complete');
        Route::get('recycle/confirm_register/{id}', 'Front\RecycleController@confirmRegister')->name('recycle.confirm_register');
        Route::post('recycle/confirm_recycle/{id}', 'Front\RecycleController@confirmRecycle')->name('recycle.confirmRecycle');
        Route::get('recycles/product/{id}/date-carry', 'Front\RecycleController@dateCarry')->name('front.recycle.product.confirm-date');
        Route::post('recycles/product/{id}/confirm-date', 'Front\RecycleController@confirmDateCarry')->name('front.recycle.product.confirm-date-post');
        // Route::get('recycles/product/{id}/confirm-date', 'Front\RecycleController@confirmDateCarry')->name('front.recycle.product.confirm-date');
        Route::post('recycles/product/{id}/success-date-carry', 'Front\RecycleController@successDateCarry')->name('front.recycle.product.success-date-post');

        // seminar
        Route::get('seminar/index/{school_id}', 'Front\SeminarController@index')->name('seminar.index');
        Route::get('seminar/calendar/{school_id}', 'Front\SeminarController@calendar')->name('seminar.calendar');
        Route::post('seminar/usereventclick', 'Front\SeminarController@showEventByClickCalendar')->name('seminar.usereventclick');
        Route::get('seminar/seminarbymonth', 'Front\SeminarController@seminarByMonth')->name('seminar.seminarbymonth');
        Route::get('seminar/seminarbyday', 'Front\SeminarController@seminarByDay')->name('seminar.seminarbyday');
        Route::get('seminar/detail/{id}', 'Front\SeminarController@detail')->name('seminar.detail');
        Route::post('seminar/savejoin/{id}', 'Front\SeminarController@saveJoinSeminar')->name('seminar.savejoin');
        //Route::post('seminar/savehelp/{id}', 'Front\SeminarController@saveHelp')->name('seminar.savehelp');
        Route::get('seminar/register', 'Front\SeminarController@getSeminarRegister')->name('seminar.register');
        Route::get('seminar/not-register', 'Front\SeminarController@getSeminarNotRegister')->name('seminar.not-register');

        // school event
        Route::get('schoolevent/index/{school_id}', 'Front\SchoolEventController@index')->name('schoolevent.index');
        Route::get('schoolevent/calendar/{school_id}', 'Front\SchoolEventController@calendar')->name('schoolevent.calendar');
        Route::post('schoolevent/usereventclick', 'Front\SchoolEventController@showEventByClickCalendar')->name('schoolevent.usereventclick');
        Route::get('schoolevent/eventbymonth', 'Front\SchoolEventController@eventByMonth')->name('schoolevent.eventbymonth');
        Route::get('schoolevent/eventbyday', 'Front\SchoolEventController@eventByDay')->name('schoolevent.eventbyday');
        Route::get('schoolevent/detail/{id}', 'Front\SchoolEventController@detail')->name('schoolevent.detail');
        Route::post('schoolevent/savejoin/{id}', 'Front\SchoolEventController@saveJoinEvent')->name('schoolevent.savejoin');
        //Route::post('schoolevent/savehelp/{id}', 'Front\SchoolEventController@saveHelp')->name('schoolevent.savehelp');
        Route::get('schoolevent/register', 'Front\SchoolEventController@getEventRegister')->name('schoolevent.register');
        Route::get('schoolevent/not-register', 'Front\SchoolEventController@getEventNotRegister')->name('schoolevent.not-register');

        Route::get('/emergencies/student-questions-category/{student_id}', 'Front\EmergencyController@questionStudentCategory')->name('emergency.student-questions-category');
        Route::get('/emergencies/student-questions/{contact_id}/{student_id}', 'Front\EmergencyController@studentQuestion')->name('emergency.student-questions');
        Route::post('/emergencies/student-questions/{student_id}', 'Front\EmergencyController@saveStudentAnswer')->name('emergency.student-question.post');
        Route::post('/emergencies/student-answer-confirm/{contact_id}/{student_id}', 'Front\EmergencyController@confirmStudentAnswer')->name('emergency.student-answer-confirm');

    });
});

// for urgent contacts /緊急連絡用（先生、学校側）
Route::group(['prefix' => 'app-admin'], function () {
    Route::get('/top', function () {
        return 'app-admin/top';
    });
});

Route::group(['prefix' => 'urgency'], function () {
    // Emergency Notification
    Route::get('/login', 'Front\Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
    Route::post('/login', 'Front\Auth\TeacherLoginController@login')->name('teacher.login.post');
    Route::get('/logout', 'Front\Auth\TeacherLoginController@logout')->name('teacher.logout');
});

// for urgent contacts /緊急連絡用（先生、学校側）
Route::group(['prefix' => 'urgency', 'middleware' => 'auth:teacher'], function () {
    Route::view('/top', 'front.emergencies.top')->name('emergency.top');
    Route::get('/emergencies/create', 'Front\EmergencyController@create')->name('emergency.create');
    Route::post('/emergencies/review', 'Front\EmergencyController@review')->name('emergency.review');
    Route::post('/emergencies/', 'Front\EmergencyController@store')->name('emergency.store');
    Route::get('/emergencies/form-sent', 'Front\EmergencyController@complete')->name('emergency.complete');

    Route::get('/emergencies', 'Front\EmergencyController@index')->name('emergency.index');
    Route::get('/emergencies/{emergency_id}', 'Front\EmergencyController@showClasses')
        ->where(['emergency_id' => '[0-9]+'])->name('emergency.show');
    Route::get('/emergencies/{emergency_id}/classes/{class_id}', 'Front\EmergencyController@showQuestions')
        ->where(['emergency_id' => '[0-9]+', 'class_id' => '[0-9]+'])->name('emergency.class.show');
    Route::get('/emergencies/{emergency_id}/classes/{class_id}/questions/{question_id}', 'Front\EmergencyController@showAnswers')
        ->where(['emergency_id' => '[0-9]+', 'class_id' => '[0-9]+'])->name('emergency.question.show');
});

// for static page
Route::group(['prefix' => 'option'], function () {
    Route::get('/guide', function () {
        return \File::get(public_path().'/option/guide.html');
    });
    Route::get('/agreement', function () {
        return \File::get(public_path().'/option/agreement.html');
    });
    Route::get('/version', function () {
        return \File::get(public_path().'/option/version.html');
    });
    Route::get('/tokusho', function () {
        return \File::get(public_path().'/option/tokusho.html');
    });
    Route::get('/privacy-policy', function () {
        return \File::get(public_path().'/option/privacy-policy.html');
    });
});
