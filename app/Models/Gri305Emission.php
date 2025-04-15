<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gri305Emission extends Model
{
    use HasFactory;

    protected $table = 'gri_305_emissions';
    protected $primaryKey = 'emission_id';

    protected $fillable = [
        'company_id',
        'reporting_year',
        'scope_1',
        'scope_2',
        'scope_3',
        'ghg_intensity',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
