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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::namespace('User')->name('user.')->group(function () {
    Route::get('user/temp', 'TempController@index')->name('user.temp.index');
    Route::get('user/login', 'LoginController@index')->name('login');
    Route::post('user/login', 'LoginController@login')->name('login.login');
    Route::get('user/menu', 'MenuController@index')->name('menu.index');
    Route::post('user/menu', 'MenuController@store')->name('menu.store');
});

