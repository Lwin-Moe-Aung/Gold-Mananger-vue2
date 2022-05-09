<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = auth()->user()->business_id;
        $products = Product::where('business_id', $business_id)->with('user')->paginate(10);
        $gold_qualities = GoldQuality::where('business_id', $business_id)->get();
        $types = Type::where('business_id', $business_id)->get();
        $item_names = ItemName::where('business_id', $business_id)->get();
        $weight_kyats = WeightKyat::where('business_id', $business_id)->get();
        $weight_pals = WeightPal::where('business_id', $business_id)->get();
        $weight_yways = WeightYway::where('business_id', $business_id)->get();

        return Inertia::render('AdminPanel/ProductManagement/Products/Index', [
            'products' => $products,
            'gold_qualities' => $gold_qualities,
            'types' => $types,
            'item_names' => $item_names,
            'weight_kyats' => $weight_kyats,
            'weight_pals' => $weight_pals,
            'weight_yways' => $weight_yways,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'quality' => ['required'],
                'type' => ['required'],
                'item_name' => ['required'],
                'w_kyat' => ['required'],
                'w_pal' => ['required'],
                'w_yway' => ['required'],
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
                $product_sku = $request->quality["quality"] . $request->type["key"] . $request->item_name["key"] . $request->w_kyat["name"] . $request->w_pal["name"] . $request->w_yway["name"];
                Product::create([
                    'name' => $request->name,
                    'product_sku' => $product_sku,
                    'description' => $request->description,
                    'tax' => $request->tax,
                    'alert_quantity' => $request->alert_quantity,
                    'business_id' => auth()->user()->business_id,
                    'created_by' => auth()->user()->id,
                    'image' => $image_name_path,
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
