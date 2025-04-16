<?php

namespace App\Services;

use App\Models\Gri403HealthSafety;
use Illuminate\Database\Eloquent\Model;

class Gri403HealthSafetyService extends Service
{
    protected function model(): Model
    {
        return new Gri403HealthSafety();
    }
}
