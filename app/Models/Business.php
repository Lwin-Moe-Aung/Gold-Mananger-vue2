<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Business extends Model
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use HasRoles;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
    protected $table = 'business';
    protected $fillable = [
        'name',
        'start_date',
        'tax',
        'default_tax',
        'default_profit_percent',
        'owner_id',
        'accounting_method',
        'default_sales_discount',
        'sell_price_tax',
        'logo',
        'keyboard_shortcuts',
        'pos_setting',
        'date_format',
        'time_format',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function Contact(){
        return $this->hasMany(Contact::class, 'business_id');
    }
}
