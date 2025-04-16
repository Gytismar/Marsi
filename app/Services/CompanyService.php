<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class CompanyService extends Service
{
    protected function model(): Model
    {
        return new Company();
    }
}
