<?php

namespace App\Services;

use App\Models\Gri2Governance;
use Illuminate\Database\Eloquent\Model;

class Gri2GovernanceService extends Service
{
    protected function model(): Model
    {
        return new Gri2Governance();
    }
}
