<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Product;
use App\Models\Type;
use App\Models\Sell;
use App\Models\DailySetup;
use App\Models\Transaction;
use App\Models\ItemName;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
use DB;


class SellPosController extends Controller
{
    /**
     * Selling item from pos by cashier.
     *
     * @return \Illuminate\Http\Response
     */
    public function sell(Request $request)
    {
        if($request->id != null){
            $transaction_id = $this->sellingItem($request);
        }else{
            $transaction_id = $this->sellingNewItem($request);
        }
        return response()->json(['status'=>true, 'transaction_id'=>$transaction_id]);

    }
    /**
     * Selling item that don't exist in system and saving new item and then sell
     *
     * @return \Illuminate\Http\Response
     */
    public function sellingNewItem(Request $request)
    {
        // dd($request->all());
        //check id
        //id is equal null , assume it is new
        //id not equql null, assume that it is the old one and update this.
        try {
            DB::beginTransaction();

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
            $nitem->gold_plus_gem_weight = $request->gold_plus_gem_weight;
            $nitem->gem_weight = $request->gem_weight;
            $nitem->fee = $request->fee;
            $nitem->fee_for_making = $request->fee_for_making;

            $nitem->image = $image_name_path;
            $nitem->draft = '1';
            $nitem->sold_out = '1';
            $nitem->save();

            $transaction = new Transaction;
            $transaction->business_id =  $business_id;
            $transaction->business_location_id = $business_location_id;
            $transaction->type = "sell";
            $transaction->status = "received";
            $transaction->payment_status = "paid";
            $transaction->contact_id = $request->customer_id;
            $transaction->invoice_no = $this->invoiceNumber();
            $transaction->transaction_date = Carbon::now()->format('Y-m-d');
            $transaction->before_total = $request->before_total;
            $transaction->final_total = $request->final_total;
            $transaction->paid_money = $request->paid_money;
            $transaction->credit_money = $request->credit_money;
            $transaction->discount_amount = $request->discount_amount;
            $transaction->created_by = $created_by;
            $transaction->save();

            //daily setup id
            $daily_setup = json_decode($request->daily_Setup);
            if($daily_setup->daily_setup_id == ""){
                $daily = DailySetup::create([
                    'type ' => 'gold',
                    'daily_price' => $daily_setup->quality_16_pal,
                    'business_id' => $business_id,
                    'customize' => '1'
                ]);
                $daily_setup_id = $daily->id;
            }else $daily_setup_id =  $daily_setup->daily_setup_id;

            $sell = new Sell;
            $sell->item_id = $nitem->id;
            $sell->transaction_id = $transaction->id;
            $sell->created_by = $created_by;
            $sell->daily_setup_id = $daily_setup_id;
            $sell->customer_id = $request->customer_id;
            $sell->gold_price = $request->gold_price;
            $sell->gem_price = $request->gem_price;
            $sell->fee = $request->fee;
            $sell->fee_price = $request->fee_price;
            $sell->fee_for_making = $request->fee_for_making;
            $sell->before_total = $request->before_total;
            $sell->final_total = $request->final_total;
            $sell->paid_money = $request->paid_money;
            $sell->credit_money = $request->credit_money;
            $sell->discount_amount = $request->discount_amount;
            $sell->save();

            DB::commit();
            return $transaction->id;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Selling item that already exist in system
     *
     * @return \Illuminate\Http\Response
    */
    public function sellingItem(Request $request)
    {

        try {
            DB::beginTransaction();
            $business_id = Auth::user()->business_id;
            $business_location_id = Auth::user()->business_location_id;
            $created_by = Auth::user()->id;

            $transaction = new Transaction;
            $transaction->business_id =  $business_id;
            $transaction->business_location_id = $business_location_id;
            $transaction->type = "sell";
            $transaction->status = "received";
            $transaction->payment_status = "paid";
            $transaction->contact_id = $request->customer_id;
            $transaction->invoice_no = $this->invoiceNumber();
            $transaction->transaction_date = Carbon::now()->format('Y-m-d');
            $transaction->before_total = $request->before_total;
            $transaction->final_total = $request->final_total;
            $transaction->paid_money = $request->paid_money;
            $transaction->credit_money = $request->credit_money;
            $transaction->discount_amount = $request->discount_amount;
            // $transaction->additional_notes = $request->note;
            $transaction->created_by = $created_by;
            $transaction->save();

            $daily_setup = json_decode($request->daily_Setup);
            if($daily_setup->daily_setup_id == ""){
                $daily = DailySetup::create([
                    'type ' => 'gold',
                    'daily_price' => $daily_setup->quality_16_pal,
                    'business_id' => $business_id,
                    'customize' => '1'
                ]);
                $daily_setup_id = $daily->id;
            }else $daily_setup_id =  $daily_setup->daily_setup_id;

            $sell = new Sell;
            $sell->item_id = $request->id;
            $sell->transaction_id = $transaction->id;
            $sell->created_by = $created_by;
            $sell->daily_setup_id = $daily_setup_id;
            $sell->customer_id = $request->customer_id;
            $sell->gold_price = $request->gold_price;
            $sell->gem_price = $request->gem_price;
            $sell->fee = $request->fee;
            $sell->fee_price = $request->fee_price;
            $sell->fee_for_making = $request->fee_for_making;
            $sell->before_total = $request->before_total;
            $sell->final_total = $request->final_total;
            $sell->paid_money = $request->paid_money;
            $sell->credit_money = $request->credit_money;
            $sell->discount_amount = $request->discount_amount;
            $sell->save();

            $item = Item::find($request->id);
            $item->gold_plus_gem_weight = $request->gold_plus_gem_weight;
            $item->gem_weight = $request->gem_weight;
            $item->fee = $request->fee;
            $item->fee_for_making = $request->fee_for_making;
            $item->sold_out = '1';
            $item->save();

            DB::commit();
            return $transaction->id;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Generate Invoice
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function generateInvoice($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);
        if(!$transaction) return false;
        $item = $transaction->sell->item;
        $item->gold_plus_gem_weight = json_decode($item->gold_plus_gem_weight);
        $item->gem_weight = json_decode($item->gem_weight);
        $item->fee = json_decode($item->fee);

        $product = Product::find($item->product_id);
        return Inertia::render('PosPanel/Pos/Invoice', [
            'transaction' => $transaction,
            'sell' => $transaction->sell,
            'item' => $item,
            'product' => $transaction->sell->item->product,
            'business' => $transaction->business,
            'businessLocation' => $transaction->businessLocation,
            'contact' => $transaction->contact,

        ]);
    }

    /**
     * Generate Invoice number for sell.
    */
    public function invoiceNumber()
    {
        $transactionLatest = Transaction::where('business_id',Auth::user()->business_id)
                            ->where('type','sell')
                            ->latest()
                            ->first();
        if (! $transactionLatest) {
            return 'arm00001';
        }
        $string = preg_replace("/[^0-9\.]/", '', $transactionLatest->invoice_no);
        return 'arm' . sprintf('%04d', $string+1);
    }

    public function cart(){
        return Inertia::render('PosPanel/Pos/Cart');
    }
    public function printAllFromCart(){
        return Inertia::render('PosPanel/Pos/PrintAllFromCart');
    }
    public function daily_setup(){
        return Inertia::render('PosPanel/Pos/DailySetup/DailySetupLists');
    }
}
