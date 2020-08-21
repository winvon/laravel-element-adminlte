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

    Route::get('user/login', 'LoginController@index')->name('login');
    Route::post('user/login', 'LoginController@login')->name('login.login');
    Route::get('user/temp', 'TempController@index')->name('user.temp.index');


    Route::get('user/role', 'RoleController@index')->name('role.index');
    Route::get('user/role/{id}', 'RoleController@show')->name('role.show');
    Route::put('user/role/{id}', 'RoleController@update')->name('role.update');
    Route::post('user/role', 'RoleController@store')->name('role.store');

    Route::get('user/menu', 'MenuController@index')->name('menu.index');
    Route::post('user/menu', 'MenuController@store')->name('menu.store');
    Route::put('user/menu/{id}', 'MenuController@update')->name('menu.update');

    Route::get('user/user', 'UserController@index')->name('user.index');
    Route::get('user/user/{id}', 'UserController@show')->name('user.show');
    Route::put('user/user/{id}', 'UserController@update')->name('user.update');
});

