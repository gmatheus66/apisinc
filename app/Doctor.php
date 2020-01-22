<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
 		protected $fillable = [
		'name',
		'crm',
		'specialization',
		'institution_id'

];
	protected $guarded = [
		'id',
		'created_at',
		'update_at',
		'token_band',
		'token_login',
	];
}
