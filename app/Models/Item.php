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
        'gold_plus_gem_weight',
        'gem_weight',
        'fee',
        'fee_for_making',
        'is_active',
        'image',
        'draft',
        'sold_out',
        'purchase_return',
        'sell_return',
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
    public function sell()
    {
        return $this->hasOne(Sell::class, 'item_id');
    }
    public function purchase()
    {
        return $this->hasOne(Purchase::class, 'item_id');
    }

    /**
     * Accessor for gold_plus_gem_weight
     *
     * @param  string  $value
     * @return string
     */
    public function getGoldPlusGemWeightAttribute($value)
    {
        return json_decode($value);
    }

     /**
     * Accessor for gem weight
     *
     * @param  string  $value
     * @return string
     */
    public function getGemWeightAttribute($value)
    {
        return json_decode($value);
    }

     /**
     * Accessor for fee
     *
     * @param  string  $value
     * @return string
     */
    public function getFeeAttribute($value)
    {
        return json_decode($value);
    }
}
