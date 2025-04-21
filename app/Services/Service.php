<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class Service
{
    abstract protected function model(): Model;

    public function getAll(): Collection
    {
        return $this->model()->newQuery()->get();
    }

    public function getById(int $id): Model
    {
        return $this->model()->newQuery()->findOrFail($id);
    }

    public function create(array $data): Model
    {
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
}
