<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Business;
use App\Models\LimitationPrice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admins\LimitationPriceRequest;
use Illuminate\Http\Request;


class LimitationPriceController extends Controller
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
        $business_id = auth()->user()->business_id;
        $limitation_prices = LimitationPrice::query();
        $limitation_prices->where('business_id', '=', $business_id);

        if (request('search')) {
            $limitation_prices->where('price', 'LIKE', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $limitation_prices->orderBy(request('field'), request('direction'));
        }
        $limitation_prices->orderBy('created_at', 'DESC');
        return Inertia::render('AdminPanel/PurchaseManagement/LimitationPrice/Index', [
            'limitation_prices' => $limitation_prices->paginate(5)->withQueryString(),
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
    public function store(LimitationPriceRequest $request)
    {
        try {
            LimitationPrice::create([
                'business_id' => auth()->user()->business_id,
                'price' => $request->price,
            ]);
            return back();
        } catch (\Exception $e) {
            return back()->with('fail', 'Fail to Create Limitation Price');
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
    public function update(Request $request, $id)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {
            $this->validate($request, [
                'price' => ['required'],
            ]);
            try {
                $limitation_price = LimitationPrice::find($id);
                $limitation_price->price = $request->price;
                $limitation_price->save();
                return back();
            } catch (\Exception $e) {
                return back()->withErrors(['fail' => 'Fail to Update  Limitation Price']);
            }
        }
        return back()->withErrors(['fail' => 'No permission']);
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
    //     // return $request->limitation_prices;
    //     if (auth()->user()->hasAnyRole(['super-admin', 'admin'])) {

    //         try {
    //             foreach ($request->limitation_prices as $limitation_price) {
    //                 $daily = DailySetup::find($limitation_price["id"]);
    //                 $daily->daily_price = $limitation_price["daily_price"];
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
            $limitation_price = LimitationPrice::find($id);
            $limitation_price->delete();
            return back();
        }
        return back();
    }
}
