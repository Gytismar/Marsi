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
            'company_id' => 'sometimes|integer',
            'reporting_year' => $required . 'integer',
            'total_waste_generated' => $required . 'numeric',
            'hazardous_waste_generated' => $required . 'numeric',
            'nonhazardous_waste_generated' => $required . 'numeric',
            'waste_recycled' => $required . 'numeric',
            'waste_disposed' => $required . 'numeric',
            'disposal_method' => $required . 'string',
        ];
    }

    protected function getRequiredFields(): array
    {
        return [
            'reporting_year',
            'total_waste_generated',
            'hazardous_waste_generated',
            'nonhazardous_waste_generated',
            'waste_recycled',
            'waste_disposed',
            'disposal_method',
        ];
    }
}
