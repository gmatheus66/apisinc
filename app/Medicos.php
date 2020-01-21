<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicos extends Model
{
 		protected $fillable = [
		'name',
		'crm',
		'specialty',

];
	protected $guarded = [
		'id';
		'created_at',
		'update_at';
		'token_band';
		'token_login';
	]
}
