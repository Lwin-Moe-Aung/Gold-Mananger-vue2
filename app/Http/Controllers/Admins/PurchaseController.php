<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use App\Models\Product;
use App\Models\Contact;

class PurchaseController extends Controller
{
    public function index()
    {
        // $business_id = auth()->user()->business_id;
        // $items = Item::where('business_id', $business_id)
        //     ->with('user')
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);
        return Inertia::render('AdminPanel/PurchaseManagement/Purchases/Index');
    }

    public function create()
    {
        $business_id = auth()->user()->business_id;
        $products = Product::where('business_id', $business_id)
            ->get();
        $suppliers = Contact::where('business_id', $business_id)
            ->where('type', 'supplier')
            ->get();
        return Inertia::render('AdminPanel/PurchaseManagement/Purchases/Create',[
            'products' => $products,
            'suppliers' => $suppliers,
        ]);
    }
}
