<?php

namespace App\Http\Controllers\Admins;

use DB;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\Sell;
use Inertia\Inertia;
use App\Models\Contact;
use App\Models\Product;

use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\PurchaseReturn;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Facade\FlareClient\Http\Response;
use App\Http\Requests\Admins\PurchaseReturnRequest;
use App\Services\GenerateInvoiceService;

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
                    ->where('type','purchase_return')
                    ->with('purchase')
                    ->whereHas("purchase",function($q){
                        $q->where("purchase_return",'1');
                    });
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
            $transactions[$key]->purchase = $value->purchase;
            $transactions[$key]->item = $value->purchase->item;
            $transactions[$key]->product = $value->purchase->item->product;
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
    public function store(PurchaseReturnRequest $request)
    {
        // dd("ssssggggg");
        try {
            DB::beginTransaction();
            $business_id = Auth::user()->business_id;
            $business_location_id = Auth::user()->business_location_id;
            $created_by = Auth::user()->id;

            if ($file = $request->file('image')) {
                $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                $path = '/images/items/';
                $file->move(public_path($path), $image_name);
                $image_name_path = $path . $image_name;
            } else {
                $image_name_path = '/images/items/item_default.jfif';
            }

            if($request->item_id == null ){
                $item = Item::create([
                    'name' => $request->name,
                    'product_id' => $request->product_id,
                    'business_id' => $business_id,
                    'business_location_id' => $business_location_id,
                    'created_by' => $created_by,
                    'item_sku' => rand(10000,100000),
                    'gold_plus_gem_weight' => json_encode($request->gold_plus_gem_weight),
                    'gem_weight' => json_encode($request->gem_weight),
                    'fee' =>  json_encode($request->fee),
                    'fee_for_making' =>  $request->fee_for_making,
                    'image' => $image_name_path,
                    'item_description' =>  $request->item_description,
                ]);
            }else{
                $item = Item::find($request->item_id);
                $item->gold_plus_gem_weight = json_encode($request->gold_plus_gem_weight);
                $item->gem_weight = json_encode($request->gem_weight);
                $item->fee = json_encode($request->fee);
                $item->fee_for_making = $request->fee_for_making;
                $item->sold_out = '0';
                $item->item_description = $request->item_description;
                $item->image = $request->file('image') ? $image_name_path : $item->image;
                $item->save();
            }

            $transaction = new Transaction;
            $transaction->business_id =  $business_id;
            $transaction->business_location_id = $business_location_id;
            $transaction->type = "purchase_return";
            $transaction->status = "received";
            $transaction->payment_status = "paid";
            $transaction->contact_id = $request->customer_id;
            $transaction->invoice_no = (new GenerateInvoiceService())->invoiceNumber('purchase_return');
            $transaction->transaction_date = Carbon::now()->format('Y-m-d');
            $transaction->additional_notes = $request->additional_note;
            $transaction->before_total = $request->final_total;
            $transaction->final_total = $request->final_total;
            $transaction->paid_money = $request->paid_money;
            $transaction->exceed_money = $request->exceed_money;
            $transaction->created_by = $created_by;
            $transaction->save();

            if($request->daily_setup["daily_setup_id"] == null){
                $daily = DailySetup::create([
                    'type ' => 'gold',
                    'daily_price' => $request->daily_setup["quality_16_pal"],
                    'business_id' => $business_id,
                    'customize' => '1'
                ]);
                $daily_setup_id = $daily->id;
            }else $daily_setup_id = $request->daily_setup["daily_setup_id"];

            $purchase = new Purchase;
            $purchase->item_id = $item->id;
            $purchase->transaction_id = $transaction->id;
            $purchase->created_by = $created_by;
            $purchase->daily_setup_id = $daily_setup_id;
            $purchase->supplier_id = $request->customer_id;
            $purchase->gold_plus_gem_weight = json_encode($request->gold_plus_gem_weight);
            $purchase->gold_price = $request->gold_price;
            $purchase->gem_weight = json_encode($request->gem_weight);
            $purchase->gem_price = $request->gem_price;
            $purchase->fee = json_encode($request->fee);
            $purchase->fee_price = $request->fee_price;
            $purchase->fee_for_making = $request->fee_for_making;
            $purchase->before_total = $request->final_total;
            $purchase->final_total = $request->final_total;
            $purchase->purchase_return = "1";
            $purchase->exceed_money = $request->exceed_money;
            $purchase->paid_money = $request->paid_money;
            $purchase->save();

            DB::commit();
            return redirect()->route('admin.purchase_returns.index');
        } catch (\Exception $e) {
            DB::rollback();
        }
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
