<?php

namespace App\Services;

use App\Models\Gri303Water;
use Illuminate\Database\Eloquent\Model;

class Gri303WaterService extends Service
{
    protected function model(): Model
    {
        return new Gri303Water();
    }
}

