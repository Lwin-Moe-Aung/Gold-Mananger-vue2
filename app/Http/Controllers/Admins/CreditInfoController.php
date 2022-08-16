<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\Contact;
use App\Models\DebtPaymentToSupplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Services\ContactService;
use App\Services\CreditInfoService;
use App\Http\Resources\CustomerDataWhoHaveCreditResource;

class CreditInfoController extends Controller
{
    /**
     * Display customers who have credit to pay to admin
     *
     * @return \Illuminate\Http\Response
     */
    public function creditInfoCustomers()
    {
        return Inertia::render('AdminPanel/CashManagement/DebtToGet/Index');
    }

    /**
     * Display supplier who have to get debt from admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function creditInfoSuppliers()
    {
        return Inertia::render('AdminPanel/CashManagement/DebtToPay/Index');
    }

    /**
     * Getting Customer data who have credit to pay to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomersDataWhoHaveCredit()
    {
        $transactions = (new CreditInfoService())->getDataWhoHaveCredit(request('type'), request('selectedContact'), request('paginate'));
        return CustomerDataWhoHaveCreditResource::collection($transactions);
    }

    /**
     * Get customer list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRemainCreditCustomerLists()
    {
        $customers = (new ContactService())->getCustomerLists(request('type'), $credit_contact = true);

        return response()->json(['data' => $customers]);
    }

    /**
     * Get supplier list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRemainCreditToSupplierLists()
    {
        $suppliers = (new ContactService())->getCustomerLists(request('type'), $credit_contact = true);

        return response()->json(['data' => $suppliers]);
    }

    /**
     * Getting Supplier data who have credit to get from admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSuppliersDataWhoHaveCredit()
    {
        $transactions = (new CreditInfoService())->getDataWhoHaveCredit(request('type'), request('selectedContact'), request('paginate'));
        return CustomerDataWhoHaveCreditResource::collection($transactions);
    }
    /**
     * Debt payment from customer with contact_id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createDebtPaymentFromCustomerWithContactId()
    {
        $customer = Contact::find(request('contact_id'));
        $customer->search_name = $customer->name.'( email -'.$customer->email.') (ph-'.$customer->mobile1.','.$customer->mobile2.') (address- '.$customer->address.' )';
        return Inertia::render('AdminPanel/CashManagement/DebtPaymentFromCustomer/Create',[
            'contact' => $customer
        ]);
    }
    /**
     * Debt payment to supplier with contact_id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createDebtPaymentToSupplierWithContactId()
    {
        $supplier = Contact::find(request('contact_id'));
        $supplier->search_name = $supplier->name.'( email -'.$supplier->email.') (ph-'.$supplier->mobile1.','.$supplier->mobile2.') (address- '.$supplier->address.' )';
        return Inertia::render('AdminPanel/CashManagement/DebtPaymentToSupplier/Create',[
            'contact' => $supplier
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
