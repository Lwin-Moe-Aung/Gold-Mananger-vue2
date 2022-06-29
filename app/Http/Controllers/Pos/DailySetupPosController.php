<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailySetup;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
use DB;


class DailySetupPosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('PosPanel/Pos/DailySetup/Index',[
            'daily_setups' => DailySetup::where('business_id',Auth::user()->business_id)
                            ->where('customize','0')
                            ->orderBy('created_at', 'desc')
                            ->paginate(50),
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
        if (auth()->user()->hasAnyRole(['super-admin', 'admin', 'cashier'])) {
            $this->validate($request, [
                'daily_price' => ['required'],
            ]);
            try {
                $daily_setup = DailySetup::create([
                    'daily_price' => $request->daily_price,
                    'business_id' => Auth::user()->business_id
                ]);
                return response()->json([
                    'data' => $daily_setup,

                ]);
            } catch (\Exception $e) {
                return back()->with('fail', 'Fail to Create New Daily Setup');
            }
        }
        return back()->with('fail', 'No permission');
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin', 'cashier'])) {
            $this->validate($request, [
                'daily_price' => ['required'],
            ]);
            try {
                $daily_setup = DailySetup::find($request->id);
                $daily_setup->daily_price = $request->daily_price;
                $daily_setup->save();
                return back();
            } catch (\Exception $e) {
                return back()->with('fail', 'Fail to Edit Daily Setup');
            }
        }
        return back()->with('fail', 'No permission');
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (auth()->user()->hasAnyRole(['super-admin', 'admin', 'cashier'])) {
            try {
                $daily_setup = DailySetup::find($request->id);
                $daily_setup->delete();
                return back();
            } catch (\Exception $e) {
                return back()->with('fail', 'Fail to Delete Daily Setup');
            }
        }
        return back()->with('fail', 'No permission');
    }
}
