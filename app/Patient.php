<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Patient extends Authenticatable implements JWTSubject
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
		'password',
		'remember_token',
	];

	protected $hidden = [
		'password', 'remember_token',
    ];
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

   
    public function getJWTCustomClaims()
    {
        return [];
    }
}
