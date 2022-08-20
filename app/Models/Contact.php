<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
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
        'supplier_business_name',
        'name',
        'email',
        'mobile1',
        'mobile2',
        'address',
        'total_amount',
        'created_by',
        'total_amount',
        'customer_group_id'
    ];

    public const VALIDATION_RULES = [
        'name' => ['required', 'max:50'],
        'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
        'mobile1' => ['required'],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function Business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'contact_id');
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class, 'supplier_id');
    }
    public function sell()
    {
        return $this->hasMany(Sell::class, 'customer_id');
    }

    public function scopeLike($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name','like',$term)
                ->orWhere('email','like',$term)
                ->orWhere('mobile1','like',$term)
                ->orWhere('mobile2','like',$term)
                ->orWhere('address','like',$term);
        });
    }
    public function scopeSearchQuery($query)
    {
        $search_value = request('term', '');
        $query->where('business_id', Auth::user()->business_id)
            ->where('type', request('type'))
            ->like(trim($search_value));
    }
}
