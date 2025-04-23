<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CompanyController,
    RemoteDataFetchController,
    Gri2GovernanceController,
    Gri302EnergyController,
    Gri303WaterController,
    Gri305EmissionController,
    Gri306WasteController,
    Gri403HealthSafetyController};

Route::prefix('v1')->group(function () {
    Route::apiResource('companies', CompanyController::class);
    Route::post('/fetch-csv', [RemoteDataFetchController::class, 'fetch']);
    Route::prefix('gri')->group(function () {

        Route::get('g302-energy/schema', [Gri302EnergyController::class, 'schema']);
        Route::post('g302-energy/bulk-import', [Gri302EnergyController::class, 'bulkImport']);

        Route::get('g303-water/schema', [Gri303WaterController::class, 'schema']);
        Route::post('g303-water/bulk-import', [Gri303WaterController::class, 'bulkImport']);

        Route::get('g305-emissions/schema', [Gri305EmissionController::class, 'schema']);
        Route::post('g305-emissions/bulk-import', [Gri305EmissionController::class, 'bulkImport']);

        Route::get('g306-waste/schema', [Gri306WasteController::class, 'schema']);
        Route::post('g306-waste/bulk-import', [Gri306WasteController::class, 'bulkImport']);

        Route::get('g403-health-safety/schema', [Gri403HealthSafetyController::class, 'schema']);
        Route::post('g403-health-safety/bulk-import', [Gri403HealthSafetyController::class, 'bulkImport']);

        Route::get('g2-governance/schema', [Gri2GovernanceController::class, 'schema']);
        Route::post('g2-governance/bulk-import', [Gri2GovernanceController::class, 'bulkImport']);

        Route::apiResource('g2-governance', Gri2GovernanceController::class);
        Route::apiResource('g302-energy', Gri302EnergyController::class);
        Route::apiResource('g303-water', Gri303WaterController::class);
        Route::apiResource('g305-emissions', Gri305EmissionController::class);
        Route::apiResource('g306-waste', Gri306WasteController::class);
        Route::apiResource('g403-health-safety', Gri403HealthSafetyController::class);
    });
});
