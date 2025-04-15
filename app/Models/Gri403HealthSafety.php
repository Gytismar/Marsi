<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gri403HealthSafety extends Model
{
    use HasFactory;

    protected $table = 'gri_403_health_safety';
    protected $primaryKey = 'health_safety_id';

    protected $fillable = [
        'company_id',
        'reporting_year',
        'total_workforce',
        'incidents_of_injury',
        'lost_days',
        'fatalities',
        'health_safety_training',
        'management_system_coverage',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

