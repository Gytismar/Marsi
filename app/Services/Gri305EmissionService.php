<?php

namespace App\Services;

use App\Models\Gri305Emission;
use Illuminate\Database\Eloquent\Model;

class Gri305EmissionService extends Service
{
    protected function model(): Model
    {
        return new Gri305Emission();
    }
}
