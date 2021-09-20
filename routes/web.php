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
Route::get('/', 'App\Http\Controllers\MainController@index')->name('home');
Route::get('/contact-us', 'App\Http\Controllers\MainController@contact')->name('contact');
Route::get('/about-us', 'App\Http\Controllers\MainController@about')->name('about');
Route::get('/how-we-work', 'App\Http\Controllers\MainController@how_we_work')->name('how_we_work');
Route::get('/privacy-policy', 'App\Http\Controllers\MainController@privacy_policy')->name('policy');

Route::post('/submit_property_form', 'App\Http\Controllers\MainController@submit_property_form')->name('submit_property_form');
Route::post('/submit_contact_form', 'App\Http\Controllers\MainController@submit_contact_form')->name('submit_contact_form');
