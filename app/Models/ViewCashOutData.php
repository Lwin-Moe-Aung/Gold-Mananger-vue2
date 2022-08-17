<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewCashOutData extends Model
{
    use HasFactory;
    public $table = "view_cashout_data";
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('mobile1', 'like', $term)
                ->orWhere('mobile2', 'like', $term)
                ->orWhere('address', 'like', $term)
                ->orWhere('invoice_no', 'like', $term)
                ->orWhere('type', 'like', $term)
                ->orWhere('amount', 'like', $term)
                ->orWhere('expense_category_name', 'like', $term)
                ->orWhere('created_at', 'like', $term);
        });
    }

    public function scopeViewCashOutDataQuery($query)
    {
        $search_term = request('q', '');
        $selectedType = request('selectedType');
        $contact_id = request('contact_id');

        $sort_direction = request('sort_direction', 'desc');
        $startDate = request('startDate');
        $endDate = request('endDate');

        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }
        $sort_field = request('sort_field', 'created_at');
        if (!in_array($sort_field, ['name', 'mobile1','address','invoice_no','type','expense_category_name', 'amount', 'created_at'])) {
            $sort_field = 'created_at';
        }
        if ( $selectedType != 'all') {
            $query->where('type','=', $selectedType);
        }
        $query->when($contact_id, function ($query) use ($contact_id) {
                $query->where('contact_id', $contact_id);
            })
            ->when($startDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term));
    }
}
