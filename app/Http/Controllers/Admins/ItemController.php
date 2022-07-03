<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Sell;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function searchItemSku(Request $request){

        $item_skus =  Item::where('sold_out', '1')
                    ->where('purchase_return', '0')
                    ->when(request()->get('params')['term'], function ($query, $term) {
                        $query->where('item_sku', 'like', "%$term%");
                    })->limit(10)->get();

        return response()->json(['data' => $item_skus]);
    }

    public function searchByItemSku($item_sku){
        $item =  Item::where('item_sku', $item_sku)->first();
        $item->gold_plus_gem_weight = json_decode($item->gold_plus_gem_weight);
        $item->gem_weight = json_decode($item->gem_weight);
        $item->fee = json_decode($item->fee);

        $sell = $item->sell;

        $customer = $sell->contact;
        $customer->search_name = $customer->name.'( email -'.$customer->email.') (ph-'.$customer->mobile1.','.$customer->mobile2.') (address- '.$customer->address.' )';
        $data = [
            'item' => $item,
            'sell' => $sell,
            'transaction' => $item->sell->transaction,
            'product' => $item->product,
            'created_by' => $sell->user,
            'customer' => $customer,
            'daily_setup' => $sell->dailysetup,
        ];
        return response()->json(['data' => $data]);
    }
}
