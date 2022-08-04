<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;

class DebtPaymentFromCustomerController extends Controller
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
        $transactions->where('business_id', $business_id)->where('type','sell');

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
            $transactions[$key]->sell = $value->sell;
            $transactions[$key]->item = $value->sell->item;
            $transactions[$key]->product = $value->sell->item->product;
        }
        return Inertia::render('AdminPanel/CashManagement/DebtPaymentFromCustomer/Index', [
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

        // $transactions = Transaction::where('business_id', auth()->user()->business_id)
        //             ->where('type','sell')
        //             ->where('credit_money','!=', 0)
        //             ->get();
        return Inertia::render('AdminPanel/CashManagement/DebtPaymentFromCustomer/Create');
    }

    /**
     * get total credit value for customer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCreditDataLists(Request $request)
    {
        $transactions = Transaction::where('business_id', auth()->user()->business_id)
                    ->where('contact_id',$request->customer_id)
                    ->where('type','sell')
                    ->where('credit_money','!=', 0)
                    ->get();
        $total_credits = 0;
        foreach ($transactions as $key=>$value) {
            $total_credits = $total_credits + $value->credit_money;
            $transactions[$key]->item = $value->sell->item;
        }
        return response()->json([
            'data' => $transactions,
            'total_credits' => $total_credits,
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
