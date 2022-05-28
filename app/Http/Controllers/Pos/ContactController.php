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
    public function customerSearch()
    {
        $customerList =  Contact::where('business_id', Auth::user()->business_id)
            ->where('type', 'customer')
            ->get();
        return response()->json(['customerList'=>$customerList]);
    }
}
