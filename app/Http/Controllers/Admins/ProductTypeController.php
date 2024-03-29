<?php

namespace App\Http\Controllers\Admins;

use App\Models\Type;
use Inertia\Inertia;
use App\Models\Contact;
use App\Models\Business;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admins\ProductTypeRequest;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,city']
        ]);

        $product_type = Type::query();

        if (request('search')) {
            $product_type->where('name', 'LIKE', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $product_type->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('AdminPanel/ProductManagement/ProductType/Index', [
            'product_types' => $product_type->paginate(5)->withQueryString(),
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
    public function store(ProductTypeRequest $request)
    {
        try {
            Type::create([
                'name' => $request->name,
                'key' => $request->key,
                'business_id' => auth()->user()->business_id,
                'is_active' => 1,
            ]);
            return back();
        } catch (\Exception $e) {
            return back()->with('fail', 'Fail to Create New Product Type');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDialog(ProductTypeRequest $request)
    {
        try {
            $type = Type::create([
                'name' => $request->name,
                'key' => $request->key,
                'business_id' => auth()->user()->business_id,
                'is_active' => 1,
            ]);
            return response()->json([
                'data' => $type,
            ]);
        } catch (\Exception $e) {
            return back()->with('fail', 'Fail to Create New Product Type');
        }
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
    public function update(ProductTypeRequest $request, $id)
    {
        try {
            $product_type = Type::find($id);
            $product_type->name = $request->name;
            $product_type->key = $request->key;
            $product_type->save();

            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['fail' => 'Fail to Update Product Type']);
        }
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
            $product_type = Type::find($id);
            $product_type->delete();
            return back();
        }
        return back();
    }
    /**
     * Get all Item name.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        $type = Type::where('business_id',auth()->user()->business_id)->get();
        return response()->json([
            'data' => $type,
        ]);
    }
}
