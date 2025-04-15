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
        Schema::create('gri_303_water', function (Blueprint $table) {
            $table->id('water_id');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->smallInteger('reporting_year');
            $table->decimal('water_withdrawn', 10, 2);
            $table->string('water_source_type');
            $table->decimal('water_discharge', 10, 2);
            $table->string('discharge_destination');
            $table->decimal('water_consumption', 10, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gri_303_water');
    }
};
