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
        'contact_id',
        'type',
        'status',
        'payment_status',
        'invoice_no',
        'ref_no',
        'transaction_date',
        'shipping_details',
        'shipping_charges',
        'additional_notes',
        'before_total',
        'discount_amount',
        'final_total',
        'paid_money',
        'credit_money',
        'debt_paid_money',
        'remaining_credit_money',
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
        return $this->hasOne(Purchase::class, 'transaction_id');
    }
    public function expense()
    {
        return $this->hasOne(Expense::class, 'transaction_id');
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

    public function debtPaymentFromCustomer()
    {
        return $this->hasMany(DebtPaymentFromCustomer::class, 'transaction_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('paid_money', 'like', $term)
                ->orWhere('credit_money', 'like', $term)
                ->orWhereHas('contact', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                    $query->where('mobile1', 'like', $term);
                    $query->where('mobile2', 'like', $term);
                });
        });
    }

    public function scopeTransactionsQuery($query)
    {
        $search_term = request('q', '');
        $selectedCustomer = request('selectedCustomer');
        $sort_direction = request('sort_direction', 'desc');

        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'created_at');
        if (!in_array($sort_field, ['name', 'total_debt_payment', 'remaining_credit', 'invoice_no', 'created_at'])) {
            $sort_field = 'created_at';
        }
        $query->where('type','debt_payment_from_customer')
            ->with(['contact'])
            ->when($selectedCustomer, function ($query) use ($selectedCustomer) {
                $query->where('contact_id', $selectedCustomer);
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term));
    }
}
