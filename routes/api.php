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

Route::post('/doctor/login', 'DoctorController@login')->name('login_doctor');
Route::post('/doctor/logout', 'DoctorController@logout')->name('logout_doctor');

Route::post('/patient/register', 'PatientController@register')->name('register_patient');
Route::post('/patient/login', 'PatientController@login')->name('login_patient');
Route::post('/patient/logout', 'PatientController@logout')->name('logout_patient');

Route::post('/relative/register', 'RelativeController@register')->name('register_relative');
Route::post('/relative/login', 'RelativeController@login')->name('login_relative');
Route::post('/relative/logout', 'RelativeController@logout')->name('logout_relative');

Route::post('/admin/login', 'AdminController@login')->name('login_admin');
Route::post('/admin/logout', 'AdminController@logout')->name('logout_admin');


Route::group(['prefix' => 'doctor','middleware' => ['assign.guard:doctors','jwt.auth']],function ()
{
	Route::post('/handbook/register','HandbookController@register')->name('register_handbook');
	Route::get('/patient', 'PatientController@get_all_patient_doctor')->name('patient_relative');
	Route::get('/check', 'DoctorController@check_user')->name('check_doctor');
    Route::get('/detail','DoctorController@detail_auth_user')->name('detail_doctor');
    Route::get('/gethandbook', 'HandbookController@get_handbook_doctor')->name('get_handbook_doctor');
});
Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admins','jwt.auth']],function ()
{
	Route::post('/doctor/register', 'DoctorController@register')->name('register_doctor');
	Route::post('/institution/register', 'InstitutionController@register')->name('register_institution');

});

Route::group(['prefix' => 'relative','middleware' => ['assign.guard:relatives','jwt.auth']],function ()
{
	Route::get('/detail','RelativeController@detail_auth_user')->name('detail_relative');
	Route::get('/patients', 'PatientController@get_all_patient_relatives')->name('patient_relative');
	Route::get('/patient', 'RelativePatientController@get_my_patient_relatives')->name('patient_relative');
	Route::post('/register/patient', 'RelativePatientController@register')->name('register_patient_relative');
	Route::get('/check', 'RelativeController@check_user')->name('check_relative');
});
Route::group(['prefix' => 'patient','middleware' => ['assign.guard:patient','jwt.auth']],function ()
{
	Route::get('/detail','PatientController@detail_auth_user')->name('detail_patient');
	Route::get('/check', 'PatientController@check_user')->name('check_patient');
	Route::post('/register/heart', 'HeartRateController@register')->name('register_heart_rate_patient');
	Route::get('/register/getheart', 'HeartRateController@get_heart_rates')->name('get_heart_rate_patient');
	Route::get('/gethandbook/{id}', 'HandbookController@get_detail_handbook_patient')->name('get_detail_handbook_patient');
	Route::get('/gethandbook', 'HandbookController@get_handbook_patient')->name('get_handbook_patient');
});
