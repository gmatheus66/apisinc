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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('Api')->name('api.')->group(function(){
    
    //Route::post('/register', 'AuthController@register');
    //Route::post('/login', 'AuthController@login');
    //Route::get('/logout', 'AuthController@logout')->middleware('auth:api');

    Route::prefix('patient')->group(function(){
        Route::get('/', 'PatientsController@index')->name('index')->middleware('auth:api');
        Route::get('/{id}', 'PatientsController@show')->name('show_patient')->middleware('auth:api');
        Route::post('/register', 'PatientsController@register')->name('register_patient');
        Route::post('/login', 'PatientsController@login')->name('login_patient');
    });
    Route::prefix('doctor')->group(function(){
    	Route::get('/','DoctorController@index')->name('index');
    	Route::post('/register','DoctorController@register')->name('register_doctor');
        Route::post('/login', 'DoctorController@login')->name('login_doctor');
    });
    Route::prefix('institutions')->group(function(){
        Route::post('/register', 'InstitutionsController@register')->name('register_institution');
    });
    Route::prefix('relatives')->group(function(){
        Route::post('/register', 'RelativesController@register')->name('register_relatives');
        Route::post('/login', 'RelativesController@login')->name('login_register');
    });
});