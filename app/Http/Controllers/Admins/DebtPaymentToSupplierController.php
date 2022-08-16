<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\DebtPaymentToSupplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\DebtPaymentService;
use DB;

class DebtPaymentToSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('AdminPanel/CashManagement/DebtPaymentToSupplier/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('AdminPanel/CashManagement/DebtPaymentToSupplier/Create',[
            'contact' => null
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
                'type' => "debt_payment_to_supplier",
                'status' => "received",
                'payment_status' => "paid",
                'contact_id' => $request->supplier_id,
                'transaction_date' => Carbon::now()->format('Y-m-d'),
                'additional_notes' =>  $request->additional_note != "" ? $request->additional_note : null,
                'created_by' =>  auth()->user()->id,
                'debt_paid_money' => $request->total_payment,
                'remaining_credit_money' => $request->remaining_credit_money,
            ]);
            foreach (json_decode($request->checked_voucher_lists) as $data){
                $trans = Transaction::find($data->parent_transaction_id);
                $trans->paid_money = (int)$trans->paid_money + (int)$data->debt_payment_amount;
                $trans->credit_money = (int)$trans->credit_money - (int)$data->debt_payment_amount;
                $trans->save();

                DebtPaymentToSupplier::create([
                    'transaction_id' => $transaction->id,
                    'parent_id' => $data->parent_transaction_id,
                    'supplier_id' => $request->supplier_id,
                    'old_paid_money' => $data->old_paid_money,
                    'old_credit_money' => $data->old_credit_money,
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
        $transaction = (new DebtPaymentService())->debtPaymentTransactionDetail($id, 'debt_payment_to_suppliers');
        return Inertia::render('AdminPanel/CashManagement/DebtPaymentToSupplier/Detail',[
            'transaction' => $transaction
        ]);
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


    /**
     * get total credit value for customer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSupplierCreditDataLists(Request $request)
    {
        $transactions = Transaction::where('business_id', auth()->user()->business_id)
                    ->where('contact_id',$request->contact_id)
                    ->where('type','purchase')
                    ->where('credit_money','!=', 0)
                    ->get();
        $total_credits = 0;
        foreach ($transactions as $key=>$value) {
            $total_credits = $total_credits + $value->credit_money;
            $transactions[$key]->item = $value->purchase->item;
        }
        return response()->json([
            'data' => $transactions,
            'total_credits' => $total_credits,
        ]);
    }
}
