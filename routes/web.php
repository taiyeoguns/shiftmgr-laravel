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

Auth::routes();

Route::get('/', function () {
    return view('home');
});

Route::get('/shifts', 'ShiftController@index')->name('shifts.index');
Route::post('/shifts', 'ShiftController@store')->name('shifts.store');
Route::get('/shifts/{shift}', 'ShiftController@show')->name('shifts.show');
