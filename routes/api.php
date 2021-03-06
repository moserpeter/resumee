<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function () {
    Route::post('/applications/{application}/send', 'ApplicationController@send')->name('applications.send');
    Route::apiResource('applications', 'ApplicationController');

    Route::apiResource('companies', 'CompanyController');

    Route::apiResource('jobs', 'JobController');
});
