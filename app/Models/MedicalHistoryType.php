<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalHistoryType extends Model
{
    use HasFactory;

    protected $table = 'medical_history_type';
    protected $guarded = [];

    public static function getType($id)
    {
        return MedicalHistoryType::findOrFail($id);
    }
}
