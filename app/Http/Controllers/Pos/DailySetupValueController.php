<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailySetupDetail;

class DailySetupValueController extends Controller
{
    public function editDailySetup(Request $request)
    {
        // $request->quality;
        // $request->dailySetup;
        // dd($request->dailySetup);
        $daily_setup_detail = DailySetupDetail::find($request->dailySetup["id"]);
        $daily_setup_detail->daily_price_kyat = $request->dailySetup["kyat"];
        $daily_setup_detail->daily_price_pal = $request->dailySetup["kyat"] / 16;
        $daily_setup_detail->daily_price_yway = $request->dailySetup["kyat"] / 128;
        $daily_setup_detail->save();
        // dd($daily_setup_detail);
        // $data = [];
        // $data['kyat'] = $daily_setup_detail->daily_price_kyat;
        // $data['pal'] = $daily_setup_detail->daily_price_pal;
        // $data['yway'] = $daily_setup_detail->daily_price_yway;

        return response()->json($daily_setup_detail);

    }
}
