<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Gri303WaterService;

class Gri303WaterController extends AbstractGriController
{
    protected Gri303WaterService $service;

    public function __construct(Gri303WaterService $service)
    {
        $this->service = $service;
    }

    protected function service(): Gri303WaterService
    {
        return $this->service;
    }

    protected function validationRules(Request $request): array
    {
        $required = $request->isMethod('post') ? 'required|' : 'sometimes|';

        return [
            'company_id' => $required . 'integer',
            'reporting_year' => $required . 'integer',
            'water_withdrawn' => $required . 'numeric',
            'water_source_type' => $required . 'string',
            'discharge_destination' => $required . 'string',
            'water_consumption' => $required . 'numeric',
            'water_recycled' => 'nullable|numeric',
            'water_discharge' => 'nullable|numeric',
            'unit' => $required . 'string',
            'source' => $required . 'string',
        ];
    }

    protected function getRequiredFields(): array
    {
        return [
            'company_id',
            'reporting_year',
            'water_withdrawn',
            'unit',
            'source',
        ];
    }

    public function schema(): JsonResponse
    {
        return response()->json([
            'fields' => [
                'company_id',
                'reporting_year',
                'water_withdrawn',
                'water_source_type',
                'water_discharge',
                'discharge_destination',
                'water_consumption',
                'water_recycled',
                'unit',
                'source',
            ],
            'required' => [
                'company_id',
                'reporting_year',
                'water_withdrawn',
                'water_source_type',
                'discharge_destination',
                'water_consumption',
                'unit',
                'source',
            ],
        ]);
    }
}
