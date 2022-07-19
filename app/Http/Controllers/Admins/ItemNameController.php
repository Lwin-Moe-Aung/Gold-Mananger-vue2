<?php

namespace App\Http\Controllers\Admins;

use App\Models\Type;
use Inertia\Inertia;
use App\Models\Contact;
use App\Models\Business;
use App\Models\ItemName;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admins\ItemNameRequest;

class ItemNameController extends Controller
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

        $item_name = ItemName::query();

        if (request('search')) {
            $item_name->where('name', 'LIKE', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $item_name->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('AdminPanel/ProductManagement/ItemName/Index', [
            'item_names' => $item_name->paginate(5)->withQueryString(),
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
    public function store(ItemNameRequest $request)
    {
        try {
            ItemName::create([
                'name' => $request->name,
                'key' => $request->key,
                'business_id' => auth()->user()->business_id,
                'is_active' => 1,
            ]);
            return back();
        } catch (\Exception $e) {
            return back()->with('fail', 'Fail to Create New Item Name');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDialog(ItemNameRequest $request)
    {
        try {
            $item_name = ItemName::create([
                'name' => $request->name,
                'key' => $request->key,
                'business_id' => auth()->user()->business_id,
                'is_active' => 1,
            ]);
            return response()->json([
                'data' => $item_name,
            ]);
        } catch (\Exception $e) {
            return back()->with('fail', 'Fail to Create New Item Name');
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
    public function update(ItemNameRequest $request, $id)
    {
        try {
            $item_name = ItemName::find($id);
            $item_name->name = $request->name;
            $item_name->key = $request->key;
            $item_name->save();

            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['fail' => 'Fail to Update Item Name']);
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
            $item_name = ItemName::find($id);
            $item_name->delete();
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
        $item_name = ItemName::where('business_id',auth()->user()->business_id)->get();
        return response()->json([
            'data' => $item_name,
        ]);
    }
}
