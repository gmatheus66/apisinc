<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Handbooks extends Model
{
	protected $fillable = [
		'handbooks',
		'open_date',
		'limitation',
		'body_mass',
		'Weight','
		report'
	];
	protected $guarded = [
		'id',
		'created_at',
		'update_at',
		'token_band',
		'token_login',
	]
    }
