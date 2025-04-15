<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'industry',
        'country',
        'size',
    ];

    public function gri302Energy(): HasMany
    {
        return $this->hasMany(Gri302Energy::class, 'company_id');
    }

    public function gri303Water(): HasMany
    {
        return $this->hasMany(Gri303Water::class, 'company_id');
    }

    public function gri305Emissions(): HasMany
    {
        return $this->hasMany(Gri305Emission::class, 'company_id');
    }

    public function gri306Waste(): HasMany
    {
        return $this->hasMany(Gri306Waste::class, 'company_id');
    }

    public function gri403HealthSafety(): HasMany
    {
        return $this->hasMany(Gri403HealthSafety::class, 'company_id');
    }

    public function gri2Governance(): HasMany
    {
        return $this->hasMany(Gri2Governance::class, 'company_id');
    }
}

