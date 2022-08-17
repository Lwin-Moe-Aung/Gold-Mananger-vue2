<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\ViewCashInData;
use App\Http\Resources\ViewCashInDataResource;

class CashInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOld()
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
        return Inertia::render('AdminPanel/CashManagement/CashIn/Index', [
            'transactions' => $transactions,
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    /**
     * Show the data from view_cashin_data table.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('AdminPanel/CashManagement/CashIn/Index');
    }

    /**
     * Get data for showing in cashin Index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashInDataLists()
    {
        $paginate = request('paginate');

        if (isset($paginate)) {
            $view_cash_in_data = ViewCashInData::ViewCashInDataQuery()->paginate($paginate);
        } else {
            $view_cash_in_data = ViewCashInData::ViewCashInDataQuery()->get();
        }
        return ViewCashInDataResource::collection($view_cash_in_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
