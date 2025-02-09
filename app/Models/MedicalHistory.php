<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $table = 'medical_history';
    protected $guarded = [];
}
