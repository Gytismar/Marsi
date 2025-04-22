<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Gri403HealthSafetyService;

class Gri403HealthSafetyController extends AbstractGriController
{
    protected Gri403HealthSafetyService $service;

    public function __construct(Gri403HealthSafetyService $service)
    {
        $this->service = $service;
    }

    protected function service(): Gri403HealthSafetyService
    {
        return $this->service;
    }

    protected function validationRules(Request $request): array
    {
        $required = $request->isMethod('post') ? 'required|' : 'sometimes|';

        return [
            'company_id' => $required . 'integer',
            'reporting_year' => $required . 'integer',
            'total_workforce' => $required . 'integer',
            'incidents_of_injury' => $required . 'integer',
            'lost_days' => $required . 'integer',
            'fatalities' => 'nullable|integer',
            'health_safety_training' => $required . 'numeric',
            'management_system_coverage' => $required . 'string',
        ];
    }

    protected function getRequiredFields(): array
    {
        return [
            'company_id',
            'reporting_year',
            'total_workforce',
            'incidents_of_injury',
            'lost_days',
            'health_safety_training',
            'management_system_coverage',
        ];
    }

}
