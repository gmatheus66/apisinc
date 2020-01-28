<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Handbook extends Model
{
	protected $fillable = [
		'name_handbook',
		'limitation',
		'body_mass',
		'weight',
		'service_date',
		'complaints',
		'symptoms',
		'vital_signs',
		'blood_type',
		'blood_pressure',
		'hgt',
		'temperature',
		'relative_id',
		'patient_id',
		'doctor_id'
	];
	protected $guarded = [
		'id',
		'created_at',
		'update_at',
		'token_band',
		'token_login',
	];

}
