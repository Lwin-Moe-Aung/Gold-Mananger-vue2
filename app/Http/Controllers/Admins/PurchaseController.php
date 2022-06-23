<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Transaction;
use App\Models\Purchase;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class PurchaseController extends Controller
{
    public function index()
    {
        // $business_id = auth()->user()->business_id;
        // $items = Item::where('business_id', $business_id)
        //     ->with('user')
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);
        return Inertia::render('AdminPanel/PurchaseManagement/Purchases/Index');
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
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'product_id' => ['required'],
                'supplier_id' => ['required'],
                'gold_plus_gem_weight' => ['required'],
                'before_total' => ['required'],
                'final_total' => ['required'],
            ]);
            try {
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
                // dd("aaa");

                $transaction = Transaction::create([
                    'business_id' => auth()->user()->business_id,
                    'business_location_id' => auth()->user()->business_location_id,
                    'type' => "purchase",
                    'status' => "received",
                    'payment_status' => "paid",
                    'invoice_no' => $this->invoiceNumber(),
                    'transaction_date' => Carbon::now()->format('Y-m-d'),
                    'additional_notes' =>  $request->tran_description,
                    'created_by' =>  auth()->user()->id,
                ]);
                $purchase = Purchase::create([
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
                    'item_discount' => $request->item_discount,
                    'before_total' =>  $request->before_total,
                    'final_total' => $request->final_total,
                ]);
                return back();
            } catch (\Exception $e) {
                return back()->with('fail', 'Fail to Create New Product Type');
            }
        }
        return back()->with('fail', 'No permission');
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
}
