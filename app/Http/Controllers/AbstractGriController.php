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
    abstract protected function getRequiredFields(): array;

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
        return response()->json([
            'fields' => $this->service()->getSchema(),
            'required' => $this->getRequiredFields(),
        ]);
    }

    public function bulkImport(Request $request): JsonResponse
    {
        $rows = $request->all();

        if (!is_array($rows)) {
            return response()->json(['error' => 'Invalid data format. Expected an array of objects.'], 422);
        }

        $validatedRows = [];

        foreach ($rows as $index => $row) {
            try {
                $validated = validator($row, $this->validationRules(new Request($row)))->validate();
                $validatedRows[] = $validated;
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'error' => "Validation failed on row {$index}.",
                    'details' => $e->errors(),
                ], 422);
            }
        }

        $created = $this->service()->bulkCreate($validatedRows);

        return response()->json([
            'message' => 'Bulk import completed.',
            'imported' => count($created),
        ], 201);
    }
}

