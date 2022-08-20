<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Contact;
use App\Models\DailySetup;
use App\Models\ProductType;
use App\Models\LimitationPrice;
use App\Models\Type;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Carbon\Carbon;
use DB;
use App\Http\Requests\Admins\DailySetupRequest;

class DailySetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $business_id = auth()->user()->business_id;
        // $daily_setups = DailySetup::query();
        // $daily_setups->where('business_id', '=', $business_id);
        // if (request('date')) {
        //     $daily_setups->whereDate('created_at', '=', request('date'));
        // } else {
        //     $daily_setups->whereDate('created_at', '=', date('Y-m-d'));
        // }
        // $daily_setups->orderBy('created_at', 'DESC');
        // $product_types = Type::where('business_id', $business_id)
        //     ->get();

        // return Inertia::render('AdminPanel/ProductManagement/DailySetup/Index', [
        //     'daily_setups' => $daily_setups->with('productType')->paginate()->withQueryString(),
        //     'product_types' => $product_types
        // ]);

        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,city']
        ]);
        $business_id = auth()->user()->business_id;
        $daily_setups = DailySetup::query();
        $daily_setups->where('business_id', '=', $business_id);

        if (request('search')) {
            $daily_setups->where('daily_price', 'LIKE', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $daily_setups->orderBy(request('field'), request('direction'));
        }
        $daily_setups->orderBy('created_at', 'DESC');
        return Inertia::render('AdminPanel/ProductManagement/DailySetup/Index', [
            'daily_setups' => $daily_setups->paginate()->withQueryString(),
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
    public function store(DailySetupRequest $request)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {

            $this->validate($request, [
                'daily_price' => ['required'],
            ]);
            try {
                DailySetup::create([
                    'type' => "gold",
                    'business_id' => auth()->user()->business_id,
                    'daily_price' => $request->daily_price,
                ]);
                return back();
            } catch (\Exception $e) {
                return back()->with('fail', 'Fail to Create New Daily Price');
            }
        }
        return back();
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDialog(DailySetupRequest $request)
    {
        try {
            DB::beginTransaction();
            $daily_setup = DailySetup::create([
                'type' => "gold",
                'business_id' => auth()->user()->business_id,
                'daily_price' => $request->daily_price,
            ]);
            if($request->type == "purchase_return"){
                $limitation_price = LimitationPrice::where('customize','0')
                    // ->where('business_id', Auth::user()->business_id)
                    ->where('business_id',1)
                    ->orderBy('created_at', 'DESC')
                    ->first();
                $daily_price = $daily_setup->daily_price - $limitation_price->price;
            }else{
                $daily_price = $daily_setup->daily_price;
            }
            $daily_kyat =  $daily_price / 16;
            $data = [];
            for ($x = 1; $x <= 16; $x++) {
                $kyat = $daily_price - ($daily_kyat * (16 - $x));
                $pal = $kyat / 16;
                $yway = $pal / 8;
                $data [$x] = [
                    'daily_setup_id' => $daily_setup->id,
                    'kyat' => $kyat,
                    'pal' => $pal,
                    'yway' => $yway,
                ];

            }
            DB::commit();
            return response()->json(['data'=>$data]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('fail', 'Fail to Create Daily Setup');
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
    public function update(DailySetupRequest $request, $id)
    {
        try {
            $daily_setup = DailySetup::find($id);
            $daily_setup->daily_price = $request->daily_price;
            $daily_setup->save();
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['fail' => 'Fail to Update  Daily Price']);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function editDailySetup(Request $request)
    // {
    //     // return $request->daily_setups;
    //     if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {

    //         try {
    //             foreach ($request->daily_setups as $daily_setup) {
    //                 $daily = DailySetup::find($daily_setup["id"]);
    //                 $daily->daily_price = $daily_setup["daily_price"];
    //                 $daily->save();
    //             }
    //             return redirect()->back();
    //         } catch (\Exception $e) {
    //             return back()->withErrors(['fail' => 'Fail to Update Product Type']);
    //         }
    //     }
    //     return back()->withErrors(['fail' => 'No permission']);
    // }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $daily_setup = DailySetup::find($id);
            $daily_setup->delete();
            return back();
        }
        return back();
    }
}
