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

    public function search(Request $request)
    {
        $products = Product::where('product_sku', $request->product_sku)
                    ->first();
        // dd($products->id);
        $item_spe = $request->item_spe;
        $kyat = (int)($item_spe[0].$item_spe[1]);
        $pal = (int)($item_spe[2].$item_spe[3]);
        $yway = (int)($item_spe[4]);
        // dd($kyat."ssdd".$pal."jjj".$yway);
        $items_data = Item::where('business_id',1)
                ->where('product_id',$products->id)
                ->whereJsonContains('gold_weight->kyat', $kyat)
                ->whereJsonContains('gold_weight->pal', $pal)
                ->whereJsonContains('gold_weight->yway', $yway)
                ->get()
                ->toArray();
                // dd($items_data);
        if(empty($items_data)) return response()->json(['items'=>[], 'message'=>'new item']);
        $items = [];
        foreach ($items_data as $key => $item) {
            $items[$key]['id'] = $item["id"];
            $items[$key]['product_sku'] =  $request->product_sku.$request->item_spe;
            $items[$key]['name'] = $item["name"];
            $items[$key]['image1'] = $item["image1"];
            $items[$key]['quality'] = $products->quality;
            $items[$key]['fee_for_making'] = $item["fee_for_making"];
            $items[$key]['gold_weight'] = json_decode($item['gold_weight']);
            $items[$key]['gem_weight'] = json_decode($item['gem_weight']);
            $items[$key]['fee'] = json_decode($item['fee']);
        }
        return response()->json(['items'=>$items, 'message'=>'existing']);
    }

    public function productSkuSearch($sku)
    {
        $product_sku_list =  Product::where('business_id', Auth::user()->business_id)
                    ->where('product_sku', 'LIKE', '%'.$sku.'%')
                    ->pluck('product_sku');

        return response()->json(['productsku'=>$product_sku_list]);

    }

    public function getGoldQualitys()
    {
        $goldQualitys = Product::orderBy('quality', 'desc')
            ->where('business_id', Auth::user()->business_id)
            ->select('quality')
            ->groupBy('quality')
            ->get()
            ->toArray();
        foreach($goldQualitys as $key=>$value) {
            $goldQualitys[$key]['name'] = $value['quality'] . "ပဲရည်";

        }
        return response()->json(['goldQualitys'=>$goldQualitys]);
    }

    public function getTypesAndNames()
    {
        $types = Type::where('business_id', Auth::user()->business_id)
            ->select('name', 'key')
            ->get()
            ->toArray();
        $item_names = ItemName::where('business_id', Auth::user()->business_id)
            ->select('name', 'key')
            ->get()
            ->toArray();

        return response()->json(['types' => $types , 'item_names' => $item_names]);
    }

}
