<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
// use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
// use Laravel\Fortify\TwoFactorAuthenticatable;
class Variation extends Model
{
    use HasApiTokens;
    use HasFactory;
    // use HasProfilePhoto;
    use Notifiable;
    use HasRoles;
    // use TwoFactorAuthenticatable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'item_sku',
        'default_purchase_price',
        'dpp_inc_tax',
        'profit_percent',
        'default_sell_price',
        'sell_price_inc_tax'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
