<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $guarded = [];
    protected $table = 'quotation_payment_history';

    public static function getTotalPaid($id)
    {
        $total_paid = PaymentHistory::where('quotation_id', $id)
            ->sum('amount');
        return $total_paid;
    }
}
