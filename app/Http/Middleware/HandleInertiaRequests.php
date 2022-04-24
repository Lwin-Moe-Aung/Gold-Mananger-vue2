<?php

namespace App\Http\Middleware;

use App\Models\DailySetup;
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
                $daily_price =  DailySetup::with('dailySetupDetail')
                    ->where('type', 1)
                    ->where('business_id', 1)
                    ->latest('created_at')
                    ->first();
                $data = [];
                foreach ($daily_price->dailySetupDetail as $value) {
                    $data [$value->quality] = [
                        'id' => $value->id,
                        'daily_setup_id' => $value->daily_setup_id,
                        'kyat' => $value->daily_price_kyat,
                        'pal' => $value->daily_price_pal,
                        'yway' => $value->daily_price_yway,
                    ];
                };
                return $data;
            },
            // 'success' => session()->has('success') ? session()->get('success') : "",
            // 'fail' => session()->has('fail') ? session()->get('fail') : "",
        ]);
    }
}
