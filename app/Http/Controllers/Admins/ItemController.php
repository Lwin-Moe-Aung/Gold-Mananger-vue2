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
        $sell = $item->sell;
        $data = [
            'item' => $item,
            'sell' => $sell,
            'transaction' => $item->sell->transaction,
            'product' => $item->product,
            'created_by' => $sell->user,
            'customer' => $sell->contact,
            'daily_setup' => $sell->dailysetup,
        ];
        return response()->json(['data' => $data]);
    }
}
