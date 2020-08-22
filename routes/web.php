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


Route::namespace('User')->prefix('user')->name('user.')->group(function () {

    Route::get('login', 'LoginController@index')->name('login');
    Route::post('login', 'LoginController@login')->name('login.login');
    Route::get('temp', 'TempController@index')->name('user.temp.index');


    Route::get('role', 'RoleController@index')->name('role.index');
    Route::get('role/list', 'RoleController@list')->name('role.list');
    Route::get('role/create', 'RoleController@index')->name('role.create');
    Route::get('role/{id}', 'RoleController@show')->name('role.show');
    Route::put('role/{id}', 'RoleController@update')->name('role.update');
    Route::delete('role/{id}', 'RoleController@destroy')->name('role.destroy');
    Route::post('role', 'RoleController@store')->name('role.store');

    Route::get('menu', 'MenuController@index')->name('menu.index');
    Route::post('menu', 'MenuController@store')->name('menu.store');
    Route::put('menu/{id}', 'MenuController@update')->name('menu.update');

    Route::get('user', 'UserController@index')->name('user.index');
    Route::get('user/create', 'UserController@index')->name('user.create');
    Route::post('user/store', 'UserController@store')->name('user.store');
    Route::get('user/{id}', 'UserController@show')->name('user.show');
    Route::put('user/{id}', 'UserController@update')->name('user.update');
});

