<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\OpenCloseDay;
use Carbon\Carbon;

class CheckOpenedDay
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
        $openCloseDayData = OpenCloseDay::whereDate('created_at', Carbon::today())
                                    ->first();

        if( $openCloseDayData == null) return redirect()->route('admin.alert.requireOpenDayAlert');

        return $next($request);
    }
}
