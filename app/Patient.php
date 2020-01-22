<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
	protected $fillable = [
		'name',
		'birthday',
		'sex',
		'phone',
		'email',
		'occupation',
		'address',
		'city',
		'country',
		'state_province',
		'password',
		'telephone',
		'zip'

	];
	protected $guarded = [
		'id',
		'created_at',
		'update_at',
		'token_band',
		'token_login',
	];
}
