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
    Route::get('/provider_dashboard', 'App\Http\Controllers\DashboardController@provider_dashboard')->name('provider_dashboard');
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
    Route::post('/change_pass' , 'App\Http\Controllers\UserController@change_pass')->name('change_pass');

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
    Route::get('rec_download/{recordings}', 'App\Http\Controllers\QAController@rec_download')->name('rec_download');
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
    Route::post('/save_note_draft', 'App\Http\Controllers\NoteController@save_note_draft')->name('save_note_draft');
    Route::get('/get_draft_note_data', 'App\Http\Controllers\NoteController@get_draft_note_data')->name('get_draft_note_data');
    // Team routes
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
    // atlantis routes
    Route::group(['middleware' => ['check-permission:chat_atlantis,view,0,0']], function() {
        Route::get('/chat_atlantis','App\Http\Controllers\AtlantisController@chat_atlantis')->name('chat_atlantis');
    });
    Route::get('/atlantis_leads','App\Http\Controllers\AtlantisController@leads')->name('atlantis_leads');
    Route::get('/atlantis_chat_settings','App\Http\Controllers\AtlantisController@chat_settings')->name('atlantis_chat_settings');


    Route::get('/access_denied','App\Http\Controllers\PermissionController@access_denied')->name('access_denied');
    Route::get('/edit_profile','App\Http\Controllers\UserController@edit_profile')->name('edit_profile');
    Route::post('/save_profile_changes','App\Http\Controllers\UserController@save_profile_changes')->name('save_profile_changes');


    Route::group(['middleware' => ['check-permission:modules_list,view,0,0']], function() {
        Route::get('modules_list', 'App\Http\Controllers\ModuleController@modules_list')->name('modules_list');
        Route::get('single_module_detail/{id}', 'App\Http\Controllers\ModuleController@single_module_detail')->name('single_module_detail');
    });
    Route::group(['middleware' => ['check-permission:modules_list,0,add,0']], function() {
        Route::get('module_form/{id?}', 'App\Http\Controllers\ModuleController@module_form')->name('module_form');
    });
    Route::group(['middleware' => ['check-permission:modules_list,0,0,update']], function() {
        Route::get('/projects_list', 'App\Http\Controllers\ProjectController@projects_list')->name('projects_list');
        Route::post('/project_delete', 'App\Http\Controllers\ProjectController@project_delete')->name('project_delete');
        Route::post('/project_save', 'App\Http\Controllers\ProjectController@project_save')->name('project_save');
    });

    Route::post('save_module_info', 'App\Http\Controllers\ModuleController@save_module_info')->name('save_module_info');
    Route::post('approve_module', 'App\Http\Controllers\ModuleController@approve_module')->name('approve_module');
    Route::post('project_modules', 'App\Http\Controllers\ModuleController@project_modules')->name('project_modules');



    Route::get('/managerial_role','App\Http\Controllers\SettingsController@managerial_role')->name('managerial_role');
    Route::post('/managerial_role_save','App\Http\Controllers\SettingsController@managerial_role_save')->name('managerial_role_save');
    Route::post('/managerial_role_delete','App\Http\Controllers\SettingsController@managerial_role_delete')->name('managerial_role_delete');
    Route::get('/check_managerial_role','App\Http\Controllers\SettingsController@check_managerial_role')->name('check_managerial_role');

    Route::get('rec_download/{recordings}', 'App\Http\Controllers\QAController@rec_download')->name('rec_download');

    //    Employee Routes
    Route::get('/employees', 'App\Http\Controllers\EmployeeController@index')->name('employees');
    Route::get('/employee_form_wizard', 'App\Http\Controllers\EmployeeController@employee_form')->name('employee_form');
    Route::post('/employee_save', 'App\Http\Controllers\EmployeeController@employee_info_save')->name('employee_save');
    Route::post('/employee_delete', 'App\Http\Controllers\EmployeeController@delete')->name('employee_delete');
    Route::post('/employee_education_save', 'App\Http\Controllers\EmployeeController@employee_education_save')->name('employee_education_save');
    Route::post('/employee_experience_save', 'App\Http\Controllers\EmployeeController@employee_experience_save')->name('employee_experience_save');
    Route::post('/employee_family_save', 'App\Http\Controllers\EmployeeController@employee_family_save')->name('employee_family_save');
    Route::post('/employee_emergency_contact_save', 'App\Http\Controllers\EmployeeController@employee_emergency_contact_save')->name('employee_emergency_contact_save');
    Route::post('/employee_company_reference_save', 'App\Http\Controllers\EmployeeController@employee_company_reference_save')->name('employee_company_reference_save');
    Route::post('/employee_docs_save', 'App\Http\Controllers\EmployeeController@employee_docs_save')->name('employee_docs_save');
    Route::post('/employees_docs_edit', 'App\Http\Controllers\EmployeeController@employees_docs_edit')->name('employees_docs_edit');
    Route::post('/employee_doc_delete', 'App\Http\Controllers\EmployeeController@employee_doc_delete')->name('employee_doc_delete');
    Route::post('/lock_employee_record', 'App\Http\Controllers\EmployeeController@lock_employee_record')->name('lock_employee_record');
    Route::get('/get_employee_data', 'App\Http\Controllers\EmployeeController@get_employee_data')->name('get_employee_data');
    Route::get('/employee_data_view', 'App\Http\Controllers\EmployeeController@employee_data_view')->name('employee_data_view');
    Route::post('/employees_personal_info_edit', 'App\Http\Controllers\EmployeeController@employees_personal_info_edit')->name('employees_personal_info_edit');
    Route::post('/employees_education_info_edit', 'App\Http\Controllers\EmployeeController@employees_education_info_edit')->name('employees_education_info_edit');
    Route::post('/employees_experience_info_edit', 'App\Http\Controllers\EmployeeController@employees_experience_info_edit')->name('employees_experience_info_edit');
    Route::post('/employees_family_info_edit', 'App\Http\Controllers\EmployeeController@employees_family_info_edit')->name('employees_family_info_edit');
    Route::post('/employees_emergency_contact_info_edit', 'App\Http\Controllers\EmployeeController@employees_emergency_contact_info_edit')->name('employees_emergency_contact_info_edit');
    Route::post('/employees_company_reference_info_edit', 'App\Http\Controllers\EmployeeController@employees_company_reference_info_edit')->name('employees_company_reference_info_edit');

    // Performance Improvement Plans ROUTES
    Route::get('/performance_improvement_plan', 'App\Http\Controllers\PIPController@index')->name('performance_improvement_plan');
    Route::get('/pip_form', 'App\Http\Controllers\PIPController@pip_form')->name('pip_form');
    Route::post('/pip_save', 'App\Http\Controllers\PIPController@pip_save')->name('pip_save');
    Route::get('/view_pip', 'App\Http\Controllers\PIPController@view_pip')->name('view_pip');
    Route::post('/hrm_approve_pip', 'App\Http\Controllers\PIPController@hrm_approve_pip')->name('hrm_approve_pip');
    Route::post('/staff_ack_pip_with_comments', 'App\Http\Controllers\PIPController@staff_ack_pip_with_comments')->name('staff_ack_pip_with_comments');
    Route::post('/staff_ack_pip', 'App\Http\Controllers\PIPController@staff_ack_pip')->name('staff_ack_pip');
    Route::get('/get_om_users_data', 'App\Http\Controllers\PIPController@get_om_users_data')->name('get_om_users_data');

    // Employee Assessment Routes
    Route::get('/employee_assessment', 'App\Http\Controllers\EmployeeAssessmentController@index')->name('employee_assessment');
    Route::get('/employee_assessment_form', 'App\Http\Controllers\EmployeeAssessmentController@employee_assessment_form')->name('employee_assessment_form');
    Route::post('/employee_assessment_save', 'App\Http\Controllers\EmployeeAssessmentController@employee_assessment_save')->name('employee_assessment_save');
    Route::get('/view_employee_assessment', 'App\Http\Controllers\EmployeeAssessmentController@view_employee_assessment')->name('view_employee_assessment');
    Route::get('/get_employee_details', 'App\Http\Controllers\EmployeeAssessmentController@get_employee_details')->name('get_employee_details');
    Route::get('/schedule_self_assessment', 'App\Http\Controllers\EmployeeAssessmentController@schedule_self_assessment')->name('schedule_self_assessment');

    // Notification Tray
    Route::get('/get_pending_notifications', 'App\Http\Controllers\NotificationsController@get_pending_notifications')->name('get_pending_notifications');
    Route::get('/read_notification', 'App\Http\Controllers\NotificationsController@read_notification')->name('read_notification');
    Route::get('/clear_all_notifications', 'App\Http\Controllers\NotificationsController@clear_all_notifications')->name('clear_all_notifications');

    // Notification Types
    Route::get('/notification_types', 'App\Http\Controllers\NotificationsController@index')->name('notification_types');
    Route::post('/notification_type_form', 'App\Http\Controllers\NotificationsController@notification_type_form')->name('notification_type_form');
    Route::post('/notification_type_save', 'App\Http\Controllers\NotificationsController@notification_type_save')->name('notification_type_save');
    Route::post('/view_notification_type', 'App\Http\Controllers\NotificationsController@view_notification_type')->name('view_notification_type');

    // vendors
    Route::group(['middleware' => ['check-permission:vendors,view,0,0']], function() {
        Route::get('/vendors', 'App\Http\Controllers\UserController@vendors_list')->name('vendors');
    });
    Route::post('/vendor_form', 'App\Http\Controllers\UserController@vendor_form')->name('vendor_form');
    Route::post('/vendor_save', 'App\Http\Controllers\UserController@vendor_save')->name('vendor_save');
    Route::group(['middleware' => ['is-admin']], function() {
        Route::post('/vendor_delete', 'App\Http\Controllers\UserController@delete')->name('vendor_delete');
        Route::post('/vendor_change_password' , 'App\Http\Controllers\UserController@change_password')->name('vendor_change_password');
    });
    // Leave Bucket
    Route::group(['middleware' => ['check-permission:leaves_bucket,view,0,0']], function() {
        Route::get('/leaves_bucket', 'App\Http\Controllers\LeavesBucketController@index')->name('leaves_bucket');
        Route::get('/leaves_bucket_form', 'App\Http\Controllers\LeavesBucketController@leaves_bucket_form')->name('leaves_bucket_form');
        Route::post('/leaves_bucket_save', 'App\Http\Controllers\LeavesBucketController@leaves_bucket_save')->name('leaves_bucket_save');
        Route::get('/view_leaves_bucket', 'App\Http\Controllers\LeavesBucketController@view_leaves_bucket')->name('view_leaves_bucket');
        Route::post('/get_employee_leaves_bucket', 'App\Http\Controllers\LeaveApplicationController@get_employee_leaves_bucket')->name('get_employee_leaves_bucket');
    });
    Route::group(['middleware' => ['check-permission:leaves_taken_report_monthly,view,0,0']], function() {
        Route::get('/leaves_taken_report_monthly','App\Http\Controllers\ReportController@leaves_taken_report_monthly')->name('leaves_taken_report_monthly');
    });
    Route::post('/generate_monthly_leaves_taken_report' , 'App\Http\Controllers\ReportController@generate_monthly_leaves_taken_report')->name('generate_monthly_leaves_taken_report');

    // Payroll routes
    Route::get('/create_payroll','App\Http\Controllers\PayrollController@create_payroll')->name('create_payroll');
    Route::post('/generate_pay_role','App\Http\Controllers\PayrollController@generate_pay_role')->name('generate_pay_role');
    Route::post('/payroll_save','App\Http\Controllers\PayrollController@payroll_save')->name('payroll_save');
    Route::post('/payroll_save_edit','App\Http\Controllers\PayrollController@payroll_save_edit')->name('payroll_save_edit');
    Route::get('/payroll_details','App\Http\Controllers\PayrollController@payroll_details')->name('payroll_details');
    Route::post('/payroll_reject','App\Http\Controllers\PayrollController@payroll_reject')->name('payroll_reject');
    Route::post('/payroll_approve','App\Http\Controllers\PayrollController@payroll_approve')->name('payroll_approve');
    Route::get('payroll_edit/{payroll_id}','App\Http\Controllers\PayrollController@payroll_edit')->name('payroll_edit');
    //     Deduction routes
    Route::get('/deduction','App\Http\Controllers\PayrollController@deduction')->name('deduction');
    Route::post('/save_deduction_form','App\Http\Controllers\PayrollController@save_deduction_form')->name('save_deduction_form');
    Route::post('/deduction_delete','App\Http\Controllers\PayrollController@deduction_delete')->name('deduction_delete');
    //      Allowance routes
    Route::get('/allowance','App\Http\Controllers\PayrollController@allowance')->name('allowance');
    Route::post('/save_allowance_form','App\Http\Controllers\PayrollController@save_allowance_form')->name('save_allowance_form');
    Route::post('/allowance_delete','App\Http\Controllers\PayrollController@allowance_delete')->name('allowance_delete');

    Route::get('/get_department_role','App\Http\Controllers\PayrollController@get_department_role')->name('get_department_role');
    //    Tax deduction routes
    Route::get('/tax_deduction','App\Http\Controllers\PayrollController@tax_deduction')->name('tax_deduction');
    Route::post('/save_tax_deduction_form','App\Http\Controllers\PayrollController@save_tax_deduction_form')->name('save_tax_deduction_form');
    Route::post('/tax_deduction_delete','App\Http\Controllers\PayrollController@tax_deduction_delete')->name('tax_deduction_delete');
    //    Call dispostions types routes
    Route::get('/call_dispositions_types','App\Http\Controllers\SettingsController@call_dispositions_types')->name('call_dispositions_types');
    Route::post('/call_dispositions_types_save','App\Http\Controllers\SettingsController@call_dispositions_types_save')->name('call_dispositions_types_save');
    Route::get('/call_dispositions_types_delete','App\Http\Controllers\SettingsController@call_dispositions_types_delete')->name('call_dispositions_types_delete');
    //    Payslips
    Route::get('/payslips', 'App\Http\Controllers\PayrollController@payslips')->name('payslips');
    Route::post('/view_payslip', 'App\Http\Controllers\PayrollController@view_payslip')->name('view_payslip');
    //    Convenience allowance routes
    Route::get('/convenience_allowance', 'App\Http\Controllers\PayrollController@convenience_allowance')->name('convenience_allowance');
    Route::post('/add_convenience_allowance', 'App\Http\Controllers\PayrollController@add_convenience_allowance')->name('add_convenience_allowance');
    Route::post('/remove_convenience_allowance', 'App\Http\Controllers\PayrollController@remove_convenience_allowance')->name('remove_convenience_allowance');

    Route::post('/get_customer_info', 'App\Http\Controllers\CallDispositionController@get_customer_info')->name('get_customer_info');
    Route::post('/save_customer_note', 'App\Http\Controllers\CallDispositionController@save_customer_note')->name('save_customer_note');


    //Chat Component
    Route::post('/create_group', 'App\Http\Controllers\ChatController@create_group')->name('create_group');

});
