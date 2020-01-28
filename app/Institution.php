<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
   protected $fillable = [
   	'name',
   	'ENI',
   	'address',
   	'city',	
   	'country',
	'state_province',
	'zip',
   ];

   protected $guarded = [
	   'name',
	   'ENI',
	   'address',
	   'city',
	   'country',
	   'state_province',
	   'zip',
   ];
}
