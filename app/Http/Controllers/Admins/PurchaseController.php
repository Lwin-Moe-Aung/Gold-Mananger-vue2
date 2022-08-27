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
use App\Models\ViewPurchaseData;
use App\Models\DebtPaymentToSupplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Facade\FlareClient\Http\Response;
use App\Http\Requests\Admins\PurchaseRequest;
use App\Http\Resources\ContactSearchResource;
use App\Http\Resources\PurchaseSellResource;
use App\Services\GenerateInvoiceService;

class PurchaseController extends Controller
{
    /**
     * GenerateInvoice service
     *
     * @var GenerateInvoiceService
     */
    protected $generateInvoiceService;

    /**
     * Create a new controller instance for dependency injection
     *
     * @param  GenerateInvoiceService  $generateInvoiceService
     * @return void
     */
    public function __construct(GenerateInvoiceService  $generateInvoiceService)
    {
        $this->generateInvoiceService = $generateInvoiceService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('AdminPanel/PurchaseManagement/Purchases/Index');
    }

     /**
     * Getting purchase transaction data for showing table.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchaseDataLists()
    {
        $paginate = request('paginate');
        if (isset($paginate)) {
            $view_purchase_data = ViewPurchaseData::ViewPurchaseDataQuery()->paginate($paginate);
        } else {
            $view_purchase_data = ViewPurchaseData::ViewPurchaseDataQuery()->get();
        }
        return PurchaseSellResource::collection($view_purchase_data);
    }
    /**
     * getting supplier for purchase .
     *
     * @return \Illuminate\Http\Response
     */
    public function getSupplierLists()
    {
        $dataList = Contact::searchQuery()->paginate(15);
        return ContactSearchResource::collection($dataList);
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
                $image_name_path = '/images/items/item_default.jfif';
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
                'invoice_no' => $this->generateInvoiceService->invoiceNumber(),
                'transaction_date' => Carbon::now()->format('Y-m-d'),
                'additional_notes' =>  $request->tran_description,
                'created_by' =>  auth()->user()->id,
                'before_total' =>  $request->before_total,
                'final_total' => $request->final_total,
                'paid_money' => $request->paid_money,
                'credit_money' => $request->credit_money,
                'discount_amount' => $request->discount_amount,
            ]);
            Purchase::create([
                'transaction_id' => $transaction->id,
                'item_id' => $item->id,
                'created_by' => auth()->user()->id,
                'supplier_id' => $request->supplier_id,
                'daily_setup_id' => $request->daily_setup_id,
                'gold_plus_gem_weight' =>  json_encode($request->gold_plus_gem_weight),
                'gold_price' => $request->gold_price,
                'gem_weight' =>  json_encode($request->gem_weight),
                'gem_price' => $request->gem_price,
                'fee' =>  json_encode($request->fee),
                'fee_price' =>  $request->fee_price,
                'fee_for_making' =>  $request->fee_for_making,
                'before_total' =>  $request->before_total,
                'final_total' => $request->final_total,
                'paid_money' => $request->paid_money,
                'credit_money' => $request->credit_money,
                'discount_amount' => $request->discount_amount,
            ]);
            DB::commit();
            return redirect()->route('admin.purchases.index');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Fail to Create New Product Type');
        }

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
            $transaction->contact_id = $request->supplier_id;
            $transaction->before_total = $request->before_total;
            $transaction->final_total = $request->final_total;
            $transaction->paid_money = $request->paid_money;
            $transaction->credit_money = $request->credit_money;
            $transaction->discount_amount = $request->discount_amount;
            $transaction->transaction_date = Carbon::now()->format('Y-m-d');
            $transaction->additional_notes = $request->tran_description;
            $transaction->save();

            $purchase = Purchase::where('transaction_id',$request->id)->first();
            $purchase->created_by =  auth()->user()->id;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->daily_setup_id = $request->daily_setup_id;
            $purchase->gold_plus_gem_weight = json_encode($request->gold_plus_gem_weight);
            $purchase->gold_price = $request->gold_price;
            $purchase->gem_weight = json_encode($request->gem_weight);
            $purchase->gem_price = $request->gem_price;
            $purchase->fee = json_encode($request->fee);
            $purchase->fee_price = $request->fee_price;
            $purchase->fee_for_making = $request->fee_for_making;
            $purchase->discount_amount = $request->discount_amount;
            $purchase->before_total = $request->before_total;
            $purchase->final_total = $request->final_total;
            $purchase->paid_money = $request->paid_money;
            $purchase->credit_money = $request->credit_money;
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

    public function deleteRecord($id)
    {
        try{
            $transaction = Transaction::find($id);
            $transaction->delete();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false]);
        }
    }


    /**
     * Display the specified resource of purchase detail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Inertia::render('AdminPanel/PurchaseManagement/Purchases/Detail', [
            'transaction' => $this->generateInvoiceService->gererateInvoice($id, 'purchase'),
            'debt_payment_to_supplier' => DebtPaymentToSupplier::with('transactionT')->where('parent_id',$id)->get(),
        ]);
    }

    /**
     * Generating Invoice for purchase by transaction id.
     *
     * @param  int  $transaction_id
     * @return \Illuminate\Http\Response
     */
    public function purchaseInvoice($transaction_id)
    {
        return Inertia::render('AdminPanel/PurchaseManagement/Purchases/Invoice', [
            'transaction' => $this->generateInvoiceService->gererateInvoice($transaction_id, 'purchase')
        ]);
    }
}
