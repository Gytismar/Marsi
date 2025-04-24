<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user()->companies);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string',
            'company_code' => 'required|string|unique:companies,company_code',
            'industry' => 'required|string',
            'country' => 'required|string',
            'size' => 'required|string',
        ]);

        $company = Auth::user()->companies()->create($validated);

        return response()->json($company, 201);
    }

    public function show($id)
    {
        $company = Auth::user()->companies()->findOrFail($id);
        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        $company = Auth::user()->companies()->findOrFail($id);

        $validated = $request->validate([
            'company_name' => 'sometimes|string',
            'company_code' => 'sometimes|string|unique:companies,company_code,' . $company->id,
            'industry' => 'sometimes|string',
            'country' => 'sometimes|string',
            'size' => 'sometimes|string',
        ]);

        $company->update($validated);

        return response()->json($company);
    }

    public function destroy($id)
    {
        $company = Auth::user()->companies()->findOrFail($id);
        $company->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
