<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

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
            $query->where('debt_paid_money', 'like', $term)
                ->orWhere('remaining_credit_money', 'like', $term)
                ->orWhereHas('contact', function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('mobile1', 'like', $term)
                        ->orWhere('mobile2', 'like', $term);
                });
        });
    }

    public function scopeTransactionsQuery($query)
    {
        $type = request('type');
        $search_term = request('q', '');
        $selectedContact = request('selectedContact');
        $sort_direction = request('sort_direction', 'desc');

        $startDate = request('startDate');
        $endDate = request('endDate');

        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'created_at');
        if (!in_array($sort_field, ['debt_paid_money', 'remaining_credit_money', 'created_at'])) {
            $sort_field = 'created_at';
        }
        $query->where('type', $type)
            ->with('contact')
            ->when($selectedContact, function ($query) use ($selectedContact) {
                $query->where('contact_id', $selectedContact);
            })
            ->when($startDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term));
    }
}
