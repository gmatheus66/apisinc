<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class relative extends Model
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
   	'city',
   	'coutry',
   	'state_province',

   ];

   protected $guarded = [
		'id',
		'password',
		
	   
   ];

   protected $hidden = [
		'password', 'remember_token'
   ];
}
