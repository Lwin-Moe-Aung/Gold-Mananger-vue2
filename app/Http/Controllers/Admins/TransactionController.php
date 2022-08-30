<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Sell;

use App\Models\LimitationPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
     /**
     * getting invoice number for dropdown list in purchase return
     */
    public function invoiceNoSearch(Request $request){
        $transactions =  Transaction::where('type', 'sell')
                    ->where('business_id',auth()->user()->business_id)
                    ->where('business_location_id',auth()->user()->business_location_id)
                    ->whereNull('purchase_return')
                    ->when($request->term, function ($query, $term) {
                        $query->where('invoice_no', 'like', "%$term%");
                    })->limit(10)->get();

        return response()->json(['data' => $transactions]);
    }

    /**
     * searching transaction data by invoice no
    */
    public function searchByInvoiceNo($invoice_no) {

        $transaction =  Transaction::with(['sell.item.product', 'contact', 'user'])
                    ->where('invoice_no', $invoice_no)
                    ->first();

        $transaction->sell->item->gold_plus_gem_weight = json_decode($transaction->sell->item->gold_plus_gem_weight);
        $transaction->sell->item->gem_weight = json_decode($transaction->sell->item->gem_weight);
        $transaction->sell->item->fee = json_decode($transaction->sell->item->fee);

        $transaction->contact->search_name = $transaction->contact->name.'( email -'.$transaction->contact->email.') (ph-'.$transaction->contact->mobile1.','.$transaction->contact->mobile2.') (address- '.$transaction->contact->address.' )';

        $product = $transaction->sell->item->product;
        //setting daily setup
        $limitation_price = LimitationPrice::where('customize','0')
                        ->where('business_id', Auth::user()->business_id)
                        ->orderBy('created_at', 'DESC')
                        ->first();
        $daily_setup = $transaction->sell->dailysetup;
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
            'item' =>  $transaction->sell->item,
            'sell' =>  $transaction->sell,
            'transaction' => $transaction,
            'product' => $product,
            'created_by' => $transaction->user,
            'customer' => $transaction->contact,
            'daily_setup' => $daily_setup_data,
        ];
        return response()->json(['data' => $data]);
    }
}
