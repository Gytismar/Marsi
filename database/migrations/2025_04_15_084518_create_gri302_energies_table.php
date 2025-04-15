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
        Schema::create('gri_302_energy', function (Blueprint $table) {
            $table->id('energy_id');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->smallInteger('reporting_year');
            $table->decimal('total_energy_consumed', 10, 2)->nullable();
            $table->decimal('renewable_energy_consumed', 10, 2);
            $table->decimal('nonrenewable_energy_consumed', 10, 2);
            $table->string('energy_consumed_unit');
            $table->decimal('energy_intensity', 10, 2)->nullable();
            $table->decimal('reduction_achieved', 10, 2)->nullable();
            $table->string('source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gri_302_energy');
    }
};
