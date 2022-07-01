<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function invoiceNoSearch(Request $request){

        $transactions =  Transaction::where('type', 'purchase')
                    ->where('business_id',auth()->user()->business_id)
                    ->where('business_location_id',auth()->user()->business_location_id)
                    ->when(request()->get('params')['term'], function ($query, $term) {
                        $query->where('invoice_no', 'like', "%$term%");
                    })->limit(3)->get();

        return response()->json(['data' => $transactions]);
    }
}
