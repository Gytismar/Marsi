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
            'total_workforce' => 'nullable|integer',
            'incidents_of_injury' => 'nullable|integer',
            'lost_days' => 'nullable|integer',
            'fatalities' => 'nullable|integer',
            'health_safety_training' => 'nullable|boolean',
            'management_system_coverage' => 'nullable|boolean',
        ];
    }
}
