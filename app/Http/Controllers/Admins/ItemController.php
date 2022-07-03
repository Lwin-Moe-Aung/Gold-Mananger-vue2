<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Sell;
use App\Models\LimitationPrice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $product = $item->product;
        $sell = $item->sell;

        $customer = $sell->contact;
        $customer->search_name = $customer->name.'( email -'.$customer->email.') (ph-'.$customer->mobile1.','.$customer->mobile2.') (address- '.$customer->address.' )';

        //setting daily setup
        $limitation_price = LimitationPrice::where('customize','0')
                        ->where('business_id', Auth::user()->business_id)
                        ->orderBy('created_at', 'DESC')
                        ->first();
        $daily_setup = $sell->dailysetup;
        $kyat =  ($daily_setup->daily_price/16 * $product->quality) - $limitation_price->price;
        $pal = $kyat / 16;
        $yway = $pal / 8;
        $daily_setup_data  = [
            'daily_setup_id' => $daily_setup->id,
            'kyat' => $kyat,
            'pal' => $pal,
            'yway' => $yway,
        ];

        $data = [
            'item' => $item,
            'sell' => $sell,
            'transaction' => $item->sell->transaction,
            'product' => $product,
            'created_by' => $sell->user,
            'customer' => $customer,
            'daily_setup' => $daily_setup_data,
        ];
        return response()->json(['data' => $data]);
    }
}
