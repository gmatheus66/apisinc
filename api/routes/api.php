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

Route::post('/doctor/register', 'DoctorController@register')->name('register_doctor');
Route::post('/doctor/login', 'DoctorController@login')->name('login_doctor');
Route::post('/doctor/logout', 'DoctorController@logout')->name('logout_doctor');

Route::post('/patient/register', 'PatientController@register')->name('register_patient');
Route::post('/patient/login', 'PatientController@login')->name('login_patient');
Route::post('/patient/logout', 'PatientController@logout')->name('logout_patient');

Route::post('/relative/register', 'RelativeController@register')->name('register_relative');
Route::post('/relative/login', 'RelativeController@login')->name('login_relative');
Route::post('/relative/logout', 'RelativeController@logout')->name('login_logout');



Route::group(['prefix' => 'doctor','middleware' => ['assign.guard:doctors','jwt.auth']],function ()
{
	Route::post('/handbook/register','HandbookController@register')->name('register_handbook');	
});
