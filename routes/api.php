<?php

use App\Actions\ExternalServices\Reniec\GetReniecData;
use App\Actions\ExternalServices\Sunat\GetSunatData;
use App\Http\Controllers\Api\DataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutas protegidas con autenticación
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
});


Route::post('/reniec-data/store', [DataController::class, 'storeData'])->name('api.reniec-data.store');
