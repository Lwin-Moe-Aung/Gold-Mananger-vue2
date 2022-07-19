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
    // public function customerSearch(Request $request)
    // {
    //     $search_value = $request->term;
    //     $dataList =  Contact::where('business_id', Auth::user()->business_id)
    //         ->where('type', 'customer')
    //         ->orWhere('type', 'both')
    //         ->where(function($q) use ($search_value) {
    //             $q->where('name','like','%'.$search_value.'%')
    //                 ->orWhere('email','like','%'.$search_value.'%')
    //                 ->orWhere('mobile1','like','%'.$search_value.'%')
    //                 ->orWhere('mobile2','like','%'.$search_value.'%')
    //                 ->orWhere('address','like','%'.$search_value.'%');
    //             })
    //         ->limit(15)
    //         ->get()
    //         ->toArray();
    //     // if(empty($dataList))
    //     foreach($dataList as $key=>$value) {
    //         $dataList[$key]["search_name"] = $value['name'].'( email -'.$value['email'].') (ph-'.$value['mobile1'].','.$value['mobile2'].') (address- '.$value['address'].' )';
    //     }
    //     return response()->json(['data'=>$dataList]);
    // }

    public function contactSearch(Request $request)
    {

        $dataList =  Contact::where('business_id', Auth::user()->business_id)
            ->where('type', $request->type)
            ->orWhere('type', 'both')
            ->when($request->term, function ($query, $search_value) {
                $query->orWhere('name','like','%'.$search_value.'%')
                    ->orWhere('email','like','%'.$search_value.'%')
                    ->orWhere('mobile1','like','%'.$search_value.'%')
                    ->orWhere('mobile2','like','%'.$search_value.'%')
                    ->orWhere('address','like','%'.$search_value.'%');
            })
            ->limit(15)
            ->get()
            ->toArray();
        // $search_value = $request->term;
        // $dataList =  Contact::where('business_id', Auth::user()->business_id)
        //     ->where('type', $request->type)
        //     ->orWhere('type', 'both')
        //     ->where(function($q) use ($search_value) {
        //         $q->where('name','like','%'.$search_value.'%')
        //             ->orWhere('email','like','%'.$search_value.'%')
        //             ->orWhere('mobile1','like','%'.$search_value.'%')
        //             ->orWhere('mobile2','like','%'.$search_value.'%')
        //             ->orWhere('address','like','%'.$search_value.'%');
        //         })
        //     ->limit(15)
        //     ->get()
        //     ->toArray();
        // if(empty($dataList))
        foreach($dataList as $key=>$value) {
            $dataList[$key]["search_name"] = $value['name'].'( email -'.$value['email'].') (ph-'.$value['mobile1'].','.$value['mobile2'].') (address- '.$value['address'].' )';
        }
        return response()->json(['data'=>$dataList]);
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

    public function saveContact(Request $request){

        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'name' => ['required'],
                'address' => ['required'],
                'mobile1' => ['required'],
            ]);
            try {
                $customer = Contact::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => $request->type,
                    'mobile1' => $request->mobile1,
                    'mobile2' => $request->mobile2,
                    'address' => $request->address,
                    'supplier_business_name' => $request->type == 'supplier' ? $request->supplier_business_name : null,
                    'created_by' => Auth::user()->id,
                    'business_id' => Auth::user()->business_id,
                    'business_location_id' => Auth::user()->business_location_id,
                ]);
                $customer->search_name = $customer->name.'( email -'.$customer->email.') (ph-'.$customer->mobile1.','.$customer->mobile2.') (address- '.$customer->address.' )';
                return response()->json(['data'=>$customer, 'status'=>true]);
            } catch (\Exception $e) {
                return response()->json(['data'=>[], 'status'=>false]);
            }
        }
        return back()->with('fail', 'No permission');
    }
}
