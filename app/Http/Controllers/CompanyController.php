<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CompanyService;

class CompanyController extends Controller
{
    protected CompanyService $service;

    public function __construct(CompanyService $service)
    {
        $this->service = $service;
    }

    protected function service(): CompanyService
    {
        return $this->service;
    }

    protected function validationRules(Request $request): array
    {
        return [
            'company_name' => $request->isMethod('post') ? 'required|string' : 'sometimes|string',
            'industry' => $request->isMethod('post') ? 'required|string' : 'sometimes|string',
            'country' => $request->isMethod('post') ? 'required|string' : 'sometimes|string',
            'size' => $request->isMethod('post') ? 'required|string' : 'sometimes|string',
        ];
    }
}
