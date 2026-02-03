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

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/blood', 'BloodController@index')->name('blood');
Route::get('/profile', 'BloodController@profile')->name('profile');
Route::get('/setting', 'BloodController@setting')->name('setting');

