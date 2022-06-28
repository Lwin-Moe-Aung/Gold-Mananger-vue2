<?php

namespace App\Http\Middleware;

use App\Models\DailySetup;
use App\Models\Product;
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
                $daily_setup =  DailySetup::where('type', 'gold')
                    // ->where('business_id', Auth::user()->business_id)
                    ->where('business_id',1)
                    ->where('customize','0')
                    ->latest('created_at')
                    ->first();
                $daily_price = $daily_setup->daily_price;
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
                return $data;
            },

            // 'success' => session()->has('success') ? session()->get('success') : "",
            // 'fail' => session()->has('fail') ? session()->get('fail') : "",
        ]);
    }
}
