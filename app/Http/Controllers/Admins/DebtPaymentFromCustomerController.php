<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\DebtPaymentFromCustomer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Facade\FlareClient\Http\Response;
use App\Http\Resources\DebtPaymentListsResource;

class DebtPaymentFromCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('AdminPanel/CashManagement/DebtPaymentFromCustomer/Index');
    }

    /**
     * Geting debt payment from customer lists
     *
     * @return \Illuminate\Http\Response
     */
    public function getDebtPaymentLists()
    {
        $paginate = request('paginate');
        if (isset($paginate)) {
            $transactions = Transaction::transactionsQuery()->paginate($paginate);
        } else {
            $transactions = Transaction::transactionsQuery()->get();
        }
        return DebtPaymentListsResource::collection($transactions);
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
        try {
            DB::beginTransaction();
            $transaction = Transaction::create([
                'business_id' => auth()->user()->business_id,
                'business_location_id' => auth()->user()->business_location_id,
                'type' => "debt_payment_from_customer",
                'status' => "received",
                'payment_status' => "paid",
                'contact_id' => $request->customer_id,
                'transaction_date' => Carbon::now()->format('Y-m-d'),
                'additional_notes' =>  $request->additional_note,
                'created_by' =>  auth()->user()->id,
                'debt_paid_money' => $request->total_payment,
                'remaining_credit_money' => $request->remaining_credit_money,
            ]);
            foreach (json_decode($request->checked_voucher_lists) as $data){
                $trans = Transaction::find($data->parent_transaction_id);
                $trans->paid_money = (int)$trans->paid_money + (int)$data->debt_payment_amount;
                $trans->credit_money = (int)$trans->credit_money - (int)$data->debt_payment_amount;
                $trans->save();

                DebtPaymentFromCustomer::create([
                    'transaction_id' => $transaction->id,
                    'parent_id' => $data->parent_transaction_id,
                    'customer_id' => $request->customer_id,
                    'paid_money' => $data->old_paid_money,
                    'credit_money' => $data->old_credit_money,
                    'debt_payment' => $data->debt_payment_amount,
                ]);
            }
            DB::commit();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Fail to Create New Debt pyment from customer');
        }
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
