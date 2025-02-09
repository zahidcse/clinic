<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'procedure_invoice';
    protected $guarded = [];

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetails::class, 'procedure_invoice_id', 'id');
    }

    public function invoicePayments()
    {
        return $this->hasMany(InvoicePayments::class, 'invoice_id', 'id');
    }

    public function paidAmount()
    {
        return $this->hasMany(InvoicePayments::class, 'invoice_id', 'id')->sum('amount') ?? 0;
    }

    public function dueAmount($data)
    {
        return $data->payment_status;
    }
}
