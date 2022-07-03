<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Sell extends Model
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
        'daily_setup_id',
        'customer_id',
        'gold_price',
        'gem_price',
        'fee',
        'fee_price',
        'fee_for_making',
        'before_total',
        'total_before',
        'final_total',
        'paid_money',
        'credit_money',
        'discount_amount',
        'sell_return',
        'additional_notes',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }
    public function dailysetup()
    {
        return $this->belongsTo(DailySetup::class, 'daily_setup_id');
    }
}
