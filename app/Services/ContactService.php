<?php
namespace App\Services;

use App\Models\Transaction;
use App\Models\DebtPaymentFromCustomer;
use App\Models\Contact;

class ContactService {

    public function getCustomerLists($type, $credit_contact = false){

        $customers = Contact::whereIn('id', function($query) use($type, $credit_contact){
            $query->select('contact_id')
                ->from('transactions')
                ->where('type', $type)
                ->when($credit_contact, function ($query) use ( $credit_contact) {
                    $query->where('credit_money', '!=',0);
                })
                ->groupBy('contact_id')
                ->pluck('contact_id');
            })->get();

        return $customers;
    }

}
