<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
	protected $fillable = [
		'name',
		'age',
		'sex',
		'phone',
		'Email',
		'occupation',
		'address',
		'city',
		'country',
		'state_province',

];
	protected $guarded = [
		'id';
		'created_at',
		'update_at';
		'token_band';
		'token_login';
	]
}
