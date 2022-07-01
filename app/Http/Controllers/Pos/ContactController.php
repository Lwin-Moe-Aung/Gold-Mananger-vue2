<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use DB;

class ContactController extends Controller
{
    public function customerSearch(Request $request)
    {
        $search_value = $request->search_value;
        $customerList =  Contact::where('business_id', Auth::user()->business_id)
            ->where('type', 'customer')
            ->orWhere('type', 'both')
            ->where(function($q) use ($search_value) {
                $q->where('name','like','%'.$search_value.'%')
                    ->orWhere('email','like','%'.$search_value.'%')
                    ->orWhere('mobile1','like','%'.$search_value.'%')
                    ->orWhere('mobile2','like','%'.$search_value.'%')
                    ->orWhere('address','like','%'.$search_value.'%');
                })
            ->limit(15)
            ->get()
            ->toArray();
        // if(empty($customerList))
        foreach($customerList as $key=>$value) {
            $customerList[$key]["search_name"] = $value['name'].'( email -'.$value['email'].') (ph-'.$value['mobile1'].','.$value['mobile2'].') (address- '.$value['address'].' )';
        }
        return response()->json(['data'=>$customerList]);
    }

    public function saveCustomer(Request $request) {
        try {
            $customer = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => 'customer',
                'mobile1' => $request->mobile1,
                'mobile2' => $request->mobile2,
                'address' => $request->address,
                'created_by' => Auth::user()->id,
                'business_id' => Auth::user()->business_id,
                'business_location_id' => Auth::user()->business_location_id,
            ]);
            return response()->json(['data'=>$customer, 'status'=>true]);
        } catch (\Exception $e) {
            return response()->json(['data'=>[], 'status'=>false]);
        }
    }
}
