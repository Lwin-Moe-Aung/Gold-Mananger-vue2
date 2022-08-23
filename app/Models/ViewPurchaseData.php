<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewPurchaseData extends Model
{
    use HasFactory;
    public $table = "view_purchase_data";
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('contact_name', 'like', $term)
                ->orWhere('mobile1', 'like', $term)
                ->orWhere('mobile2', 'like', $term)
                ->orWhere('address', 'like', $term)
                ->orWhere('invoice_no', 'like', $term)
                ->orWhere('final_total', 'like', $term)
                ->orWhere('item_sku', 'like', $term)
                ->orWhere('item_name', 'like', $term)
                ->orWhere('product_sku', 'like', $term)
                ->orWhere('created_at', 'like', $term);
        });
    }

    public function scopeViewPurchaseDataQuery($query)
    {
        $search_term = request('q', '');
        $contact_id = request('selectedContact');

        $sort_direction = request('sort_direction', 'desc');
        $startDate = request('startDate');
        $endDate = request('endDate');

        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'desc';
        }
        $sort_field = request('sort_field', 'created_at');
        if (!in_array($sort_field, ['item_name', 'contact_name', 'item_sku', 'product_sku', 'invoice_no', 'final_total'])) {
            $sort_field = 'created_at';
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
