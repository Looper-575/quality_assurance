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
Route::middleware(\App\Http\Middleware\EnsureLogin::class)->group(function () {
    //Routes for Users
    Route::get('/', 'App\Http\Controllers\DashboardController@default');
    Route::get('/home', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::get('/users', 'App\Http\Controllers\UserController@list')->name('users');
    Route::post('/user_form', 'App\Http\Controllers\UserController@user_form')->name('user_form');
    Route::post('/user_save', 'App\Http\Controllers\UserController@save')->name('user_save');
    Route::post('/user_delete', 'App\Http\Controllers\UserController@delete')->name('user_delete');
    Route::post('/change_password' , 'App\Http\Controllers\UserController@change_password')->name('change_password');
    //Routes for Roles
    Route::get('/roles_list', 'App\Http\Controllers\RolesController@list')->name('roles_list');
    Route::post('/save_role', 'App\Http\Controllers\RolesController@store')->name('roles_store');
    Route::post('/update_role', 'App\Http\Controllers\RolesController@update')->name('roles_update');
    Route::post('/delete_role', 'App\Http\Controllers\RolesController@delete')->name('roles_delete');
    // routes for Quality Assurance
    Route::get('/qa_form' ,'App\Http\Controllers\QAController@form')->name('qa_form');
    Route::post('/qa_save', 'App\Http\Controllers\QAController@save')->name('qa_save');
    Route::get('/qa_list', 'App\Http\Controllers\QAController@list')->name('qa_list');
    Route::post('/qa_single_data', 'App\Http\Controllers\QAController@show')->name('qa_single_data');
    //  routes for Lead
    Route::get('/lead_form', 'App\Http\Controllers\CallDispositionController@form')->name('lead_form');
    Route::post('/lead_save', 'App\Http\Controllers\CallDispositionController@save')->name('lead_save');
    Route::get('/lead_list' , 'App\Http\Controllers\CallDispositionController@list')->name('lead_list');
    Route::post('/lead_single_data' , 'App\Http\Controllers\CallDispositionController@show')->name('lead_single_data');
    Route::post('/lead_delete', 'App\Http\Controllers\CallDispositionController@delete')->name('lead_delete');
    Route::get('/lead_edit/{id}' , 'App\Http\Controllers\CallDispositionController@edit')->name('lead_edit');
    Route::post('/lead_update/{id}' , 'App\Http\Controllers\CallDispositionController@update')->name('lead_update');
    Route::post('/sale_made' , 'App\Http\Controllers\CallDispositionController@call_disposition_did')->name('sale_made');

    Route::post('/non_sale' , function (){
        return view('call_dipositions.partials.non_sale_form');
    })->name('non_sale');

    // Routes for leave application
    Route::get('/leave_form' , 'App\Http\Controllers\LeaveApplicationController@index')->name('leave_form');
    Route::post('/leave_save' , 'App\Http\Controllers\LeaveApplicationController@save')->name('leave_save');
    Route::get('/leave_list' , 'App\Http\Controllers\LeaveApplicationController@list')->name('leave_list');
//    Route::get('/leave_list' , 'App\Http\Controllers\LeaveApplicationController@list')->name('leave_list');
//    Route::post('/leave_edit/{id}' , 'App\Http\Controllers\LeaveApplicationController@edit')->name('leave_edit');

});

Route::get('/logout', 'App\Http\Controllers\UserController@logout')->name('logout');
Route::get('/login', 'App\Http\Controllers\UserController@index')->name('login');
Route::post('/do_login', 'App\Http\Controllers\UserController@login')->name('do_login');
Route::get('/', 'App\Http\Controllers\DashboardController@default');

