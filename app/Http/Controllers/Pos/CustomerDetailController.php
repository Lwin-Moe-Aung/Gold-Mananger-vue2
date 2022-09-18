<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailySetup;
use App\Models\Contact;
use App\Models\Transaction;
use App\Models\ViewSellData;

use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
use DB;
use App\Services\CreditInfoService;
use App\Http\Resources\CustomerDataWhoHaveCreditResource;

class CustomerDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('PosPanel/Pos/CustomerDetail/Index');
    }

    /**
     * get customer list who have credits
     */
    public function getCustomersDataWhoHaveCredit()
    {
        $transactions = (new CreditInfoService())->getDataWhoHaveCredit(request('type'), request('selectedContact'), request('paginate'));
        return CustomerDataWhoHaveCreditResource::collection($transactions);
    }

    /**
     *  show customer detail for pos page
     */
    public function detail()
    {
        $customer_id = request('customer_id');
        $customerInfo = Contact::find($customer_id);

        $sellTransactions = ViewSellData::where('contact_id', $customer_id)
                            ->with('sell.item.product')
                            ->orderBy('created_at', 'desc')
                            ->get();

        $debtPaymentHistories = Transaction::where('type' , 'debt_payment_from_customer')
                            ->where('contact_id', $customer_id)
                            ->with(['contact', 'debtPaymentFromCustomer.transaction.sell.item'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return response()->json([
                'customerInfo' => $customerInfo,
                'sellTransactions' => $sellTransactions,
                'debtPaymentHistories' => $debtPaymentHistories
            ]);

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
