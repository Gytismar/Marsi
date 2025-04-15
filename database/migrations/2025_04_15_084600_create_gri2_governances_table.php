<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gri_2_governance', function (Blueprint $table) {
            $table->id('governance_id');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->smallInteger('reporting_year');
            $table->text('governance_structure')->nullable();
            $table->integer('board_size')->nullable();
            $table->integer('independent_members')->nullable();
            $table->boolean('chair_is_executive')->nullable();
            $table->text('delegation_of_responsibility')->nullable();
            $table->string('reporting_frequency')->nullable();
            $table->boolean('board_review_of_esg')->nullable();
            $table->boolean('conflict_of_interest_policy')->nullable();
            $table->boolean('policy_code_of_ethics')->nullable();
            $table->text('ethics_advice_mechanism')->nullable();
            $table->text('report_misconduct_mechanism')->nullable();
            $table->integer('compliance_violations_count')->nullable();
            $table->decimal('compliance_fines_value', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gri_2_governance');
    }
};
