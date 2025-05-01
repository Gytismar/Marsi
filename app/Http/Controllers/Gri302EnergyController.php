<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Gri302EnergyService;

class Gri302EnergyController extends AbstractGriController
{
    protected Gri302EnergyService $service;

    public function __construct(Gri302EnergyService $service)
    {
        $this->service = $service;
    }

    protected function service(): Gri302EnergyService
    {
        return $this->service;
    }

    protected function validationRules(Request $request): array
    {
        $required = $request->isMethod('post') ? 'required|' : 'sometimes|';

        return [
            'company_id' => 'sometimes|integer',
            'reporting_year' => $required . 'integer',
            'total_energy_consumed' => 'nullable|numeric',
            'renewable_energy_consumed' => $required . 'numeric',
            'nonrenewable_energy_consumed' => $required . 'numeric',
            'energy_consumed_unit' => $required . 'string',
            'energy_intensity' => 'nullable|numeric',
            'reduction_achieved' => 'nullable|numeric',
            'source' => $required . 'string',
        ];
    }

    protected function getRequiredFields(): array
    {
        return [
            'reporting_year',
            'renewable_energy_consumed',
            'nonrenewable_energy_consumed',
            'energy_consumed_unit',
            'source',
        ];
    }
}
