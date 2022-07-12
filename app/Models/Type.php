<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Type extends Model
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
        'image',
        'business_id',
        'is_active',
        'key',
        'draft'
    ];

    public const VALIDATION_RULES = [
        'name' => ['required', 'max:50'],
        'key' => ['required', 'max:1'],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function dailySetup()
    {
        return $this->hasMany(DailySetup::class, 'type_of_daily_setup');
    }
}
