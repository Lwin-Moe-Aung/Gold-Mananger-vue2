<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Contact;
use App\Models\DailySetup;
use App\Models\ProductType;
use App\Models\Type;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Carbon\Carbon;

class DailySetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = auth()->user()->business_id;
        $daily_setups = DailySetup::query();
        $daily_setups->where('business_id', '=', $business_id);
        if (request('date')) {
            $daily_setups->whereDate('created_at', '=', request('date'));
        } else {
            $daily_setups->whereDate('created_at', '=', date('Y-m-d'));
        }
        $product_types = Type::where('business_id', $business_id)
            ->get();

        return Inertia::render('AdminPanel/ProductManagement/DailySetup/Index', [
            'daily_setups' => $daily_setups->with('productType')->paginate()->withQueryString(),
            'product_types' => $product_types
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
            try {
                foreach ($request->daily_setups as $value) {
                    DailySetup::create([
                        'type_of_daily_setup' => $value["type_of_daily_setup"],
                        'business_id' => $value["business_id"],
                        'daily_price' => $value["daily_price"]
                    ]);
                }
                return back();
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
        return back()->withErrors(['fail' => 'No permission']);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editDailySetup(Request $request)
    {
        // return $request->daily_setups;
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {

            try {
                foreach ($request->daily_setups as $daily_setup) {
                    $daily = DailySetup::find($daily_setup["id"]);
                    $daily->daily_price = $daily_setup["daily_price"];
                    $daily->save();
                }
                return redirect()->back();
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
}
