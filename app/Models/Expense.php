<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses';

    protected $fillable = [
        'transaction_id',
        'expense_category_id',
        'expense_for',
        'amount',
        'additional_notes',
        'image',
    ];

    public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function expense_for()
    {
        return $this->belongsTo(ExpenseFor::class, 'expense_for');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'expense_for');
    }
}
