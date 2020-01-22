<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class institution extends Model
{
   protected $fillable [
   	'name',
   	'eni',
   	'address',
   	'city',	
   	'contry',
   	'state_province'
   ]
   protected $guarded [
  
   ]
}
