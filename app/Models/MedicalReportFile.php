<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReportFile extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'medical_report_files';
}
