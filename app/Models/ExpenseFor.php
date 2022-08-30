<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseFor extends Model
{
    use HasFactory;

    protected $table = 'expense_fors';

    protected $fillable = [
        'name',
        'business_id',
    ];

    public const VALIDATION_RULES = [
        'name' => ['required'],
    ];

    public function expense()
    {
        return $this->hasMany(Expense::class, 'expense_for');
    }
}
