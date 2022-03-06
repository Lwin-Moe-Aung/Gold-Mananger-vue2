<?php

namespace App\Http\Middleware;

use App\Models\DailySetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;

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
                $daily_price =  DailySetup::select('daily_price')
                    ->where('type', 1)
                    ->where('business_id', 1)
                    ->first();
                $q_16pal = $daily_price->daily_price;
                $pal = $q_16pal / 16;
                $q_15pal = $q_16pal - $pal;
                $q_14pal = $q_16pal - ($pal * 2);
                $q_13pal = $q_16pal - ($pal * 3);
                $q_12pal = $q_16pal - ($pal * 4);
                $q_11pal = $q_16pal - ($pal * 5);
                return [
                    '16' => [
                        'kyat' => $q_16pal,
                        'pal' => $q_16pal / 16,
                        'yway' => $q_16pal / 128,
                    ],
                    '15' => [
                        'kyat' => $q_15pal,
                        'pal' => $q_15pal / 16,
                        'yway' => $q_15pal / 128,
                    ],
                    '14' => [
                        'kyat' => $q_14pal,
                        'pal' => $q_14pal / 16,
                        'yway' => $q_14pal / 128,
                    ],
                    '13' => [
                        'kyat' => $q_13pal,
                        'pal' => $q_13pal / 16,
                        'yway' => $q_13pal / 128,
                    ],
                    '12' => [
                        'kyat' => $q_12pal,
                        'pal' => $q_12pal / 16,
                        'yway' => $q_12pal / 128,
                    ],
                    '11' => [
                        'kyat' => $q_11pal,
                        'pal' => $q_11pal / 16,
                        'yway' => $q_11pal / 128,
                    ],
                ];
            },
            // 'success' => session()->has('success') ? session()->get('success') : "",
            // 'fail' => session()->has('fail') ? session()->get('fail') : "",
        ]);
    }
}
