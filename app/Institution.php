<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = [
        'name',
        'telephone',
        'CNPJ',
        'address',
        'city',
        'country',
        'state_province',
        'zip'
    ];

    protected $guarded = [
		'id',
		'created_at',
		'update_at',
		'token_band',
		'token_login',
	];
}
