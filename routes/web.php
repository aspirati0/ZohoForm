hot<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZohoController;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

        Route::get('/zoho', [ZohoController::class, 'showForm'])->name('zoho.form');
        Route::post('/zoho', [ZohoController::class, 'createDeal'])->name('zoho.create');
    });
});

?>