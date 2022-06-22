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

    public function store(Request $request)
    {
        dd($request->all());

        // if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
        //     $this->validate($request, [
        //         'name' => ['required', 'max:50'],
        //         'quality' => ['required'],
        //         'type' => ['required'],
        //         'item_name' => ['required'],
        //     ]);
        //     // return $request;
        //     try {
        //         if ($file = $request->file('image')) {
        //             $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
        //             $path = '/images/products/';
        //             $file->move(public_path($path), $image_name);
        //             $image_name_path = $path . $image_name;
        //         } else {
        //             $image_name_path = null;
        //         }
        //         $product_sku = $request->quality["quality"] . $request->type["key"] . $request->item_name["key"];
        //         Product::create([
        //             'name' => $request->name,
        //             'quality' => $request->quality["quality"],
        //             'type_id' => $request->type["id"],
        //             'item_names_id' => $request->item_name["id"],
        //             'product_sku' => $product_sku,
        //             'description' => $request->description,
        //             'alert_quantity' => $request->alert_quantity,
        //             'image' => $image_name_path,
        //             'business_id' => auth()->user()->business_id,
        //             'created_by' => auth()->user()->id,
        //             'gem_weight' => $request->gem_weight ? '1' : '0',

        //         ]);
        //         return back();
        //     } catch (\Exception $e) {
        //         return back()->with('fail', 'Fail to Create New Product Type');
        //     }
        // }
        // return back()->with('fail', 'No permission');
    }
}
