<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Gri306WasteService;

class Gri306WasteController extends AbstractGriController
{
    protected Gri306WasteService $service;

    public function __construct(Gri306WasteService $service)
    {
        $this->service = $service;
    }

    protected function service(): Gri306WasteService
    {
        return $this->service;
    }

    protected function validationRules(Request $request): array
    {
        $required = $request->isMethod('post') ? 'required|' : 'sometimes|';

        return [
            'company_id' => $required . 'integer',
            'reporting_year' => $required . 'integer',
            'total_waste_generated' => 'nullable|numeric',
            'hazardous_waste_generated' => 'nullable|numeric',
            'nonhazardous_waste_generated' => 'nullable|numeric',
            'waste_recycled' => 'nullable|numeric',
            'waste_disposed' => 'nullable|numeric',
            'disposal_method' => 'nullable|string',
        ];
    }
}
