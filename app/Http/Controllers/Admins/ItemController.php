<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Item;
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
}
