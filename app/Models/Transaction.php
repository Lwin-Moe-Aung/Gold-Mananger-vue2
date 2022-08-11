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

    //  //has one through
    //  public function item()
    //  {
    //      //(to_connect_model_name, through_model)
    //      return $this->hasOneThrough(
    //          Item::class,
    //          Purchase::class,
    //          'transaction_id', //foregin key on purchase table...
    //          'id', //foregin key on item table ....
    //          'id', // local key in Transaction table.....
    //          'id', // local key in Purchase table.....
    //      );
    //  }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('email', 'like', $term)
                ->orWhere('address', 'like', $term)
                ->orWhere('phone_number', 'like', $term)
                ->orWhereHas('class', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                })
                ->orWhereHas('section', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                });
        });
    }

    public function scopeTransactionsQuery($query)
    {
        $search_term = request('q', '');

        $selectedClass = request('selectedClass');

        $sort_direction = request('sort_direction', 'desc');

        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'created_at');
        if (!in_array($sort_field, ['name', 'total_debt_payment', 'remaining_credit', 'invoice_no', 'created_at'])) {
            $sort_field = 'created_at';
        }

        $query->with(['contact'])
            ->when($selectedClass, function ($query) use ($selectedClass) {
                $query->where('class_id', $selectedClass);
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term));
    }
}
