<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Sell;

use App\Models\Transaction;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,city']
        ]);

        $business_id = auth()->user()->business_id;

        $transactions = Transaction::query();
        $transactions->where('business_id', $business_id)
                    ->where('type','purchase_return');
                    // ->with('purchaseReturn');
                    // ->whereHas("purchase",function($q){
                    //     $q->where("purchase_return",'1');
                    // });
        if (request('search')) {
            $transactions->where('invoice_no', 'LIKE', '%' . request('search') . '%');
        }
        if (request()->has(['field', 'direction'])) {
            $transactions->orderBy(request('field'), request('direction'));
        }else{
            $transactions->orderBy('created_at', 'desc');
        }
        $transactions = $transactions->paginate(5)->withQueryString();
        foreach ($transactions as $key=>$value) {
            $transactions[$key]->purchaseReturn = $value->purchaseReturn;
            $transactions[$key]->item = $value->purchaseReturn->item;
            $transactions[$key]->product = $value->purchaseReturn->item->product;
        }
        // dd($transactions);
        return Inertia::render('AdminPanel/PurchaseManagement/PurchasesReturn/Index', [
            'transactions' => $transactions,
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $business_id = auth()->user()->business_id;
        $products = Product::where('business_id', $business_id)
            ->get();
        $suppliers = Contact::where('business_id', $business_id)
            ->where('type', 'supplier')
            ->get();
        return Inertia::render('AdminPanel/PurchaseManagement/PurchasesReturn/Create',[
            'products' => $products,
            'suppliers' => $suppliers,
            'transaction' => null,
            'purchase' => null,
            'item' => null,
            'product_for_sku' => null,
            'contact' => null,
            'daily_setup_list' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'daily_setup' => ['required'],
                'gold_plus_gem_weight' => ['required'],
                'gold_price' => ['required'],
                'gem_weight' => ['required'],
                'gem_price' => ['required'],
                'fee' => ['required'],
                'fee_price' => ['required'],
                'fee_for_making' => ['required'],
                'before_total' => ['required'],
                'final_total' => ['required'],
                'customer_id' => ['required'],

            ]);
            DB::beginTransaction();
            try {
                $business_id = Auth::user()->business_id;
                $business_location_id = Auth::user()->business_location_id;
                $created_by = Auth::user()->id;

                $transaction = new Transaction;
                $transaction->business_id =  $business_id;
                $transaction->business_location_id = $business_location_id;
                $transaction->type = "purchase_return";
                $transaction->status = "received";
                $transaction->payment_status = "paid";
                $transaction->contact_id = $request->customer_id;
                $transaction->invoice_no = $this->invoiceNumber();
                $transaction->transaction_date = Carbon::now()->format('Y-m-d');
                $transaction->additional_notes = $request->additional_note;
                $transaction->created_by = $created_by;
                $transaction->save();

                if($request->sell_id != null ){
                    Sell::where('id', $request->sell_id)
                        ->update([
                            'purchase_return' => '1'
                        ]);
                }
                $item = Item::find($request->item_id);
                $item->gold_plus_gem_weight = json_encode($request->gold_plus_gem_weight);
                $item->gem_weight = json_encode($request->gem_weight);
                $item->fee = json_encode($request->fee);
                $item->fee_for_making = $request->fee_for_making;
                $item->sold_out = '0';
                $item->purchase_return = '1';
                $item->item_description = $request->item_description;
                if ($file = $request->file('image')) {
                    $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                    $path = '/images/items/';
                    $file->move(public_path($path), $image_name);
                    $image_name_path = $path . $image_name;
                    $item->image = $image_name_path;
                }
                $item->save();


                if($request->daily_setup["daily_setup_id"] == null){
                    $daily = DailySetup::create([
                        'type ' => 'gold',
                        'daily_price' => $request->daily_setup["quality_16_pal"],
                        'business_id' => $business_id,
                        'customize' => '1'
                    ]);
                    $daily_setup_id = $daily->id;
                }else $daily_setup_id = $request->daily_setup["daily_setup_id"];

                $purchase_return = new PurchaseReturn;
                $purchase_return->item_id = $request->item_id;
                $purchase_return->transaction_id = $transaction->id;
                $purchase_return->created_by = $created_by;
                $purchase_return->daily_setup_id = $daily_setup_id;
                $purchase_return->customer_id = $request->customer_id;
                $purchase_return->gold_plus_gem_weight = json_encode($request->gold_plus_gem_weight);
                $purchase_return->gold_price = $request->gold_price;
                $purchase_return->gem_weight = json_encode($request->gem_weight);
                $purchase_return->gem_price = $request->gem_price;
                $purchase_return->fee = json_encode($request->fee);
                $purchase_return->fee_price = $request->fee_price;
                $purchase_return->fee_for_making = $request->fee_for_making;
                $purchase_return->before_total = $request->before_total;
                $purchase_return->final_total = $request->final_total;
                $purchase_return->credit_money = $request->credit_money;
                $purchase_return->discount_amount = $request->discount_amount;
                $purchase_return->save();
                DB::commit();
                return redirect()->route('admin.purchase_returns.index');
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        return back()->with('fail', 'No permission');

    }

     /**
     * Generate Invoice Number
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function invoiceNumber()
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
