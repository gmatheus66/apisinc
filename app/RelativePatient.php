<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelativePatient extends Model
{
    protected $fillable = [
        'relative_id',
        'patient_id',
        'relative_patient'
    ];
    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];
}
