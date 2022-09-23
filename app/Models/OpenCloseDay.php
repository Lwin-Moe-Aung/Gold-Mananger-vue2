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

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('opening_balance', 'like', $term)
                ->orWhere('closing_balance', 'like', $term)
                ->orWhereDate('opening_date_time', '=', $term)
                ->orWhereDate('closing_date_time', '=', $term);
        });
    }

    public function scopeOpenCloseDaysQuery($query)
    {
        $search_term = request('q', '');
        $sort_direction = request('sort_direction', 'desc');

        $startDate = request('startDate');
        $endDate = request('endDate');

        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }

        $sort_field = request('sort_field', 'created_at');
        if (!in_array($sort_field, ['opened', 'opening_balance', 'opening_date_time', 'closed', 'closing_balance', 'closing_date_time'])) {
            $sort_field = 'created_at';
        }
        $query->when($startDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term));
    }

}
