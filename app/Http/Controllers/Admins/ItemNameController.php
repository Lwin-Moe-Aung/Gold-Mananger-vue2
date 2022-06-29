<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Contact;
use App\Models\ProductType;
use App\Models\Type;
use App\Models\ItemName;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

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
    public function store(Request $request)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {

            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'key' => ['required', 'max:1'],
            ]);
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
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'name' => ['required', 'max:50'],
                'key' => ['required', 'max:1'],
            ]);
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
            $item_name = ItemName::find($id);
            $item_name->delete();
            return back();
        }
        return back();
    }
}