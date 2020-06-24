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


// Routes for Administrator
Route::middleware(['auth','admin'])->group( function() {
	Route::get('/dashboard/pages', 'PageController@index')->name('admin.pages.index');
	Route::get('/dashboard/pages/create', 'PageController@create')->name('admin.pages.create');
	Route::get('/dashboard/pages/{slug}/edit', 'PageController@edit')->name('admin.pages.edit');
	Route::delete('/dashboard/pages/{id}', 'PageController@destroy')->name('admin.pages.destroy');
	Route::post('/dashboard/pages', 'PageController@store')->name('admin.pages.store');
	Route::put('/dashboard/pages/{slug}/', 'PageController@update')->name('admin.pages.update');
	Route::post('/upload/images', 'PageController@uploadImage')->name('admin.pages.image');

	Route::get('/dashboard/users/dosen', 'UserController@indexDosen')->name('admin.users.dosen.index');
	Route::delete('/dashboard/users/dosen/{id}', 'UserController@deleteDosen')->name('admin.users.dosen.delete');
	Route::post('/dashboard/users/dosen', 'UserController@storeDosen')->name('admin.users.dosen.store');
	Route::put('/dashboard/users/dosen/{id}/', 'UserController@updateDosen')->name('admin.users.dosen.update');
	Route::get('/dashboard/users', 'UserController@indexParticipants')->name('admin.users.participants.index');

	Route::get('/dashboard/settings', 'UserController@changeAdminProfile')->name('admin.change.profile');
	Route::put('/dashboard/settings', 'UserController@updateAdminProfile')->name('admin.update.profile');
	Route::get('/dashboard/password/change', 'UserController@changePasswordForm')->name('change.passowrd');
	Route::put('/dashboard/password/', 'UserController@updatePassword')->name('update.password');
});


//Route Dosen
Route::middleware(['auth','dosen'])->group( function() {
	Route::get('/home/dosen/settings', 'UserController@changeDosenProfile')->name('dosen.change.profile');
	Route::put('/home/dosen/settings', 'UserController@updateDosenProfile')->name('dosen.update.profile');
	Route::get('/home/dosen/password/change', 'UserController@changePasswordForm')->name('change.passowrd');
	Route::put('/home/dosen/password/', 'UserController@updatePassword')->name('update.password');
});


//Routes untuk participants
Route::middleware(['auth','participant'])->group( function() {
	Route::get('/home/members', 'UserController@memberIndex')->name('participants.users.index');
	Route::delete('/home/users/{id}', 'UserController@memberDelete')->name('participants.users.delete');
	Route::post('/home/users', 'UserController@memberStore')->name('participants.users.store');
	Route::put('/home/users/{id}/', 'UserController@memberUpdate')->name('participants.users.update');
	Route::get('/home/password/change', 'UserController@changePasswordForm')->name('change.passowrd');
	Route::put('/home/password/', 'UserController@updatePassword')->name('update.password');
	Route::get('/home/settings', 'UserController@changeParticipantProfile')->name('participants.change.profile');
	Route::put('/home/settings', 'UserController@updateParticipantProfile')->name('participants.update.profile');
});


Route::auth();
