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
                    ->where('type','purchase')
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
            'transactions' => null,
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
        //
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
