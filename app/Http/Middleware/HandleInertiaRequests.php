<?php

namespace App\Http\Middleware;

use App\Models\DailySetup;
use App\Models\LimitationPrice;
use App\Models\Product;
use App\Models\OpenCloseDay;
use App\Models\DailySetupForPurchaseReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Carbon\Carbon;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => function () {
                $user = auth()->user();
                return $user ? [
                    'hasRole' => [
                        'superAdmin' => $user->hasRole(['super-admin']),
                        'admin' => $user->hasRole('admin'),
                        'cashier' => $user->hasRole('cashier'),
                    ]
                ] : null;
            },
            'flash' => [
                'message' => $request->session()->has('message') ? $request->session()->get('message', 'default') : "",
            ],
            'user' => Auth::user(),
            'daily_setup' => function () {
                $open_close_day = OpenCloseDay::whereDate('created_at', Carbon::today())->first();
                if($open_close_day == null) return;
                $daily_setups =  DailySetup::where('open_close_day_id', $open_close_day->id)
                    ->where('type', 'gold')
                    // ->where('business_id', Auth::user()->business_id)
                    ->where('business_id',1)
                    ->where('customize','0')
                    ->get();
                // $daily_price = $daily_setup->daily_price;
                // $daily_kyat =  $daily_price / 16;
                $data = [];
                foreach ($daily_setups as $daily_setup){
                    $data [$daily_setup->key] = [
                        'daily_setup_id' => $daily_setup->id,
                        'kyat' => $daily_setup->kyat,
                        'pal' => $daily_setup->pal,
                        'yway' => $daily_setup->yway,
                    ];
                }
                return $data;
            },
            'daily_setup_purchase_return' => function () {
                $open_close_day = OpenCloseDay::whereDate('created_at', Carbon::today())->first();
                if($open_close_day == null) return;
                $daily_setups =  DailySetupForPurchaseReturn::where('open_close_day_id', $open_close_day->id)
                    ->where('type', 'gold')
                    // ->where('business_id', Auth::user()->business_id)
                    ->where('business_id',1)
                    ->where('customize','0')
                    ->get();
                $data = [];
                foreach ($daily_setups as $daily_setup){
                    $data [$daily_setup->key] = [
                        'daily_setup_id' => $daily_setup->id,
                        'kyat' => $daily_setup->kyat,
                        'pal' => $daily_setup->pal,
                        'yway' => $daily_setup->yway,
                    ];
                }
                return $data;
            },
            'limitation_price' => function() {
                return LimitationPrice::where('customize','0')
                            // ->where('business_id', Auth::user()->business_id)
                            ->where('business_id',2)
                            ->orderBy('created_at', 'DESC')
                            ->first();
            },
            'open_close_day' => function() {
                return OpenCloseDay::whereDate('created_at', Carbon::today())->first();
            }

        ]);
    }
}
