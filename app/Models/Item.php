<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;


class Item extends Model
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
        'name',
        'product_id',
        'business_id',
        'business_location_id',
        'created_by',
        'item_sku',
        'gold_weight',
        'gold_price',
        'gem_weight',
        'gem_price',
        'fee',
        'fee_price',
        'fee_for_making',
        'item_discount',
        'tax',
        'is_active',
        'image1',
        'image2',
        'draft',
        'item_description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

     /**
     * @return HasOne
     * @description get the order associated with the transaction
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
