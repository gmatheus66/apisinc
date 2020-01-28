<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relatives_patient extends Model
{
    
    protected $fillable = [
        'kinship_degree',
        'relative_id',
        'patient_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at',
    ];
}
