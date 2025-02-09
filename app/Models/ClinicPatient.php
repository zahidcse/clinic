<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicPatient extends Model
{
    protected $table = 'clinic_patient';
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
