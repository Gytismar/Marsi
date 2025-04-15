<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gri2Governance extends Model
{
    use HasFactory;

    protected $table = 'gri_2_governance';
    protected $primaryKey = 'governance_id';

    protected $fillable = [
        'company_id',
        'reporting_year',
        'governance_structure',
        'board_size',
        'independent_members',
        'chair_is_executive',
        'delegation_of_responsibility',
        'reporting_frequency',
        'board_review_of_esg',
        'conflict_of_interest_policy',
        'policy_code_of_ethics',
        'ethics_advice_mechanism',
        'report_misconduct_mechanism',
        'compliance_violations_count',
        'compliance_fines_value',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

