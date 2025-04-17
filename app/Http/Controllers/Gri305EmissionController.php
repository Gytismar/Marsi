<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Gri305EmissionService;

class Gri305EmissionController extends AbstractGriController
{
    protected Gri305EmissionService $service;

    public function __construct(Gri305EmissionService $service)
    {
        $this->service = $service;
    }

    protected function service(): Gri305EmissionService
    {
        return $this->service;
    }

    protected function validationRules(Request $request): array
    {
        $required = $request->isMethod('post') ? 'required|' : 'sometimes|';

        return [
            'company_id' => $required . 'integer',
            'reporting_year' => $required . 'integer',
            'scope_1' => 'nullable|numeric',
            'scope_2' => 'nullable|numeric',
            'scope_3' => 'nullable|numeric',
            'ghg_intensity' => 'nullable|numeric',
        ];
    }
}
