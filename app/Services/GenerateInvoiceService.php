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
}
