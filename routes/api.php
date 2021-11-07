<?php

// namespace App\Http\Controllers;

use App\Http\Middleware\CheckLogin;
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


// AUTHENTICATION ROUTES
Route::group(['middleware' => 'api'], function ($router) {
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('login', 'App\Http\Controllers\AuthController@login')->name('loging');
    Route::post('register', 'App\Http\Controllers\AuthController@register')->name('register');
});

//GUEST ROUTES
Route::prefix('jobs')->group(function () {
    Route::get('/', 'App\Http\Controllers\JobController@index');
    Route::get('/{job_id}', 'App\Http\Controllers\JobController@show');
    Route::post('/{job_id}/apply', 'App\Http\Controllers\ApplicantController@store');
    // SEARCH ROUTE
    Route::get('/search', 'App\Http\Controllers\JobController@search')->name('search');
});

// BUSINESS ROUTES
Route::middleware([CheckLogin::class])->group(function(){
    Route::post('my/jobs', 'App\Http\Controllers\JobController@store');
    Route::get('my/jobs', 'App\Http\Controllers\JobController@index');
    Route::get('my/jobs/{job_id}', 'App\Http\Controllers\JobController@show');
    Route::put('my/jobs/{job_id}', 'App\Http\Controllers\JobController@update');
    Route::delete('my/jobs/{job_id}', 'App\Http\Controllers\JobController@destroy');
    Route::get('my/jobs/{job_id}/applications', 'App\Http\Controllers\JobController@applications');
});



//SELECT OPTIONS ROUTES
Route::apiResource('category', 'App\Http\Controllers\CategoryController');
Route::apiResource('job/type', 'App\Http\Controllers\JobtypeController');
Route::apiResource('work/condition', 'App\Http\Controllers\WorkconditionController');

