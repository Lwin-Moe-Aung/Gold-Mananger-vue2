<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtPaymentFromCustomer extends Model
{
    use HasFactory;

    protected $table = 'debt_payment_from_customers';

    protected $fillable = [
        'transaction_id',
        'parent_id',
        'customer_id',
        // 'before_total',
        // 'discount_amount',
        // 'final_total',
        'old_paid_money',
        'old_credit_money',
        'debt_payment'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'parent_id');
    }

}
