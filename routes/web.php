<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
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

Route::get('/route-cache', function() {
    Cache::flush();
    return 'Routes cache cleared';
});

Route::get('/logout', 'App\Http\Controllers\UserController@logout')->name('logout');
Route::get('/login', 'App\Http\Controllers\UserController@index')->name('login');
Route::post('/do_login', 'App\Http\Controllers\UserController@login')->name('do_login');


Route::middleware(\App\Http\Middleware\EnsureLogin::class)->group(function () {
    //Routes for dashboard ///
    Route::get('', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::get('/vendor_dashboard', 'App\Http\Controllers\DashboardController@vendor_dashboard')->name('vendor_dashboard');

    // Users
    Route::group(['middleware' => ['check-permission:users,view,0,0']], function() {
        Route::get('/users', 'App\Http\Controllers\UserController@list')->name('users');
    });
    Route::post('/user_form', 'App\Http\Controllers\UserController@user_form')->name('user_form');
    Route::post('/user_save', 'App\Http\Controllers\UserController@save')->name('user_save');
    Route::post('/change_password' , 'App\Http\Controllers\UserController@change_password')->name('change_password');
    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/user_delete', 'App\Http\Controllers\UserController@delete')->name('user_delete');
    });
    //Routes for Roles //////////////////////
    Route::group(['middleware' => ['check-permission:roles_list,view,0,0']], function() {
        Route::get('/roles_list', 'App\Http\Controllers\SettingsController@user_roles_list')->name('roles_list');
    });
    Route::group(['middleware' => ['check-permission:roles_list,0,add,update']], function() {
        Route::post('/save_role', 'App\Http\Controllers\SettingsController@user_roles_save')->name('roles_save');
    });
    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/delete_role', 'App\Http\Controllers\SettingsController@user_roles_delete')->name('roles_delete');
    });
    // Routes for Quality Assurance /////////////////
    Route::group(['middleware' => ['check-permission:qa_list,view,0,0']], function() {
        Route::get('/qa_list', 'App\Http\Controllers\QAController@qa_queue')->name('qa_list');
        Route::post('/qa_single_data', 'App\Http\Controllers\QAController@show')->name('qa_single_data');
        Route::get('/qa_queue','App\Http\Controllers\QAController@qa_queue')->name('qa_queue');
        Route::post('/qa_report_single_data' , 'App\Http\Controllers\QAController@show_single_qa')->name('qa_report_single_data');
    });
    Route::group(['middleware' => ['check-permission:qa_list,0,add,0']], function() {
        Route::get('/qa_form' ,'App\Http\Controllers\QAController@form')->name('qa_form');
        Route::get('/qa_add/{id}','App\Http\Controllers\QAController@qa_add')->name('qa_add');
    });
    Route::post('/qa_save', 'App\Http\Controllers\QAController@save')->name('qa_save');
    Route::group(['middleware' => ['check-permission:roles_list,0,0,update']], function() {
        Route::get('/qa_edit/{id}' , 'App\Http\Controllers\QAController@edit')->name('qa_edit');
    });
    Route::post('/filter_nums' , 'App\Http\Controllers\CallDispositionController@filter_nums')->name('filter_nums');
    //  Routes for Lead ///////////////////////////
    Route::group(['middleware' => ['check-permission:lead_list,view,0,0']], function() {
        Route::get('/lead_list' , 'App\Http\Controllers\CallDispositionController@list')->name('lead_list');
    });
    Route::get('/lead_form', 'App\Http\Controllers\CallDispositionController@form')->name('lead_form');
    Route::post('/lead_save', 'App\Http\Controllers\CallDispositionController@save')->name('lead_save');
    Route::post('/lead_single_data' , 'App\Http\Controllers\CallDispositionController@show')->name('lead_single_data');

    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/lead_delete', 'App\Http\Controllers\CallDispositionController@delete')->name('lead_delete');
    });
    Route::group(['middleware' => ['check-permission:lead_list,0,0,update']], function() {
        Route::get('/lead_edit/{id}' , 'App\Http\Controllers\CallDispositionController@edit')->name('lead_edit');
        Route::post('/lead_update/{id}' , 'App\Http\Controllers\CallDispositionController@update')->name('lead_update');
    });
    Route::post('/sale_made' , 'App\Http\Controllers\CallDispositionController@call_disposition_did')->name('sale_made');
    Route::post('/non_sale' , 'App\Http\Controllers\CallDispositionController@did_non_sale')->name('non_sale');
    Route::group(['middleware' => ['check-permission:call_queue,view,0,0']], function() {
        Route::get('/call_queue' , 'App\Http\Controllers\RecordingController@recordings')->name('call_queue');
    });
    Route::group(['middleware' => ['check-permission:call_queue,0,add,0']], function() {
        Route::get('/dispose/{id}','App\Http\Controllers\RecordingController@dispose')->name('dispose');
    });
    // routes for lead types form /////////////////////////////////
    Route::group(['middleware' => ['check-permission:lead_types_list,view,0,0']], function() {
        Route::get('/lead_types_list' , 'App\Http\Controllers\SettingsController@disposition_type_list')->name('lead_types_list');
    });
    Route::group(['middleware' => ['check-permission:lead_types_list,0,add,update']], function() {
        Route::post('/lead_types_save' , 'App\Http\Controllers\SettingsController@disposition_type_save')->name('lead_types_save');
    });
    Route::post('/lead_types_delete' , 'App\Http\Controllers\SettingsController@disposition_type_delete')->name('lead_types_delete');
    // Routes for Lead DID
    Route::group(['middleware' => ['check-permission:lead_did_list,view,0,0']], function() {
        Route::get('/lead_did_list' , 'App\Http\Controllers\SettingsController@did_list')->name('lead_did_list');
    });
    Route::group(['middleware' => ['check-permission:lead_did_list,0,add,update']], function() {
        Route::post('/lead_did_save' , 'App\Http\Controllers\SettingsController@did_save')->name('lead_did_save');
    });
    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/lead_did_delete' , 'App\Http\Controllers\SettingsController@did_delete')->name('lead_did_delete');
    });
    // Routes for Lead Report
    Route::group(['middleware' => ['check-permission:lead_report,view,0,0']], function() {
        Route::get('/lead_report' , 'App\Http\Controllers\ReportController@disposition_report_form')->name('lead_report');
        Route::post('/generate_disposition_report' , 'App\Http\Controllers\ReportController@generate_disposition_report')->name('generate_disposition_report');
    });
    // Routes for leave application //////////////////////////////////
    Route::group(['middleware' => ['check-permission:leave_list,0,add,0']], function() {
        Route::get('/leave_form' , 'App\Http\Controllers\LeaveApplicationController@index')->name('leave_form');
        Route::get('/team_leave_form' , 'App\Http\Controllers\LeaveApplicationController@team_leave_form')->name('team_leave_form');
    });
    Route::post('/team_leave_save' , 'App\Http\Controllers\LeaveApplicationController@team_leave_save')->name('team_leave_save');
    Route::group(['middleware' => ['check-permission:leave_list,0,add,update']], function() {
        Route::post('/leave_save' , 'App\Http\Controllers\LeaveApplicationController@save')->name('leave_save');
    });
    Route::post('/leave_reject','App\Http\Controllers\LeaveApplicationController@reject')->name('leave_reject');
    Route::post('/leave_approve','App\Http\Controllers\LeaveApplicationController@approve')->name('leave_approve');
    Route::post('/leave_delete', 'App\Http\Controllers\LeaveApplicationController@delete')->name('leave_delete');
    Route::group(['middleware' => ['check-permission:leave_list,view,0,0']], function() {
        Route::get('/leave_list' , 'App\Http\Controllers\LeaveApplicationController@list')->name('leave_list');
    });
    Route::group(['middleware' => ['check-permission:leave_list,0,0,update']], function() {
        Route::get('/leave_form_edit/{id}' , 'App\Http\Controllers\LeaveApplicationController@edit')->name('leave_form_edit');
    });
    //Routes For Sales Transfer
    Route::group(['middleware' => ['check-permission:sales_transfer_list,view,0,0']], function() {
        Route::get('/sales_transfer_list' , 'App\Http\Controllers\SalesTransferController@list')->name('sales_transfer_list');
    });
    Route::group(['middleware' => ['check-permission:sales_transfer_list,0,add,0']], function() {
        Route::get('/sales_transfer_form' , 'App\Http\Controllers\SalesTransferController@index')->name('sales_transfer_form');
        Route::post('/transfer_save','App\Http\Controllers\SalesTransferController@transfer_save')->name('transfersave');
        Route::post('/sales_made' , 'App\Http\Controllers\SalesTransferController@sales_made')->name('salesmade');
    });
    Route::post('/sales_transfer_reject','App\Http\Controllers\SalesTransferController@reject')->name('sales_transfer_reject');
    Route::post('/sales_transfer_approve','App\Http\Controllers\SalesTransferController@approve')->name('sales_transfer_approve');

    // attendance
    Route::group(['middleware' => ['check-permission:attendance,view,0,0']], function() {
        Route::get('/attendance','App\Http\Controllers\AttendanceController@attendance')->name('attendance');
    });
    Route::group(['middleware' => ['check-permission:attendance,0,add,update']], function() {
        Route::post('/mark_attendance' , 'App\Http\Controllers\AttendanceController@mark_attendance')->name('mark_attendance');
        Route::get('/get_manager_attendance/{id}','App\Http\Controllers\AttendanceController@get_manager_attendance')->name('get_manager_attendance');
    });
    Route::group(['middleware' => ['check-permission:check_attendance,view,0,0']], function() {
        Route::get('/check_attendance','App\Http\Controllers\AttendanceController@check_attendance')->name('check_attendance');
    });
    Route::post('/check_back_date_attendance','App\Http\Controllers\AttendanceController@check_back_date_attendance')->name('check_back_date_attendance');
    Route::post('/creat_back_date_attendance','App\Http\Controllers\AttendanceController@creat_back_date_attendance')->name('creat_back_date_attendance');
    Route::get('/fill_attendance_time_out','App\Http\Controllers\AttendanceController@fill_attendance_time_out')->name('fill_attendance_time_out');

    // shift route
    Route::group(['middleware' => ['check-permission:shift,view,0,0']], function() {
        Route::get('/shift','App\Http\Controllers\ShiftController@index')->name('shift');
    });
    Route::group(['middleware' => ['check-permission:shift,0,add,update']], function() {
        Route::post('/save_shift_form','App\Http\Controllers\ShiftController@save_shift')->name('save_shift_form');
    });
    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/shift_delete', 'App\Http\Controllers\ShiftController@shift_delete')->name('shift_delete');
    });
    // Note route
    Route::post('/save_todo_form', 'App\Http\Controllers\NoteController@save_todo_form')->name('save_todo_form');
    Route::get('/get_pending_todos', 'App\Http\Controllers\NoteController@get_pending_todos')->name('get_pending_todos');
    Route::get('/get_done_todos', 'App\Http\Controllers\NoteController@get_done_todos')->name('get_done_todos');
    Route::post('/delete_todo_form', 'App\Http\Controllers\NoteController@delete_todo_form')->name('delete_todo_form');
    Route::post('/make_done_todo', 'App\Http\Controllers\NoteController@make_done_todo')->name('make_done_todo');
    Route::post('/save_note_form', 'App\Http\Controllers\NoteController@save_note_form')->name('save_note_form');
    Route::get('/get_note_data', 'App\Http\Controllers\NoteController@get_note_data')->name('get_note_data');
    Route::post('/delete_note_form', 'App\Http\Controllers\NoteController@delete_note_form')->name('delete_note_form');
    Route::get('/single_note_data/{id}', 'App\Http\Controllers\NoteController@single_note_data')->name('single_note_data');
    // Team route
    Route::group(['middleware' => ['check-permission:department,view,0,0']], function() {
        Route::get('/department', 'App\Http\Controllers\DepartmentController@index')->name('department');
    });
    Route::group(['middleware' => ['check-permission:department,0,add,update']], function() {
        Route::post('/team_type_save', 'App\Http\Controllers\DepartmentController@team_type_save')->name('team_type_save');
    });
    Route::post('/team_type_delete', 'App\Http\Controllers\DepartmentController@team_type_delete')->name('team_type_delete');
    // Team route
    Route::group(['middleware' => ['check-permission:team_list,view,0,0']], function() {
        Route::get('/team_list', 'App\Http\Controllers\TeamController@team_list')->name('team_list');
    });
    Route::group(['middleware' => ['check-permission:team_list,0,add,0']], function() {
        Route::get('/team_create', 'App\Http\Controllers\TeamController@team_create')->name('team_create');
    });
    Route::group(['middleware' => ['check-permission:team_list,0,add,update']], function() {
        Route::post('/team_save', 'App\Http\Controllers\TeamController@team_save')->name('team_save');
        Route::get('/add_member_in_team/{id}' , 'App\Http\Controllers\TeamController@add_member')->name('add_member_in_team');
        Route::post('/save_add_member_form', 'App\Http\Controllers\TeamController@save_add_member_form')->name('save_add_member_form');
    });
    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/team_delete', 'App\Http\Controllers\TeamController@team_delete')->name('team_delete');
    });
    Route::get('/get_manager_agents/{id}' , 'App\Http\Controllers\TeamController@get_manager_agents')->name('get_manager_agents');
    // company policy
    Route::group(['middleware' => ['check-permission:policies,view,0,0']], function() {
        Route::get('/company_policies' , 'App\Http\Controllers\SettingsController@company_policies')->name('policies');
    });
    Route::group(['middleware' => ['check-permission:policies,0,add,update']], function() {
        Route::post('/policies_file_upload' , 'App\Http\Controllers\SettingsController@policies_file_upload')->name('policies_file_upload');
    });
    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/policy_delete' , 'App\Http\Controllers\SettingsController@policy_delete')->name('policy_delete');
    });
    // holidays
    Route::group(['middleware' => ['check-permission:holiday,view,0,0']], function() {
        Route::get('/holiday','App\Http\Controllers\HolidayController@index')->name('holiday');
    });
    Route::group(['middleware' => ['check-permission:holiday,0,add,update']], function() {
        Route::post('/save_holiday' , 'App\Http\Controllers\HolidayController@save_holiday')->name('save_holiday');
    });
    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/holiday_delete', 'App\Http\Controllers\HolidayController@holiday_delete')->name('holiday_delete');
    });
    //reports
    Route::group(['middleware' => ['check-permission:qa_report_form,view,0,0']], function() {
        Route::get('/qa_report_form' , 'App\Http\Controllers\ReportController@qa_report_form')->name('qa_report_form');
        Route::post('/generate_qa_report' , 'App\Http\Controllers\ReportController@generate_qa_report')->name('generate_qa_report');
    });
    Route::group(['middleware' => ['check-permission:attendance_report_monthly,view,0,0']], function() {
        Route::get('/attendance_report_monthly','App\Http\Controllers\ReportController@attendance_report_monthly')->name('attendance_report_monthly');
        Route::post('/generate_monthly_attendance_report' , 'App\Http\Controllers\ReportController@generate_monthly_attendance_report')->name('generate_monthly_attendance_report');
    });
    Route::group(['middleware' => ['check-permission:attendance_report_single,view,0,0']], function() {
        Route::get('/attendance_report_single','App\Http\Controllers\ReportController@attendance_report_single')->name('attendance_report_single');
        Route::post('/generate_single_attendance_report' , 'App\Http\Controllers\ReportController@generate_single_attendance_report')->name('generate_single_attendance_report');
    });
    Route::group(['middleware' => ['check-permission:did_report,view,0,0']], function() {
        Route::get('/did_report','App\Http\Controllers\ReportController@did_report_form')->name('did_report');
        Route::post('/generate_did_report','App\Http\Controllers\ReportController@generate_did_report')->name('generate_did_report');
    });
    //side menus
    Route::get('/side_menu','App\Http\Controllers\MenuController@index')->name('side_menu');
    Route::post('/save_side_menu','App\Http\Controllers\MenuController@save')->name('save_side_menu');
    Route::post('/menu_delete','App\Http\Controllers\MenuController@delete')->name('menu_delete');
    // permissions
    Route::group(['middleware' => ['check-permission:permissions,view,0,0']], function() {
        Route::get('/permissions','App\Http\Controllers\PermissionController@index')->name('permissions');
    });
    Route::group(['middleware' => ['check-permission:permissions,0,add,0']], function() {
        Route::get('/add_permissions','App\Http\Controllers\PermissionController@form')->name('add_permissions');
    });
    Route::post('/save_permissions','App\Http\Controllers\PermissionController@save')->name('save_permissions');
    Route::group(['middleware' => ['check-permission:permissions,0,0,update']], function() {
        Route::get('/edit_permissions/{id}','App\Http\Controllers\PermissionController@edit')->name('edit_permissions');
    });
    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/permission_delete','App\Http\Controllers\PermissionController@delete')->name('permission_delete');
    });
    //Chat
    Route::group(['middleware' => ['check-permission:chat,view,0,0']], function() {
        Route::get('/chat','App\Http\Controllers\ChatController@chat')->name('chat');
    });
    Route::get('/access_denied','App\Http\Controllers\PermissionController@access_denied')->name('access_denied');
});


