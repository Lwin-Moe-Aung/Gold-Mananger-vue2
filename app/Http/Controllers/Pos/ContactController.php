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
}
