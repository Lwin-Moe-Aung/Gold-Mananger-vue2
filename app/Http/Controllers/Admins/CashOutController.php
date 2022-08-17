<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\ViewCashOutData;
use App\Http\Resources\ViewCashOutDataResource;


class CashOutController extends Controller
{

    /**
     * Show the data from view_cashout_data table.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('AdminPanel/CashManagement/CashOut/Index');
    }

    /**
     * Get data for showing in cashout Index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashOutDataLists()
    {
        $paginate = request('paginate');

        if (isset($paginate)) {
            $view_cash_out_data = ViewCashOutData::ViewCashOutDataQuery()->paginate($paginate);
        } else {
            $view_cash_out_data = ViewCashOutData::ViewCashOutDataQuery()->get();
        }
        return ViewCashOutDataResource::collection($view_cash_out_data);
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
