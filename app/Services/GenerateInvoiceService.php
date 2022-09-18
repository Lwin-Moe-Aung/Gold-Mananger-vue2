<?php
namespace App\Services;

use App\Models\Transaction;
use App\Models\DebtPaymentFromCustomer;
use App\Models\Contact;
use DB;
use Illuminate\Support\Facades\Auth;

class GenerateInvoiceService {

    /**
     * Generate Invoice number for all service.
    */
    public function invoiceNumber($type)
    {
        $transactionLatest = Transaction::where('business_id',Auth::user()->business_id)
                            ->where('type',$type)
                            ->latest()
                            ->first();
        $title = '';
        if($type ==  'sell'){
            $title = 'arm';
        }
        elseif($type == 'purchase'){
            $title = 'pur';
        }
        elseif($type == 'purchase_return'){
            $title = 'pur';
        }
        elseif($type == 'debt_payment_from_customer'){
            $title = 'debtc';
        }
        elseif($type == 'debt_payment_to_supplier'){
            $title = 'debts';
        }
        if (! $transactionLatest) {
            return $title.'00001';
        }
        $string = preg_replace("/[^0-9\.]/", '', $transactionLatest->invoice_no);
        return $title . sprintf('%04d', $string+1);
    }

    /**
     * getting data for printing invoice
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function gererateInvoice($transaction_id, $type)
    {
        $query = Transaction::with(['business','businessLocation','contact','debtPaymentToSupplier']);

        if($type == 'purchase' || $type == 'purchase_return'){
            $query->with('purchase.item.product');
        }else if($type == 'sell'){
            $query->with('sell.item.product');
        }
        $transaction = $query->where('id',$transaction_id)
                            ->first();

        // if($type == 'purchase' || $type == 'purchase_return'){
        //     $transaction->purchase->item->gold_plus_gem_weight = json_decode($transaction->purchase->item->gold_plus_gem_weight);
        //     $transaction->purchase->item->gem_weight = json_decode($transaction->purchase->item->gem_weight);
        //     $transaction->purchase->item->fee = json_decode($transaction->purchase->item->fee);
        // }else if($type == 'sell'){
        //     $transaction->sell->item->gold_plus_gem_weight = json_decode($transaction->sell->item->gold_plus_gem_weight);
        //     $transaction->sell->item->gem_weight = json_decode($transaction->sell->item->gem_weight);
        //     $transaction->sell->item->fee = json_decode($transaction->sell->item->fee);
        // }

        return $transaction;

    }
}
