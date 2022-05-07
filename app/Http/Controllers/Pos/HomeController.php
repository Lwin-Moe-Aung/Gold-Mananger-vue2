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

    function invoiceNumber()
    {
        $transactionLatest = Transaction::where('business_id',Auth::user()->business_id)
                            ->latest()
                            ->first();
        if (! $transactionLatest) {
            return 'arm00001';
        }
        $string = preg_replace("/[^0-9\.]/", '', $transactionLatest->invoice_no);
        return 'arm' . sprintf('%04d', $string+1);
    }

    public function saveOrder(Request $request)
    {
        // dd($request->all());
        if($request->id != null){
            $business_id = Auth::user()->business_id;
            $business_location_id = Auth::user()->business_location_id;
            $created_by = Auth::user()->id;
            $transactionLatest = Transaction::where('business_id',$business_id)
                            ->latest()
                            ->first();

            $transaction = new Transaction;
            $transaction->business_id =  $business_id;
            $transaction->business_location_id = $business_location_id;
            $transaction->type = "sell";
            $transaction->status = "received";
            $transaction->payment_status = "paid";
            $transaction->contact_id = 1;
            $transaction->invoice_no = $this->invoiceNumber();
            $transaction->transaction_date = Carbon::now()->format('Y-m-d');
            $transaction->total_before = $request->total_before;
            $transaction->discount_type = 'fixed';
            $transaction->discount_amount = $request->item_discount;
            // $transaction->shipping_details = $request->total_before;
            // $transaction->shipping_charges = $request->total_after;
            $transaction->additional_notes = $request->note;
            // $transaction->staff_note = $request->credit_money;
            $transaction->final_total = $request->final_total;
            $transaction->created_by = $created_by;
            $transaction->save();

            $order = new Order;
            $order->item_id = $request->id;
            $order->transaction_id = $transaction->id;
            $order->created_by = $created_by;
            $order->gold_weight = json_encode($request->gold_weight);
            $order->gold_price = $request->gold_price;
            $order->gem_weight = json_encode($request->gem_weight);
            $order->gem_price = $request->gem_price;
            $order->fee = json_encode($request->fee);
            $order->fee_price = $request->fee_price;
            $order->fee_for_making = $request->fee_for_making;
            $order->item_discount = $request->item_discount;
            $order->total_weight = json_encode(array("kyat"=>(string)$request->total_kyat, "pal"=>(string)$request->total_pal, "yway"=>(string)$request->total_yway));
            $order->total_before = $request->total_before;
            $order->final_total = $request->final_total;
            $order->paid_money = $request->paid_money;
            $order->credit_money = $request->credit_money;
            $order->note = $request->note;
            $order->save();

            return response()->json(['status'=>true, 'message'=>'Order success!']);
        }
        //check id
        //id is equal null , assume it is new
        //id not equql null, assume that it is the old one and update this.

        // $type = Type::where('key',$sku[2])
        //             ->first();
        // if($type == null){
        //     $ntype = new Type;
        //     $ntype->name = "New ".Carbon::now()->format('Y-m-d H:i:s');
        //     $ntype->key = $sku[2];
        //     $ntype->business_id = Auth::user()->business_id;
        //     $ntype->save();

        // }
        // $itemname = ItemName::where('key',$sku[3])
        //             ->first();
        // if($itemname == null){
        //     $nitemname = new ItemName;
        //     $nitemname->name = "New ".Carbon::now()->format('Y-m-d H:i:s');
        //     $nitemname->key = $sku[3];
        //     $nitemname->business_id = Auth::user()->business_id;
        //     $nitemname->save();
        // }
        // $quality = $sku[0].$sku[1];
        // $nproduct = new Product;
        // $nproduct->name = "New Product".Carbon::now()->format('Y-m-d H:i:s');
        // $nproduct->product_sku = $sku;
        // $nproduct->quality = (int)$quality;
        // $nproduct->business_id = Auth::user()->business_id;
        // $nproduct->created_by = Auth::user()->id;
        // $nproduct->save();


        // $kyat = $sku[4].$sku[5];
        // $pal = $sku[6].$sku[7];
        // $yway = $sku[8];

        // $nitem = new Item;
        // $nitem->name = "New Product".Carbon::now()->format('Y-m-d H:i:s');
        // $nitem->product_id = $nproduct->id;
        // $nitem->business_location_id = Auth::user()->business_location_id;
        // $nitem->created_by = Auth::user()->id;
        // $nitem->item_sku = rand(10000,100000);
        // $nitem->gold_weight = json_encode(array("kyat"=>(int)$kyat, "pal"=>(int)$pal, "yway"=>(int)$yway));
        // $nitem->gem_weight = '{"kyat": "0","pal": "0","yway": "0"}';
        // $nitem->fee = '{"kyat": "0","pal": "3","yway": "0"}';
        // $nitem->fee_for_making = '0';
        // $nitem->draft = '1';
        // $nitem->save();

        // $items['id'] = $nitem->id;
        // $items['name'] = $nitem->name;
        // $items['image1'] = $nitem->image1;
        // $items['quality'] = (string)$nproduct->quality;
        // $items['fee_for_making'] = $nitem->fee_for_making;
        // $items['gold_weight'] = json_decode($nitem['gold_weight']);
        // $items['gem_weight'] = json_decode($nitem['gem_weight']);
        // $items['fee'] = json_decode($nitem['fee']);

        // return response()->json(['items'=>$items, 'message'=>'new item']);
    }
}
