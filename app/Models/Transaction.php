<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;


class Transaction extends Model
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
        'business_id',
        'business_location_id',
        'type',
        'status',
        'payment_status',
        'invoice_no',
        'ref_no',
        'transaction_date',
        'shipping_details',
        'shipping_charges',
        'additional_notes',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return HasOne
     * @description get the order associated with the transaction
     */
    public function sell()
    {
        return $this->hasOne(Sell::class);
    }
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
    public function businessLocation()
    {
        return $this->belongsTo(BusinessLocation::class, 'business_location_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
