<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'medical_reports';

    public function medicalReportFiles()
    {
        return $this->hasMany(MedicalReportFile::class);
    }
}
