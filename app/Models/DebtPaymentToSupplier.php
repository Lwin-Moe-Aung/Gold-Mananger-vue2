<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtPaymentToSupplier extends Model
{
    use HasFactory;
    protected $table = 'debt_payment_to_suppliers';

    protected $fillable = [
        'transaction_id',
        'parent_id',
        'supplier_id',
        'before_total',
        'discount_amount',
        'final_total',
        'paid_money',
        'credit_money',
        'debt_payment'
    ];
}
