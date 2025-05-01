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
            'company_id' => 'sometimes|integer',
            'reporting_year' => $required . 'integer',
            'water_withdrawn' => $required . 'numeric',
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
            'reporting_year',
            'water_withdrawn',
            'unit',
            'source',
        ];
    }
}
