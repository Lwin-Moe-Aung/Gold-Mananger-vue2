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
     *  return cash out data by date.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashOutData($date)
    {
        $total_purchase_amount = ViewPurchaseData::whereDate('created_at', '=', $date)
                ->sum('final_total');
        $total_expense_amount = ViewCashOutData::whereDate('created_at', '=', $date)
                ->where('type', 'expense')
                ->sum('amount');
        $total_debt_payment_to_supplier = ViewCashOutData::whereDate('created_at', '=', $date)
                ->where('type', 'debt_payment_to_supplier')
                ->sum('amount');
        return [
            "total_purchase_amount" => $total_purchase_amount,
            "total_expense_amount" => $total_expense_amount,
            "total_debt_payment_to_supplier" => $total_debt_payment_to_supplier,
            "total_cash_out_amount" =>  (int) $total_purchase_amount +  (int) $total_expense_amount +  (int) $total_debt_payment_to_supplier
        ];
    }

    /**
     *  return cash in data by date.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCashInData($date)
    {
        $opening_balance = OpenCloseDay::select('opening_balance')
                ->whereDate('created_at', '=', $date)
                ->first();
        $opening_balance = $opening_balance != null ? $opening_balance->opening_balance : 0;
        $total_sell_amount = ViewSellData::whereDate('created_at', '=', $date)
                ->sum('final_total');
        $total_debt_from_customer = ViewCashInData::whereDate('created_at', '=', $date)
                ->where('type', 'debt_payment_from_customer')
                ->sum('amount');
        return [
            "opening_balance" => $opening_balance,
            "total_sell_amount" => $total_sell_amount,
            "total_debt_from_customer" => $total_debt_from_customer,
            "total_cash_in_amount" =>  (int) $opening_balance +  (int) $total_sell_amount +  (int) $total_debt_from_customer
        ];
    }
}
