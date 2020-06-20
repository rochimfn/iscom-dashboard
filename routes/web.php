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
Route::auth();
