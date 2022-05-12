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
        if($request->id != null){
            $this->savingOldItemOrder($request);
            return back();

            // return response()->json(['status'=>true, 'message'=>'Order success!']);
        }else{
            $this->savingNewItemOrder($request);
            return back();
        }

    }
    public function savingNewItemOrder(Request $request)
    {
        // dd($request->all());
        //check id
        //id is equal null , assume it is new
        //id not equql null, assume that it is the old one and update this.
        DB::beginTransaction();
        try {
            $business_id = Auth::user()->business_id;
            $business_location_id = Auth::user()->business_location_id;
            $created_by = Auth::user()->id;

            $product_sku = $request->product_sku;
            $type = Type::where('key',$product_sku[2])
                        ->first();
            if($type == null){
                $ntype = new Type;
                $ntype->name = "New ".Carbon::now()->format('Y-m-d H:i:s');
                $ntype->key = $product_sku[2];
                $ntype->business_id = $business_id;
                $ntype->save();

            }
            $itemname = ItemName::where('key',$product_sku[3])
                        ->first();
            if($itemname == null){
                $nitemname = new ItemName;
                $nitemname->name = "New ".Carbon::now()->format('Y-m-d H:i:s');
                $nitemname->key = $product_sku[3];
                $nitemname->business_id = $business_id;
                $nitemname->save();
            }


            $quality = $product_sku[0].$product_sku[1];
            $nproduct = new Product;
            $nproduct->name = "New Product".Carbon::now()->format('Y-m-d H:i:s');
            $nproduct->product_sku = $request->product_sku;
            $nproduct->quality = (int)$quality;
            $nproduct->business_id = $business_id;
            $nproduct->created_by = $created_by;
            $nproduct->save();

            if ($file = $request->file('imageFile')) {
                $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                $path = '/images/items/';
                $file->move(public_path($path), $image_name);
                $image_name_path = $path . $image_name;
            } else {
                $image_name_path = null;
            }

            $nitem = new Item;
            $nitem->name = $request->name;
            $nitem->product_id = $nproduct->id;
            $nitem->business_location_id = $business_location_id;
            $nitem->created_by = $created_by;
            $nitem->item_sku = rand(10000,100000);
            $nitem->gold_price = $request->gold_price;
            $nitem->gold_weight = json_encode($request->gold_weight);
            $nitem->gem_price = $request->gem_price;
            $nitem->gem_weight = json_encode($request->gem_weight);
            $nitem->fee_price = $request->fee_price;
            $nitem->fee = json_encode($request->fee);
            $nitem->fee_for_making = $request->fee_for_making;

            $nitem->item_discount = $request->item_discount;
            $nitem->tax = $request->tax;
            $nitem->image1 = $image_name_path;

            $nitem->item_description = $request->item_description;

            $nitem->draft = '1';

            $nitem->save();

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
            $order->item_id = $nitem->id;
            $order->transaction_id = $transaction->id;
            $order->created_by = $created_by;
            $order->total_weight = json_encode(array("kyat"=>(string)$request->total_kyat, "pal"=>(string)$request->total_pal, "yway"=>(string)$request->total_yway));
            $order->total_before = $request->total_before;
            $order->final_total = $request->final_total;
            $order->paid_money = $request->paid_money;
            $order->credit_money = $request->credit_money;
            $order->note = $request->note;
            $order->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function savingOldItemOrder(Request $request)
    {
        DB::beginTransaction();
        try {
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
            $order->total_weight = json_encode(array("kyat"=>(string)$request->total_kyat, "pal"=>(string)$request->total_pal, "yway"=>(string)$request->total_yway));
            $order->total_before = $request->total_before;
            $order->final_total = $request->final_total;
            $order->paid_money = $request->paid_money;
            $order->credit_money = $request->credit_money;
            $order->note = $request->note;
            $order->save();

            $item = Item::find($request->id);
            $item->gold_weight = json_encode($request->gold_weight);
            $item->gold_price = $request->gold_price;
            $item->gem_weight = json_encode($request->gem_weight);
            $item->gem_price = $request->gem_price;
            $item->fee = json_encode($request->fee);
            $item->fee_price = $request->fee_price;
            $item->fee_for_making = $request->fee_for_making;
            $item->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function generateInvoice()
    {
        // dd("dadsas");
        return Inertia::render('PosPanel/Pos/Invoice');

    }
}
