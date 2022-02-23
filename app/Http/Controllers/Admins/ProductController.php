<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\GoldQualityKyat;
use App\Models\GoldQualityPal;
use App\Models\GoldQualityYway;
use App\Models\Product;
use App\Models\ProductType;
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
        $products = Product::where('business_id',$business_id)->with('user')->paginate(10);
        $product_types = ProductType::where('business_id',$business_id)->get();
        $gold_quality_kyats = GoldQualityKyat::where('business_id',$business_id)->get();
        $gold_quality_pals = GoldQualityPal::where('business_id',$business_id)->get();
        $gold_quality_yways = GoldQualityYway::where('business_id',$business_id)->get();

        return Inertia::render('Admins/ProductManagement/Products/Index',[
            'products' => $products,
            'product_types' => $product_types,
            'gold_quality_kyats' => $gold_quality_kyats,
            'gold_quality_pals' => $gold_quality_pals,
            'gold_quality_yways' => $gold_quality_yways,
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
                'p_type' => ['required'],
                'q_kyat' => ['required'],
                'q_pal' => ['required'],
                'q_yway' => ['required'],
            ]);
            try {
                if($file = $request->file('image')){
                    $image_name = uniqid().str_replace(' ','',$file->getClientOriginalName());
                    $path = '/images/products/';
                    $file->move(public_path($path),$image_name);
                    $image_name_path = $path.$image_name;
                }else{
                    $image_name_path = null;
                }
                $product_sku = $request->p_type["key"].$request->q_kyat["name"].$request->q_pal["name"].$request->q_yway["name"];
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
                return back()->with('fail','Fail to Create New Product Type');
            }
           
        }
        return back()->with('fail','No permission');
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
