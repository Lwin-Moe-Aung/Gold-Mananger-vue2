<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;


class Order extends Model
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
        'transaction_id',
        'created_by',
        'business_id',
        'business_location_id',
        'total_weight',
        'total_before',
        'final_total',
        'paid_money',
        'credit_money',
        'discount_amount',
        'note',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
    /**
     * @return BelongsTo
     * @description Get the transaction that owns the order
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * @return BelongsTo
     * @description Get the item that owns the order
    */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
