<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Product;
use App\Models\Type;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\ItemName;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
use DB;


class CustomerOrderController extends Controller
{
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
            $order_id = $this->savingOldItemOrder($request);
            return response()->json(['status'=>true, 'order_id'=>$order_id]);

        }else{
            $order_id = $this->savingNewItemOrder($request);
            return response()->json(['status'=>true, 'order_id'=>$order_id]);
        }
    }
    public function savingNewItemOrder(Request $request)
    {
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
            $nproduct = Product::where('product_sku', $request->product_sku)->first();

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
            $nitem->business_id = $business_id;

            $nitem->business_location_id = $business_location_id;
            $nitem->created_by = $created_by;
            $nitem->item_sku = rand(10000,100000);
            $nitem->gold_price = $request->gold_price;
            $nitem->gold_weight = $request->gold_weight;
            $nitem->gem_price = $request->gem_price;
            $nitem->gem_weight = $request->gem_weight;
            $nitem->fee_price = $request->fee_price;
            $nitem->fee = $request->fee;
            $nitem->fee_for_making = $request->fee_for_making;

            $nitem->item_discount = $request->item_discount;
            $nitem->image1 = $image_name_path;
            $nitem->draft = '1';
            $nitem->sold_out = '1';
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
            $order->business_id = $business_id;
            $order->business_location_id = $business_location_id;

            $order->total_weight = json_encode(array("kyat"=>(string)$request->total_kyat, "pal"=>(string)$request->total_pal, "yway"=>(string)$request->total_yway));
            $order->total_before = $request->total_before;
            $order->final_total = $request->final_total;
            $order->paid_money = $request->paid_money;
            $order->credit_money = $request->credit_money;
            $order->note = $request->note;
            $order->save();

            DB::commit();
            return $order->id;
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
            $order->business_id = $business_id;
            $order->business_location_id = $business_location_id;

            $order->total_weight = json_encode(array("kyat"=>(string)$request->total_kyat, "pal"=>(string)$request->total_pal, "yway"=>(string)$request->total_yway));
            $order->total_before = $request->total_before;
            $order->final_total = $request->final_total;
            $order->paid_money = $request->paid_money;
            $order->credit_money = $request->credit_money;
            $order->discount_amount = $request->item_discount;
            $order->note = $request->note;
            $order->save();

            $item = Item::find($request->id);
            $item->gold_weight = $request->gold_weight;
            $item->gold_price = $request->gold_price;
            $item->gem_weight = $request->gem_weight;
            $item->gem_price = $request->gem_price;
            $item->fee = $request->fee;
            $item->fee_price = $request->fee_price;
            $item->fee_for_making = $request->fee_for_making;
            $item->sold_out = '1';
            $item->save();

            DB::commit();
            return $order->id;
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
    public function generateInvoice($order_id)
    {
        $order = Order::find($order_id);
        if($order == null) return false;
        $order->total_weight = json_decode($order->total_weight);
        $transaction = Transaction::where('id',$order->transaction_id)
                    ->with('business')
                    ->with('businessLocation')
                    ->with('contact')
                    ->first();

        $item = Item::find($order->item_id);
        $item->gold_weight = json_decode($item->gold_weight);
        $item->gem_weight = json_decode($item->gem_weight);
        $item->fee = json_decode($item->fee);

        $product = Product::find($item->product_id);
        return Inertia::render('PosPanel/Pos/Invoice', [
            'order' => $order,
            'transaction' => $transaction,
            'item' => $item,
            'product' => $product
        ]);
    }

    public function jsonSearch(){
        $kyat = '9';
        $pal = 2;
        $yway = 3;
        $item = Item::where('business_id',1)
                    ->whereJsonContains('gold_weight->kyat', $kyat)
                    ->get()
                    ->toArray();
        dd($item);
    }
}
