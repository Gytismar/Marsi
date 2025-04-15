<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gri302Energy extends Model
{
    use HasFactory;

    protected $table = 'gri_302_energy';
    protected $primaryKey = 'energy_id';

    protected $fillable = [
        'company_id',
        'reporting_year',
        'total_energy_consumed',
        'renewable_energy_consumed',
        'nonrenewable_energy_consumed',
        'energy_consumed_unit',
        'energy_intensity',
        'reduction_achieved',
        'source',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
