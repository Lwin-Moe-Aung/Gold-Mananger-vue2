<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySetupForPurchaseReturn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'daily_setup_for_purchase_returns';

    protected $fillable = [
        'type',
        'key',
        'open_close_day_id',
        'kyat',
        'pal',
        'yway',
        'customize',
        'business_id',
    ];

    public const VALIDATION_RULES = [
        'open_close_day_id' => ['required'],
        'kyat' => ['required'],
        'pal' => ['required'],
        'yway' => ['required'],
    ];
}
