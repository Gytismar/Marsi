<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CompanyService extends Service
{
    protected function model(): Model
    {
        return new Company();
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model()->newQuery()
            ->where('user_id', Auth::id())
            ->get();
    }

    public function getById(int $id): \Illuminate\Database\Eloquent\Model
    {
        return $this->model()->newQuery()
            ->where('user_id', Auth::id())
            ->findOrFail($id);
    }

    public function create(array $data): \Illuminate\Database\Eloquent\Model
    {
        $data['user_id'] = Auth::id();
        return $this->model()->newQuery()->create($data);
    }
}
