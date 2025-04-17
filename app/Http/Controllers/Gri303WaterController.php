<?php

namespace App\Http\Controllers;

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
            'water_source_type' => 'nullable|string',
            'water_discharge' => 'nullable|numeric',
            'discharge_destination' => 'nullable|string',
            'water_consumption' => 'nullable|numeric',
        ];
    }
}
