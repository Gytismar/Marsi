<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gri303Water extends Model
{
    use HasFactory;

    protected $table = 'gri_303_water';

    protected $fillable = [
        'company_id',
        'reporting_year',
        'water_withdrawn',
        'water_discharge',
        'discharge_destination',
        'water_consumption',
        'water_recycled',
        'unit',
        'source',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
