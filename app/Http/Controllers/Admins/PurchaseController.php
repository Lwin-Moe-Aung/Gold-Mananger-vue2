<?php

namespace App\Http\Controllers\Admins;

use DB;
use Carbon\Carbon;
use App\Models\Item;
use Inertia\Inertia;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Facade\FlareClient\Http\Response;
use App\Http\Requests\Admins\PurchaseRequest;

class PurchaseController extends Controller
{
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,city']
        ]);

        $business_id = auth()->user()->business_id;

        $transactions = Transaction::query();
        $transactions->where('business_id', $business_id)->where('type','purchase');
        if (request('search')) {
            $transactions->where('name', 'LIKE', '%' . request('search') . '%');
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
        return Inertia::render('AdminPanel/PurchaseManagement/Purchases/Index', [
            'transactions' => $transactions,
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    public function create()
    {
        $business_id = auth()->user()->business_id;
        $products = Product::where('business_id', $business_id)
            ->get();
        $suppliers = Contact::where('business_id', $business_id)
            ->where('type', 'supplier')
            ->get();
        return Inertia::render('AdminPanel/PurchaseManagement/Purchases/Create',[
            'products' => $products,
            'suppliers' => $suppliers,
            'transactions' => null,
            'purchase' => null,
            'item' => null,
            'product_for_sku' => null,
            'contact' => null,
            'daily_setup_list' => null,
        ]);
    }

    public function store(PurchaseRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($file = $request->file('image')) {
                $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                $path = '/images/items/';
                $file->move(public_path($path), $image_name);
                $image_name_path = $path . $image_name;
            } else {
                $image_name_path = '/images/items/item_default.jifif';
            }
            $item = Item::create([
                'name' => $request->name,
                'product_id' => $request->product_id,
                'business_id' => auth()->user()->business_id,
                'business_location_id' => auth()->user()->business_location_id,
                'created_by' => auth()->user()->id,
                'item_sku' => rand(10000,100000),
                'gold_plus_gem_weight' => json_encode($request->gold_plus_gem_weight),
                'gem_weight' => json_encode($request->gem_weight),
                'fee' =>  json_encode($request->fee),
                'fee_for_making' =>  $request->fee_for_making,
                'image' => $image_name_path,
                'item_description' =>  $request->item_description,
            ]);
            $transaction = Transaction::create([
                'business_id' => auth()->user()->business_id,
                'business_location_id' => auth()->user()->business_location_id,
                'type' => "purchase",
                'status' => "received",
                'payment_status' => "paid",
                'contact_id' => $request->supplier_id,
                'invoice_no' => $this->invoiceNumber(),
                'transaction_date' => Carbon::now()->format('Y-m-d'),
                'additional_notes' =>  $request->tran_description,
                'created_by' =>  auth()->user()->id,
            ]);
            Purchase::create([
                'transaction_id' => $transaction->id,
                'item_id' => $item->id,
                'created_by' => auth()->user()->id,
                'supplier_id' => $request->supplier_id,
                'daily_setup_id' => $request->daily_setup_id,
                'gold_price' => $request->gold_price,
                'gem_price' => $request->gem_price,
                'fee' =>  json_encode($request->fee),
                'fee_price' =>  $request->fee_price,
                'fee_for_making' =>  $request->fee_for_making,
                'discount_amount' => $request->item_discount,
                'before_total' =>  $request->before_total,
                'final_total' => $request->final_total,
            ]);
            DB::commit();
            return redirect()->route('admin.purchases.index');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Fail to Create New Product Type');
        }

    }

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

    public function edit($id)
    {
        $business_id = auth()->user()->business_id;
        $products = Product::where('business_id', $business_id)
            ->get();
        $suppliers = Contact::where('business_id', $business_id)
            ->where('type', 'supplier')
            ->get();
        $transactions = Transaction::find($id);
        $purchase = $transactions->purchase;
        $purchase->fee = json_decode($purchase->fee);
        $item = $transactions->purchase->item;
        $item->gold_plus_gem_weight = json_decode($item->gold_plus_gem_weight);
        $item->gem_weight = json_decode($item->gem_weight);

        $daily_setup = $transactions->purchase->dailysetup;
        $daily_price = $daily_setup->daily_price;
        $daily_kyat =  $daily_price / 16;
        $data = [];
        for ($x = 1; $x <= 16; $x++) {
            $kyat = $daily_price - ($daily_kyat * (16 - $x));
            $pal = $kyat / 16;
            $yway = $pal / 8;
            $data [$x] = [
                'daily_setup_id' => $daily_setup->id,
                'kyat' => $kyat,
                'pal' => $pal,
                'yway' => $yway,
            ];

        }
        return Inertia::render('AdminPanel/PurchaseManagement/Purchases/Create',[
            'products' => $products,
            'suppliers' => $suppliers,
            'transactions' => $transactions,
            'purchase' => $purchase,
            'item' => $item,
            'product_for_sku' => $transactions->purchase->item->product,
            'contact' => $transactions->purchase->contact,
            'daily_setup_list' => $data
        ]);
    }

    public function purchaseUpdate(PurchaseRequest $request)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::find($request->id);
            $transaction->transaction_date = Carbon::now()->format('Y-m-d');
            $transaction->additional_notes = $request->tran_description;
            $transaction->save();

            $purchase = Purchase::where('transaction_id',$request->id)->first();
            $purchase->created_by =  auth()->user()->id;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->daily_setup_id = $request->daily_setup_id;
            $purchase->gold_price = $request->gold_price;
            $purchase->gem_price = $request->gem_price;
            $purchase->fee = json_encode($request->fee);
            $purchase->fee_price = $request->fee_price;
            $purchase->fee_for_making = $request->fee_for_making;
            $purchase->discount_amount = $request->item_discount;
            $purchase->before_total = $request->before_total;
            $purchase->final_total = $request->final_total;
            $purchase->save();


            $item = Item::find($purchase->item_id);
            $item->name = $request->name;
            $item->product_id = $request->product_id;
            $item->created_by = auth()->user()->id;
            $item->gold_plus_gem_weight = json_encode($request->gold_plus_gem_weight);
            $item->gem_weight = json_encode($request->gem_weight);
            $item->fee = json_encode($request->fee);
            $item->fee_for_making = $request->fee_for_making;
            $item->item_description = $request->item_description;
            if ($file = $request->file('image')) {
                $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                $path = '/images/items/';
                $file->move(public_path($path), $image_name);
                $image_name_path = $path . $image_name;
                $item->image = $image_name_path;
            }
            $item->save();
            DB::commit();
            return redirect()->route('admin.purchases.index');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Fail to Create New Product Type');
        }
    }
}
