<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
	use HasApiTokens,Notifiable;

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
		'password',
		'remember_token',
	];

	protected $hidden = [
		'password', 'remember_token',
	];
}
