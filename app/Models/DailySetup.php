<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class DailySetup extends Model
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
    protected $table = 'daily_setups';

    protected $fillable = [
        'type',
        'key',
        'open_close_day_id',
        'kyat',
        'pal',
        'yway',
        'customize',
        'business_id',
    ];

    public const VALIDATION_RULES = [
        'open_close_day_id' => ['required'],
        'kyat' => ['required'],
        'pal' => ['required'],
        'yway' => ['required']
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function purchase()
    {
        return $this->hasMany(Purchase::class, 'daily_setup_id');
    }

    public function sell()
    {
        return $this->hasMany(Sell::class, 'daily_setup_id');
    }
}
