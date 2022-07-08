<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoldQuality;
use Illuminate\Support\Facades\Auth;

class GoldQualityController extends Controller
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
    public function store(Request $request)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {

            $this->validate($request, [
                'quality' => ['required', 'max:2'],
            ]);
            try {
                $gold_quality = GoldQuality::create([
                    'quality' => $request->quality,
                    'business_id' => auth()->user()->business_id,
                ]);
                return response()->json([
                    'data' => $gold_quality,
                ]);
            } catch (\Exception $e) {
                return back()->with('fail', 'Fail to Create New Product Type');
            }
        }
        return back();
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
        // return $contact;
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'key' => ['required', 'max:1'],
            ]);
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
        return back()->withErrors(['fail' => 'No permission']);
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

    public function getList()
    {
        $gold_quality = GoldQuality::where('business_id',auth()->user()->business_id)->get()->toArray();
        return response()->json([
            'data' => $gold_quality,
        ]);
    }
}
