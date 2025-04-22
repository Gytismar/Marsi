<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CompanyController,
    CsvProxyController,
    Gri2GovernanceController,
    Gri302EnergyController,
    Gri303WaterController,
    Gri305EmissionController,
    Gri306WasteController,
    Gri403HealthSafetyController};

Route::prefix('v1')->group(function () {
    Route::apiResource('companies', CompanyController::class);
    Route::post('/fetch-csv', [CsvProxyController::class, 'fetch']);
    Route::prefix('gri')->group(function () {

        Route::get('g302-energy/schema', [Gri302EnergyController::class, 'schema']);

        Route::post('g302-energy/bulk-import', [Gri302EnergyController::class, 'bulkImport']);

        Route::apiResource('g2-governance', Gri2GovernanceController::class);
        Route::apiResource('g302-energy', Gri302EnergyController::class);
        Route::apiResource('g303-water', Gri303WaterController::class);
        Route::apiResource('g305-emissions', Gri305EmissionController::class);
        Route::apiResource('g306-waste', Gri306WasteController::class);
        Route::apiResource('g403-health-safety', Gri403HealthSafetyController::class);
    });
});
