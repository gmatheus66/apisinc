<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Relative extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'name',
        'age',
        'birthday',
        'sex',
        'email',
        'password',
        'ocupation',
        'address',
        'telephone',
        'city',
        'country',
        'state_province',
        'occupation',
        'zip'
 
    ];
 
    protected $guarded = [
         'id',
         'password',
        
    ];
 
    protected $hidden = [
         'password', 'remember_token'
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
