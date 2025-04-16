<?php

namespace App\Services;

use App\Models\Gri306Waste;
use Illuminate\Database\Eloquent\Model;

class Gri306WasteService extends Service
{
    protected function model(): Model
    {
        return new Gri306Waste();
    }
}
