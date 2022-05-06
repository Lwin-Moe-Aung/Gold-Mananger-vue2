<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;


class Orders extends Model
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'item_id',
        'created_by',
        'gold_weight',
        'gold_price',
        'gem_weight',
        'gem_price',
        'fee',
        'fee_price',
        'fee_for_making',
        'item_discount',
        'tax',
        'total_weight',
        'total_before',
        'total_after',
        'paid_money',
        'credit_money',
        'note',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


}
