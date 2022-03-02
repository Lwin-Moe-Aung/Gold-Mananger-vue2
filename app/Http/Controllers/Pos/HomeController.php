<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Product;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('PosPanel/Pos/Home');
    }
    public function search($id)
    {
        $items = Item::where('product_id', $id)
            ->get()
            ->toArray();
        return response()->json($items, 200);
    }
    public function productList()
    {
        $business_id = Auth::user()->business_id;
        $products = Product::select('id', 'name', 'product_sku', 'image')
            ->where('business_id', $business_id)
            ->get()
            ->toArray();
        return response()->json($products, 200);
    }
}
