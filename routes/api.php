<?php

use App\Actions\ExternalServices\Reniec\GetReniecData;
use App\Actions\ExternalServices\Sunat\GetSunatData;
use App\Http\Controllers\Api\DataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/reniec/{dni}', function ($dni) {
        return GetReniecData::run($dni);
    });

    Route::get('/sunat/{dni}', function (Request $request) {
        return GetSunatData::run($request->dni);
    });

    Route::get('/data', [DataController::class, 'create'])->name('data');
    Route::post('/data/store', [DataController::class, 'store'])->name('data.store');
});
