<?php
namespace App\Services;

use App\Models\Transaction;
use App\Models\DebtPaymentFromCustomer;
use App\Models\Contact;
use DB;

class CreditInfoService {

    public function getDataWhoHaveCredit($type, $selectedContact,$paginate ){

        $transactions =  DB::table('transactions')
            ->join('contacts', 'transactions.contact_id','=', 'contacts.id' )
            ->select('contacts.id as contact_id',
                'contacts.name','contacts.mobile1','contacts.mobile2',
                'contacts.address',DB::raw("SUM(credit_money) as total_credit_money"))
            ->when($selectedContact, function ($query) use ($selectedContact) {
                $query->where('contact_id', $selectedContact);
            })
            ->where('transactions.type',$type)
            ->where('transactions.credit_money', '!=', 0)
            ->groupBy('contact_id')
            ->paginate($paginate);

        return $transactions;
    }

}
