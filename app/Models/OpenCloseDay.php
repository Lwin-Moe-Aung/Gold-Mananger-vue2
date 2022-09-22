<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenCloseDay extends Model
{
    use HasFactory;
    protected $table = 'open_close_days';

    protected $fillable = [
        'open',
        'close',
        'opening_balance',
        'closing_balance',
        'opening_date_time',
        'closing_date_time',
    ];


}
