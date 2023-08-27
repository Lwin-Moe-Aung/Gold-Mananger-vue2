<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\OpeningDayController;


Route::middleware(['check_closed_day'])->group(function() {
    // OpeningDayController
    Route::post('opening-days/save-data', [OpeningDayController::class, 'saveData'])->name('opening-days.saveData');
});


