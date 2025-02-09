<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'quotations';

    public static function getPaymentMethodName($id)
    {
        return DB::table('payment_methods')->where('id', $id)->first();
    }
}
