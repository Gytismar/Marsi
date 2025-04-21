<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as LaravelController;
use App\Services\Service;

abstract class AbstractGriController extends LaravelController
{
    abstract protected function service(): Service;
    abstract protected function validationRules(Request $request): array;

    public function index(): JsonResponse
    {
        return response()->json($this->service()->getAll());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service()->getById($id));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate($this->validationRules($request));
        return response()->json($this->service()->create($validated), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate($this->validationRules($request));
        return response()->json($this->service()->update($id, $validated));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service()->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function schema(): JsonResponse
    {
        return response()->json($this->service()->getSchema());
    }

}

