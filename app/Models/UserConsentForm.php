<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class UserConsentForm extends Model
{
    protected $table = 'user_consent_form';

    public function consent_from()
    {
        return $this->belongsTo(ConsentForm::class,'form_id','id');
    }
}
