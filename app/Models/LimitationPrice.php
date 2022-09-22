<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitationPrice extends Model
{
    use HasFactory;
    protected $table = 'limitation_prices';

    protected $fillable = [
        'price',
        'open_close_day_id',
        'business_id',
        'customize',
    ];

    public const VALIDATION_RULES = [
        'price' => ['required'],
    ];
}
