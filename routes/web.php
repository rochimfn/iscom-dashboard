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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/pages', 'PageController@index')->name('pages.index');
Route::get('/pages/create', 'PageController@create')->name('pages.create');
Route::get('/pages/{slug}/edit', 'PageController@edit')->name('pages.edit');
Route::delete('/pages/{id}', 'PageController@destroy')->name('pages.destroy');
Route::post('/pages', 'PageController@store')->name('pages.store');
Route::put('/pages/{slug}/', 'PageController@update')->name('pages.update');
Route::post('/upload/images', 'PageController@uploadImage')->name('pages.image');


Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/home/members', 'UserController@create')->name('users.create');
Route::delete('/users/{id}', 'UserController@destroy')->name('users.destroy');
Route::post('/users', 'UserController@store')->name('users.store');
Route::put('/users/{id}/', 'UserController@update')->name('users.update');
Route::get('/home/password/change', 'UserController@changePasswordForm')->name('change.passowrd');
Route::put('/home/password/', 'UserController@updatePassword')->name('update.password');
Route::get('/home/settings', 'UserController@changeProfile')->name('change.profile');
Route::put('/home/settings', 'UserController@updateProfile')->name('update.profile');


Route::get('/users/dosen', 'UserController@indexDosen')->name('users.dosen.index');
Route::delete('/users/dosen/{id}', 'UserController@destroyDosen')->name('users.dosen.destroy');
Route::post('/users/dosen', 'UserController@storeDosen')->name('users.dosen.store');
Route::put('/users/dosen/{id}/', 'UserController@updateDosen')->name('users.dosen.update');

Route::get('/users', 'UserController@index')->name('users.index');
Route::auth();
