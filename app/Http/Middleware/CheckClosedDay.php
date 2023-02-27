<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\OpenCloseDay;
use Inertia\Inertia;

class CheckClosedDay
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $openCloseDayData = OpenCloseDay::latest()->first();
        $today = Carbon::now()->format('Y-m-d');


        if( Carbon::parse($openCloseDayData->opening_date_time)->format('Y-m-d') < $today && $openCloseDayData->closed == 0 ){
            // return redirect()->route('admin.alert.requireCloseDayAlert');
            // dd($openCloseDayData);
            return Inertia::render('AdminPanel/Errors/RequireCloseDayAlert');
        }
        return $next($request);
    }
}
