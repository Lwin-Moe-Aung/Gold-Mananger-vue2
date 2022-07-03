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
        $item = $sell->item;
        $item->gold_plus_gem_weight = json_decode($item->gold_plus_gem_weight);
        $item->gem_weight = json_decode($item->gem_weight);
        $item->fee = json_decode($item->fee);

        $customer = $sell->contact;
        $customer->search_name = $customer->name.'( email -'.$customer->email.') (ph-'.$customer->mobile1.','.$customer->mobile2.') (address- '.$customer->address.' )';

        $data = [
            'item' => $item,
            'sell' => $sell,
            'transaction' => $transaction,
            'product' => $sell->item->product,
            'created_by' => $sell->user,
            'customer' => $customer,
            'daily_setup' => $sell->dailysetup,
        ];
        return response()->json(['data' => $data]);
    }
}
