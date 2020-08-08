<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Doctor extends Authenticatable implements JWTSubject
{
    protected $fillable = [
		'name',
		'crm',
		'specialization',
		'institution_id',
		'email', 'password',

	];

	protected $guarded = [
		'id',
		'created_at',
		'update_at',
		'token_band',
		'token_login',
	];


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function relationship_patient(){
        return $this->belongsTo('App\Institution');
    }
}
