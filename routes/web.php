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

Route::get('/{any}', 'ApplicationController')->where('any', '.*');
// Route::get('/users', ['as' => 'users', 'uses' => 'UserController@users']);
// Route::get('/user-detail/{id}', ['as' => 'user.detail', 'uses' => 'UserController@useDetail']);
