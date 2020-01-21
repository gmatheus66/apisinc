<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prontuarios extends Model
{
	protected $fillable = [
		'medical_record',
		'open_date',
		'deficiency',
		'body_mass',
		'Weight','
		report'
	];
	protected $guarded = [
		'id';
		'created_at',
		'update_at';
		'token_band';
		'token_login';
	]
    }
