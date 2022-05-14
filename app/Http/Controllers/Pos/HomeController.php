<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Product;
use App\Models\Type;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\ItemName;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
use DB;


class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('PosPanel/Pos/Home');
    }

    public function productList()
    {
        $business_id = Auth::user()->business_id;
        $products = Product::select('id', 'name', 'product_sku', 'image', 'quality')
            ->where('business_id', $business_id)
            ->get()
            ->toArray();
        return response()->json($products, 200);
    }

    public function search($sku)
    {
        // check sku format and key exist?
        // check product exist ??
        // if product doesn't exist
            // save new product and new item
            // return selected item that formatted

        $products = Product::where('product_sku',$sku)
                    ->with('item')
                    ->first();
        if($products == null) return response()->json(['items'=>[], 'message'=>'new item']);
        $items = [];
        foreach ($products->item as $key => $item) {
            $items[$key]['id'] = $item->id;
            $items[$key]['product_sku'] = $sku;
            $items[$key]['name'] = $item->name;
            $items[$key]['image1'] = $item->image1;
            $items[$key]['quality'] = $products->quality;
            $items[$key]['fee_for_making'] = $item->fee_for_making;
            $items[$key]['gold_weight'] = json_decode($item['gold_weight']);
            $items[$key]['gem_weight'] = json_decode($item['gem_weight']);
            $items[$key]['fee'] = json_decode($item['fee']);
        }
        return response()->json(['items'=>$items, 'message'=>'existing']);


    }


}
