<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\GoldQuality;
use App\Models\ItemName;
use App\Models\Product;
use App\Models\Type;
use App\Models\WeightKyat;
use App\Models\WeightPal;
use App\Models\WeightYway;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = auth()->user()->business_id;
        $products = Product::where('business_id', $business_id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('AdminPanel/ProductManagement/Products/Index', [
            'products' => $products,
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $business_id = auth()->user()->business_id;
        $gold_qualities = GoldQuality::where('business_id', $business_id)->get();
        $types = Type::where('business_id', $business_id)->get();
        $item_names = ItemName::where('business_id', $business_id)->get();

        return Inertia::render('AdminPanel/ProductManagement/Products/Create', [
            'gold_qualities' => $gold_qualities,
            'types' => $types,
            'item_names' => $item_names,
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
        // dd($request->file('image'));

        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'quality' => ['required'],
                'type' => ['required'],
                'item_name' => ['required'],
            ]);
            // return $request;
            try {
                if ($file = $request->file('image')) {
                    $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                    $path = '/images/products/';
                    $file->move(public_path($path), $image_name);
                    $image_name_path = $path . $image_name;
                } else {
                    $image_name_path = null;
                }
                $product_sku = $request->quality["quality"] . $request->type["key"] . $request->item_name["key"];
                Product::create([
                    'name' => $request->name,
                    'quality' => $request->quality["quality"],
                    'type_id' => $request->type["id"],
                    'item_names_id' => $request->item_name["id"],
                    'product_sku' => $product_sku,
                    'description' => $request->description,
                    'alert_quantity' => $request->alert_quantity,
                    'image' => $image_name_path,
                    'business_id' => auth()->user()->business_id,
                    'created_by' => auth()->user()->id,
                    'gem_weight' => $request->gem_weight ? '1' : '0',

                ]);
                return back();
            } catch (\Exception $e) {
                return back()->with('fail', 'Fail to Create New Product Type');
            }
        }
        return back()->with('fail', 'No permission');
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
        $business_id = auth()->user()->business_id;
        $product = Product::find($id);
        $gold_qualities = GoldQuality::where('business_id', $business_id)->get();
        $types = Type::where('business_id', $business_id)->get();
        $item_names = ItemName::where('business_id', $business_id)->get();

        return Inertia::render('AdminPanel/ProductManagement/Products/Edit', [
            'product' => $product,
            'gold_qualities' => $gold_qualities,
            'types' => $types,
            'item_names' => $item_names,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ProductUpdate(Request $request)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:150'],
                'quality' => ['required'],
                'type' => ['required'],
                'item_name' => ['required'],
            ]);
            try {
                $product_sku = $request->quality["quality"] . $request->type["key"] . $request->item_name["key"];

                $product = Product::find($request->id);
                $product->name = $request->name;
                $product->quality = $request->quality["quality"];
                $product->type_id = $request->type["id"];
                $product->item_names_id = $request->item_name["id"];
                $product->product_sku = $product_sku;
                $product->description = $request->description;
                $product->alert_quantity = $request->alert_quantity;
                if ($file = $request->file('image')) {
                    $image_name = uniqid() . str_replace(' ', '', $file->getClientOriginalName());
                    $path = '/images/products/';
                    $file->move(public_path($path), $image_name);
                    $image_name_path = $path . $image_name;
                    $product->image = $image_name_path;
                }
                $product->business_id = auth()->user()->business_id;
                $product->created_by = auth()->user()->id;
                $product->gem_weight = $request->gem_weight ? '1' : '0';
                $product->save();
                return back();
            } catch (\Exception $e) {
                return back()->with('fail', 'Fail to Create New Product Type');
            }
        }
        return back()->with('fail', 'No permission');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $product = Product::find($id);
            $product->delete();
            return back();
        }
        return back();
    }
}
