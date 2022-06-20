<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Product extends Model
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
        'product_sku',
        'quality',
        'type_id',
        'item_names_id',
        'description',
        'tax',
        'item_count',
        'alert_quantity',
        'is_active',
        'business_id',
        'created_by',
        'draft',
        'gold_weight',
        'gem_weight',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function item()
    {
        return $this->hasMany(Item::class, 'product_id');
    }
}
