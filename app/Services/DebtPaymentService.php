<?php
namespace App\Services;

use App\Models\Transaction;
use App\Models\DebtPaymentFromCustomer;

class DebtPaymentService {

    public function debtPaymentTransactionDetail($id, $type){

        $q = Transaction::where('id', $id);
        if($type == 'debt_payment_from_customers'){
            $transaction = $q->with(['contact', 'debtPaymentFromCustomer.transaction'])
                            ->first();
            foreach ($transaction->debtPaymentFromCustomer as $key=>$value){
                $transaction->debtPaymentFromCustomer[$key]->item = $value->transaction->sell->item;
            }
        }else{
            $transaction = $q->with(['contact', 'debtPaymentToSupplier.transaction'])
                            ->first();
            foreach ($transaction->debtPaymentToSupplier as $key=>$value){
                $transaction->debtPaymentToSupplier[$key]->item = $value->transaction->purchase->item;
            }
        }

        return $transaction;
    }

}
