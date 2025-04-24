<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

abstract class Service
{
    abstract protected function model(): Model;

    public function getAll(): Collection
    {
        return $this->model()
            ->newQuery()
            ->whereHas('company', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();
    }

    public function getById(int $id): Model
    {
        return $this->model()
            ->newQuery()
            ->whereHas('company', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);
    }

    public function create(array $data): Model
    {
        if (isset($data['company_id'])) {
            $company = \App\Models\Company::query()
                ->where('id', $data['company_id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();
        }

        return $this->model()->newQuery()->create($data);
    }

    public function update(int $id, array $data): Model
    {
        $record = $this->getById($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id): void
    {
        $record = $this->getById($id);
        $record->delete();
    }

    public function getSchema(): array
    {
        return $this->model()->getFillable();
    }

    public function bulkCreate(array $rows): array
    {
        $created = [];

        foreach ($rows as $row) {
            $created[] = $this->create($row);
        }

        return $created;
    }
}
