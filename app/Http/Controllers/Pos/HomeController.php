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

    public function searchOld(Request $request)
    {
        $products = Product::where('product_sku', $request->product_sku)
                    ->first();
        // dd($products->id);
        $item_spe = $request->item_spe;
        if($item_spe != null){
            $kyat = (int)($item_spe[0].$item_spe[1]);
            $pal = (int)($item_spe[2].$item_spe[3]);
            $yway = (int)($item_spe[4]);
            // dd((string)$kyat);
            $items_data = Item::where('product_id',$products->id)
                    ->where('sold_out', '0')
                    ->whereJsonContains('gold_plus_gem_weight->kyat', (string)$kyat)
                    ->whereJsonContains('gold_plus_gem_weight->pal', (string)$pal)
                    ->whereJsonContains('gold_plus_gem_weight->yway', (string)$yway)
                    ->get()
                    ->toArray();
            $message = $request->product_sku.$item_spe."အောက်မှာရှိတဲ့ ပစ္စည်းများ.";
        }else{
            $items_data = Item::where('product_id',$products->id)
                    ->inRandomOrder()
                    ->get()
                    ->toArray();
            $message = $request->product_sku."အောက်မှာရှိတဲ့ random ပစ္စည်းများ.";

        }
        if(empty($items_data)) return response()->json(['items'=>[], 'message'=>'newItem']);
        $items = [];
        foreach ($items_data as $key => $item) {
            $gold_plus_gem_weight = json_decode($item['gold_plus_gem_weight']);
            $kyat = strlen((string)$gold_plus_gem_weight->kyat) < 2 ? "0".$gold_plus_gem_weight->kyat : $gold_plus_gem_weight->kyat;
            $pal = strlen((string)$gold_plus_gem_weight->pal) < 2 ? "0".$gold_plus_gem_weight->pal : $gold_plus_gem_weight->pal;
            $items[$key]['item_spe'] = $kyat.$pal.$gold_plus_gem_weight->yway;

            $items[$key]['id'] = $item["id"];
            $items[$key]['product_sku'] =  $request->product_sku;
            $items[$key]['name'] = $item["name"];
            $items[$key]['image'] = $item["image"];
            $items[$key]['quality'] = $products->quality;
            $items[$key]['item_sku'] = $item["item_sku"];
            $items[$key]['fee_for_making'] = $item["fee_for_making"];
            $items[$key]['gold_plus_gem_weight'] = $gold_plus_gem_weight;
            $items[$key]['gem_weight'] = json_decode($item['gem_weight']);
            $items[$key]['fee'] = json_decode($item['fee']);
        }
        return response()->json(['items'=>$items, 'message'=> $message]);
    }

    public function search(Request $request)
    {
        $products = Product::where('product_sku', $request->product_sku)
                    ->first();

        $items_data = Item::where('product_id',$products->id)
                ->where('sold_out','0')
                ->inRandomOrder()
                ->get();

        if($items_data->isEmpty()) return response()->json(['items'=>[], 'message'=>'newItem']);
        $items = [];
        foreach ($items_data as $key => $item) {
            // $gold_plus_gem_weight = json_decode($item->gold_plus_gem_weight);
            $gold_plus_gem_weight = $item->gold_plus_gem_weight;

            $kyat = strlen((string)$gold_plus_gem_weight->kyat) < 2 ? "0".$gold_plus_gem_weight->kyat : $gold_plus_gem_weight->kyat;
            $pal = strlen((string)$gold_plus_gem_weight->pal) < 2 ? "0".$gold_plus_gem_weight->pal : $gold_plus_gem_weight->pal;
            $items[$key]['item_spe'] = $kyat.$pal.$gold_plus_gem_weight->yway;

            $items[$key]['id'] = $item->id;
            $items[$key]['product_sku'] =  $request->product_sku;
            $items[$key]['name'] = $item->name;
            $items[$key]['image'] = $item->image;
            $items[$key]['quality'] = $item->product->quality;
            $items[$key]['item_sku'] = $item->item_sku;
            $items[$key]['fee_for_making'] = $item->fee_for_making;
            $items[$key]['gold_plus_gem_weight'] = $gold_plus_gem_weight;
            // $items[$key]['gem_weight'] = json_decode($item->gem_weight);
            $items[$key]['gem_weight'] = $item->gem_weight;

            $items[$key]['gem_price'] = $item->purchase->gem_price;
            // $items[$key]['fee'] = json_decode($item->fee);
            $items[$key]['fee'] = $item->fee;

            $items[$key]['gem_weight_status'] = $item->product->gem_weight == '0' ? false: true;
        }
        return response()->json(['items'=>$items, 'message'=> $request->product_sku."အောက်မှာရှိတဲ့ random ပစ္စည်းများ."]);
    }

    public function productSkuSearch($sku)
    {
        $product_sku_list =  Product::where('business_id', Auth::user()->business_id)
                    ->where('product_sku', 'LIKE', '%'.$sku.'%')
                    // ->pluck('product_sku');
                    ->get();

        return response()->json(['productsku'=>$product_sku_list]);

    }

    public function getDataForCombobox()
    {
        $business_id = Auth::user()->business_id;
        $goldQualitys = Product::orderBy('quality', 'desc')
            ->where('business_id',$business_id)
            ->select('quality')
            ->groupBy('quality')
            ->get()
            ->toArray();

        foreach($goldQualitys as $key=>$value) {
            $goldQualitys[$key]['name'] = $value['quality'] . "ပဲရည်";

            $types_ids = Product::where('business_id', $business_id)
                    ->where('quality', $value['quality'])
                    ->select('type_id')
                    ->groupBy('type_id')
                    ->pluck('type_id');
            $types = DB::table('types')->whereIn('id',$types_ids)->get()->toArray();
            $goldQualitys[$key]["types"] = $types;
            //get data from item_name table
            $it_ns = [];
            foreach($goldQualitys[$key]["types"] as $key1=>$val) {
                $item_names_ids = Product::where('business_id', $business_id)
                        ->where('type_id', $val->id)
                        ->where('quality', $value['quality'])
                        ->select('item_names_id')
                        ->groupBy('item_names_id')
                        ->pluck('item_names_id');
                $item_names = DB::table('item_names')->whereIn('id',$item_names_ids)->get()->toArray();
                $goldQualitys[$key]["types"][$key1]->item_names = $item_names;
            }
        }
        return response()->json(['goldQualitys'=>$goldQualitys]);
    }

    public function searchByItemId(Request $request)
    {

        $item_id = $request->item_id;
        $item = Item::where('item_sku',$item_id)->first();
        if($item == null)  return response()->json(['items'=>[], 'message'=>'no data']);
        $product = Product::find($item->product_id);

        $business_id = Auth::user()->business_id;
        $gold_plus_gem_weight = json_decode($item->gold_plus_gem_weight) ;
        $items_data = Item::where('product_id',$product->id)
            ->where('sold_out', '0')
            ->whereJsonContains('gold_plus_gem_weight->kyat', $gold_plus_gem_weight->kyat)
            ->whereJsonContains('gold_plus_gem_weight->pal', $gold_plus_gem_weight->pal)
            ->whereJsonContains('gold_plus_gem_weight->yway', $gold_plus_gem_weight->yway)
            ->get()
            ->toArray();

        $items = [];
        foreach ($items_data as $key => $item) {
            $gold_plus_gem_weight = json_decode($item['gold_plus_gem_weight']);
            $kyat = strlen((string)$gold_plus_gem_weight->kyat) < 2 ? "0".$gold_plus_gem_weight->kyat : $gold_plus_gem_weight->kyat;
            $pal = strlen((string)$gold_plus_gem_weight->pal) < 2 ? "0".$gold_plus_gem_weight->pal : $gold_plus_gem_weight->pal;
            $items[$key]['item_spe'] = $kyat.$pal.$gold_plus_gem_weight->yway;

            $items[$key]['id'] = $item["id"];
            $items[$key]['product_sku'] =  $product->product_sku;
            $items[$key]['name'] = $item["name"];
            $items[$key]['item_sku'] = $item["item_sku"];
            $items[$key]['image'] = $item["image"];
            $items[$key]['quality'] = $product->quality;
            $items[$key]['fee_for_making'] = $item["fee_for_making"];
            $items[$key]['gold_plus_gem_weight'] = json_decode($item['gold_plus_gem_weight']);
            $items[$key]['gem_weight'] = json_decode($item['gem_weight']);
            $items[$key]['fee'] = json_decode($item['fee']);
        }
        return response()->json(['items'=>$items, 'message'=>'success']);
    }
}
