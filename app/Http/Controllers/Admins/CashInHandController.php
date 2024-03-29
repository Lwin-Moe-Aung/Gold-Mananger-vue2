<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpenCloseDay;
use App\Models\ViewSellData;
use App\Models\ViewCashInData;
use App\Models\ViewPurchaseData;
use App\Models\ViewCashOutData;
use App\Models\Item;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Services\StockService;

class CashInHandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('AdminPanel/SetupManagement/CashInHand/Index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashInHandByDate()
    {
        return response()->json([
            'cash_in_data' => $this->getCashInData(request('date')),
            'cash_out_data' => $this->getCashOutData(request('date')),
            'stock_in_hand' => (new StockService())->getStockInHandData(),
        ]);
    }

    /**
     * Get cash In hand data for Close Day.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashInHandForCloseDay()
    {
        $open_close_day = OpenCloseDay::latest()->first();
        // dd($open_close_day);
        if($open_close_day != null && $open_close_day->closed == 0){
            $date = $open_close_day->opening_date_time;
            return response()->json([
                'cash_in_data' => $this->getCashInData($date),
                'cash_out_data' => $this->getCashOutData($date),
                'stock_in_hand' => (new StockService())->getStockInHandData(),
            ]);
        }

        return response()->json([
            'cash_in_data' => null,
            'cash_out_data' => null,
            'stock_in_hand' => null,
        ]);
    }

     /**
     *  return cash out data by date.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashOutData($date)
    {
        $purchases = ViewPurchaseData::whereDate('created_at', '=', $date)
                ->get();
        $total_purchase_amount = $purchases->sum(function ($option) {
                    return $option->final_total;
                });

        $expenses = ViewCashOutData::whereDate('created_at', '=', $date)
                ->where('type', 'expense')
                ->get();

        $total_expense_amount = $expenses->sum(function ($option) {
                    return $option->amount;
                });

        $debt_payment_to_suppliers = ViewCashOutData::whereDate('created_at', '=', $date)
                ->where('type', 'debt_payment_to_supplier')
                ->get();

        $total_debt_payment_to_suppliers = $debt_payment_to_suppliers->sum(function ($option) {
                    return $option->amount;
                });

        return [
            "purchases" =>
                [
                    "total_purchase_amount" => $total_purchase_amount,
                    "count" => $purchases->count(),
                    "purchases" => $purchases,
                ],
            "expenses" =>
                [
                    "total_expense_amount" => $total_expense_amount,
                    "count" => $expenses->count(),
                    "expenses" => $expenses,
                ],
            "debt_payment_to_suppliers" =>
                [
                    "total_debt_payment_to_suppliers" => $total_debt_payment_to_suppliers,
                    "count" => $debt_payment_to_suppliers->count(),
                    "debt_payment_to_suppliers" => $debt_payment_to_suppliers,
                ],
            "total_cash_out_amount" =>  (int) $total_purchase_amount +  (int) $total_expense_amount +  (int) $total_debt_payment_to_suppliers
        ];
    }

    /**
     *  return cash in data by date.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashInData($date)
    {
        $open_close_day = OpenCloseDay::where('created_at', '=', $date)
                ->first();
                // dd($open_close_day);
        $opening_balance = $open_close_day != null ? $open_close_day->opening_balance : 0;

        $sells = ViewSellData::where('created_at', '=', $date)
                ->get();

        $total_sell_amount = $sells->sum(function ($option) {
                        return $option->final_total;
                    });

        $debt_from_customers = ViewCashInData::where('created_at', '=', $date)
                ->where('type', 'debt_payment_from_customer')
                ->get();
        $total_debt_from_customers = $debt_from_customers->sum(function ($option) {
                    return $option->amount;
                });
        return [
            "open_close_day_id" => $open_close_day != null ? $open_close_day->id : null,
            "opening_balance" => $opening_balance,
            "sells" =>
                [
                    "total_sell_amount" => $total_sell_amount,
                    "count" => $sells->count(),
                    "sells" => $sells
                ],
            "debt_from_customers" =>
                [
                    "total_debt_from_customers" =>  $total_debt_from_customers,
                    "count" => $debt_from_customers->count(),
                    "debt_from_customers" => $debt_from_customers
                ],
            "total_cash_in_amount" =>  (int) $opening_balance +  (int) $total_sell_amount +  (int) $total_debt_from_customers
        ];
    }
}
