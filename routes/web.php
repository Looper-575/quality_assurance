<?php

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
Route::get('/user_roles', 'App\Http\Controller\UserController@test');
Route::middleware(\App\Http\Middleware\EnsureLogin::class)->group(function () {
    Route::get('/home', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::get('/users', 'App\Http\Controllers\UserController@list')->name('users');
    Route::get('/user_roles', 'App\Http\Controllers\RolesController@list')->name('roles_list');
    // Route::post('/user_roles/{id}', 'App\Http\Controllers\RolesController@edit')->name('roles_edit');
    Route::post('/user_roles', 'App\Http\Controllers\RolesController@store')->name('roles_store');
    Route::post('/update_role', 'App\Http\Controllers\RolesController@update')->name('roles_update');
    Route::get('/roles_delete{id}', 'App\Http\Controllers\RolesController@delete')->name('roles_delete');
    // routes for Quality Assurance
     Route::get('/quality_assurance' ,'App\Http\Controllers\QAController@list')->name('qa_list');
  
});



Route::get('/logout', 'App\Http\Controllers\UserController@logout')->name('logout');
Route::get('/login', 'App\Http\Controllers\UserController@index')->name('login');
Route::post('/do_login', 'App\Http\Controllers\UserController@login')->name('do_login');

