<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpenCloseDay;
use App\Models\DailySetup;
use App\Models\DailySetupForPurchaseReturn;
use App\Models\LimitationPrice;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class OpeningDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('AdminPanel/SetupManagement/OpeningDay/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveData(Request $request)
    {
        try {
            $open_close_days = OpenCloseDay::create([
                'opened' => '1',
                'opening_balance' => $request->opening_balance,
                'opening_date_time' => Carbon::now()
            ]);

            $daily_setup = new DailySetup;
            foreach ($request->daily_setup_form as $value) {
                $this->savingFormForDailySetup($daily_setup, $value, $open_close_days->id);
            }

            $daily_setup_for_purchase_return = new DailySetupForPurchaseReturn;
            foreach ($request->daily_setup_form as $value) {
                $this->savingFormForDailySetupPurchaseReturn($daily_setup_for_purchase_return, $value, $open_close_days->id);
            }
            LimitationPrice::create([
                'open_close_day_id' => $open_close_days->id,
                'price' => $request->limitation_price,
                'business_id' => auth()->user()->business_id,
            ]);

            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return back()->with('fail', 'Fail to A Day');
        }

    }

    /**
     * saving data for Daily Setup Purchase Return
     */
    public function savingFormForDailySetupPurchaseReturn($model, $item, $open_close_day_id)
    {
        $model::create([
            'type' => 'gold',
            'key' => $item['key'],
            'open_close_day_id' => $open_close_day_id,
            'kyat' => $item['kyat'],
            'pal' => $item['pal'],
            'yway' => $item['yway'],
            'business_id' => auth()->user()->business_id,
        ]);
    }
    /**
     * saving data for Daily Setup
     */
    public function savingFormForDailySetup($model, $item, $open_close_day_id)
    {
        $model::create([
            'type' => 'gold',
            'key' => $item['key'],
            'open_close_day_id' => $open_close_day_id,
            'market_price' => $item['market_price'],
            'kyat' => $item['kyat'],
            'pal' => $item['pal'],
            'yway' => $item['yway'],
            'business_id' => auth()->user()->business_id,
        ]);
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
