<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class DailySetupDetail extends Model
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
    protected $table = 'daily_setup_details';

    protected $fillable = [
        'daily_setup_id',
        'quality',
        'daily_price_kyat',
        'daily_price_pal',
        'daily_price_yway',
        'business_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function dailySetup()
    {
        return $this->belongsTo(DailySetup::class, 'daily_setup_id');
    }
}
