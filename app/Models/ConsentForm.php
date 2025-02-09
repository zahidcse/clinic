<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsentForm extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'consent_form';

    public function user_consent_form()
    {
        return $this->hasOne(UserConsentForm::class,'form_id','id');
    }

}
