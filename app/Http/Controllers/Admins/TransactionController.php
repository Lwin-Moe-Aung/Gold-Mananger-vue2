<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function invoiceNoSearch(Request $request){

        $transactions =  Transaction::where('type', 'sell')
                    ->where('business_id',auth()->user()->business_id)
                    ->where('business_location_id',auth()->user()->business_location_id)
                    ->when(request()->get('params')['term'], function ($query, $term) {
                        $query->where('invoice_no', 'like', "%$term%");
                    })->limit(3)->get();

        return response()->json(['data' => $transactions]);
    }

    public function searchByInvoiceNo($invoice_no) {

        $transaction =  Transaction::where('invoice_no', $invoice_no)->first();
        $sell = $transaction->sell;
        $data = [
            'item' => $sell->item,
            'sell' => $sell,
            'transaction' => $transaction,
            'product' => $sell->item->product,
            'created_by' => $sell->user,
            'customer' => $sell->contact,
            'daily_setup' => $sell->dailysetup,
        ];
        return response()->json(['data' => $data]);
    }
}
