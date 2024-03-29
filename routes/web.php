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

Route::get('name', function () {
    return \App\User::first()->name;
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('notes', function () {
        return view('notes');
    });
});
