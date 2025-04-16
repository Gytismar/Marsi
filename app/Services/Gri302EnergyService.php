<?php

namespace App\Services;

use App\Models\Gri302Energy;
use Illuminate\Database\Eloquent\Model;

class Gri302EnergyService extends Service
{
    protected function model(): Model
    {
        return new Gri302Energy();
    }
}

