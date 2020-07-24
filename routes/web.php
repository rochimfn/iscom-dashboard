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

//Development Route
// Route::get('/uhuy/{filename}/{folder}', 'ZipController@downloadZip');
// Routes for Landing
Route::get('/', 'PageController@home')->name('home.page');
Route::get('/pages/{slug}', 'PageController@show')->name('single.page');
Route::redirect('/dashboard', '/dashboard/users');
Route::redirect('/home', '/login');

// Routes for all
Route::middleware('auth')->group( function() {
	Route::put('/password/', 'UserController@updatePassword')->name('update.password');
});

// Routes for Administrator
Route::prefix('/dashboard')->middleware(['auth','admin'])->name('admin')->group( function() {

	Route::get('/pages', 'PageController@index')->name('pages.index');
	Route::get('/pages/create', 'PageController@create')->name('pages.create');
	Route::get('/pages/{slug}/edit', 'PageController@edit')->name('pages.edit');
	Route::delete('/pages/{id}', 'PageController@destroy')->name('pages.destroy');
	Route::post('/pages', 'PageController@store')->name('pages.store');
	Route::put('/pages/{slug}/', 'PageController@update')->name('pages.update');
	Route::post('/upload/images', 'PageController@uploadImage')->name('pages.image');

	Route::get('/users/dosen', 'UserController@indexDosen')->name('users.dosen.index');
	Route::delete('/users/dosen/{id}', 'UserController@deleteDosen')->name('users.dosen.delete');
	Route::post('/users/dosen', 'UserController@storeDosen')->name('users.dosen.store');
	Route::put('/users/dosen/{id}/', 'UserController@updateDosen')->name('users.dosen.update');
	Route::get('/users', 'UserController@indexParticipants')->name('users.participants.index');
	Route::get ('/users/download', 'UserController@exportParticipants')->name('users.participants.download');

	Route::get('/competition/session', 'CompetitionController@sessionIndex')->name('competition.index.session');
	Route::put('/competition/session', 'CompetitionController@updateSession')->name('competition.update.session');
	Route::get('/competition/branch', 'CompetitionController@branchIndex')->name('competition.index.branch');
	Route::post('/competition/branch/', 'CompetitionController@branchStore')->name('competition.store.branch');
	Route::put('/competition/branch/{id}', 'CompetitionController@branchUpdate')->name('competition.update.branch');
	Route::delete('/competition/branch/{id}', 'CompetitionController@branchDestroy')->name('competition.destroy.branch');

	Route::get('/competition/kti', 'CompetitionController@ktiIndexQuestion')->name('competition.index.question.kti');
	Route::get('/competition/kti/submission', 'CompetitionController@ktiIndexSubmission')->name('competition.index.submission.kti');
	Route::get('/competition/kti/submission/download/{directory?}', 'CompetitionController@ktiDownloadSubmission')->name('competition.submission.download.kti');
	Route::post('/competition/kti', 'CompetitionController@ktiStoreQuestion')->name('competition.store.question.kti');
	Route::get('/competition/kti/{id}', 'CompetitionController@ktiEditQuestion')->name('competition.edit.question.kti');
	Route::put('/competition/kti/{id}', 'CompetitionController@ktiUpdateQuestion')->name('competition.update.question.kti');
	Route::delete('/competition/kti/{id}', 'CompetitionController@ktiDestroyQuestion')->name('competition.destroy.question.kti');

	Route::get('/competition/non-kti', 'CompetitionController@nonKtiIndexQuestion')->name('competition.index.question.non-kti');
	Route::get('/competition/non-kti/submission', 'CompetitionController@nonKtiIndexSubmission')->name('competition.index.submission.non-kti');
	Route::get('/competition/non-kti/submission/download/{directory?}', 'CompetitionController@nonKtiDownloadSubmission')->name('competition.submission.download.non-kti');
	Route::post('/competition/non-kti', 'CompetitionController@nonKtiStoreQuestion')->name('competition.store.question.non-kti');
	Route::get('/competition/non-kti/{id}', 'CompetitionController@nonKtiEditQuestion')->name('competition.edit.question.non-kti');
	Route::put('/competition/non-kti/{id}', 'CompetitionController@nonKtiUpdateQuestion')->name('competition.update.question.non-kti');
	Route::delete('/competition/non-kti/{id}', 'CompetitionController@nonKtiDestroyQuestion')->name('competition.destroy.question.non-kti');

	Route::get('/password/change', 'UserController@changePasswordForm')->name('change.password');
	Route::get('/settings', 'UserController@changeAdminProfile')->name('change.profile');
	Route::put('/settings', 'UserController@updateAdminProfile')->name('update.profile');
});


//Route for Dosen
Route::prefix('/home/dosen')->middleware(['auth','dosen'])->name('dosen')->group( function() {
	Route::get('/submission', 'CompetitionController@indexSubmission')->name('index.submission');
	Route::get('/submission/download/{directory?}', 'CompetitionController@downloadSubmission')->name('download.submission');

	Route::get('/password/change', 'UserController@changePasswordForm')->name('change.password');
	Route::get('/settings', 'UserController@changeDosenProfile')->name('change.profile');
	Route::put('/settings', 'UserController@updateDosenProfile')->name('update.profile');
});


//Routes for participants
Route::prefix('/home')->middleware(['auth','participant'])->name('participants')->group( function() {
	Route::get('/members', 'UserController@memberIndex')->name('users.index');
	Route::delete('/users/{id}', 'UserController@memberDelete')->name('users.delete');
	Route::post('/users', 'UserController@memberStore')->name('users.store');
	Route::put('/users/{id}/', 'UserController@memberUpdate')->name('users.update');

	Route::get('/submission', 'CompetitionController@indexQuestion')->name('question.index');
	Route::post('/submission', 'CompetitionController@storeSubmission')->name('submission.store');
	Route::delete('/submission/{id}', 'CompetitionController@deleteSubmission')->name('submission.delete');

	Route::get('/password/change', 'UserController@changePasswordForm')->name('change.password');
	Route::get('/settings', 'UserController@changeParticipantProfile')->name('change.profile');
	Route::put('/settings', 'UserController@updateParticipantProfile')->name('update.profile');
});


Route::auth();
