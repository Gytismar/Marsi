<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Gri2GovernanceService;

class Gri2GovernanceController extends Controller
{
    protected Gri2GovernanceService $service;

    public function __construct(Gri2GovernanceService $service)
    {
        $this->service = $service;
    }

    protected function service(): Gri2GovernanceService
    {
        return $this->service;
    }

    protected function validationRules(Request $request): array
    {
        $required = $request->isMethod('post') ? 'required|' : 'sometimes|';

        return [
            'company_id' => $required . 'integer',
            'reporting_year' => $required . 'integer',
            'governance_structure' => 'nullable|string',
            'board_size' => 'nullable|integer',
            'independent_members' => 'nullable|integer',
            'chair_is_executive' => 'nullable|boolean',
            'delegation_of_responsibility' => 'nullable|string',
            'reporting_frequency' => 'nullable|string',
            'board_review_of_esg' => 'nullable|boolean',
            'conflict_of_interest_policy' => 'nullable|boolean',
            'policy_code_of_ethics' => 'nullable|boolean',
            'ethics_advice_mechanism' => 'nullable|string',
            'report_misconduct_mechanism' => 'nullable|string',
            'compliance_violations_count' => 'nullable|integer',
            'compliance_fines_value' => 'nullable|numeric',
        ];
    }
}
