<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctors extends Model
{
 		protected $fillable = [
		'name',
		'crm',
		'specialization',

];
	protected $guarded = [
		'id';
		'created_at',
		'update_at';
		'token_band';
		'token_login';
	]
}
