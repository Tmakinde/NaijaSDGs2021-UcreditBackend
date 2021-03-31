<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/creditrating/user/create', 'App\Http\Controllers\HomeController@createUser')->name('usedr.create');
Route::get('/creditrating/user/info', 'App\Http\Controllers\HomeController@getUser')->name('user.retrive');
Route::post('/creditrating/user/update', 'App\Http\Controllers\HomeController@updateUser')->name('user.update');

Route::post('/creditrating/business/create', 'App\Http\Controllers\HomeController@createBusiness')->name('business.create');
Route::get('/creditrating/business/info', 'App\Http\Controllers\HomeController@getBusiness')->name('business.retrive');
Route::post('/creditrating/business/update', 'App\Http\Controllers\HomeController@updateBusiness')->name('business.update');
