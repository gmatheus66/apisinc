<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeartRate extends Model
{
    protected $fillable =[
        'patient_id',
        'date_measurement',
        'heart_rate'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'update_at'
    ];

    public function relationship_patient(){
        return $this->belongsTo('App\Patient');
    }
}
