<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gri306Waste extends Model
{
    use HasFactory;

    protected $table = 'gri_306_waste';

    protected $fillable = [
        'company_id',
        'reporting_year',
        'total_waste_generated',
        'hazardous_waste_generated',
        'nonhazardous_waste_generated',
        'waste_recycled',
        'waste_disposed',
        'disposal_method',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

