<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlertController extends Controller
{
    public function requireCloseDayAlert() {
        return Inertia::render('AdminPanel/Errors/RequireCloseDayAlert');
    }

    public function requireOpenDayAlert() {
        return Inertia::render('AdminPanel/Errors/RequireOpenDayAlert');
    }
}
