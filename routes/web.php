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

Route::get('/', 'PageController@index');
Route::get('/pages/create', 'PageController@create');
Route::get('/pages/{id}/edit', 'PageController@edit');
Route::post('/pages', 'PageController@store')->name('pages.store');
Route::post('/images', 'PageController@uploadImage')->name('pages.image');

