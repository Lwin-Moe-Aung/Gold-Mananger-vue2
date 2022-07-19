<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\LimitationPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function invoiceNoSearch(Request $request){
        $transactions =  Transaction::where('type', 'sell')
                    ->where('business_id',auth()->user()->business_id)
                    ->where('business_location_id',auth()->user()->business_location_id)
                    ->when($request->term, function ($query, $term) {
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

        $product = $sell->item->product;
        //setting daily setup
        $limitation_price = LimitationPrice::where('customize','0')
                        ->where('business_id', Auth::user()->business_id)
                        ->orderBy('created_at', 'DESC')
                        ->first();
        $daily_setup = $sell->dailysetup;
        $kyat =  ($daily_setup->daily_price/16 * $product->quality) - $limitation_price->price;
        $pal = $kyat / 16;
        $yway = $pal / 8;
        $daily_setup_data  = [
            'daily_setup_id' => $daily_setup->id,
            'kyat' => $kyat,
            'pal' => $pal,
            'yway' => $yway,
        ];

        $data = [
            'item' => $item,
            'sell' => $sell,
            'transaction' => $transaction,
            'product' => $product,
            'created_by' => $sell->user,
            'customer' => $customer,
            'daily_setup' => $daily_setup_data,
        ];
        return response()->json(['data' => $data]);
    }
}
