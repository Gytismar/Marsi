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
        Schema::create('gri_306_waste', function (Blueprint $table) {
            $table->id('waste_id');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->smallInteger('reporting_year');
            $table->decimal('total_waste_generated', 10, 2);
            $table->decimal('hazardous_waste_generated', 10, 2);
            $table->decimal('nonhazardous_waste_generated', 10, 2);
            $table->decimal('waste_recycled', 10, 2);
            $table->decimal('waste_disposed', 10, 2);
            $table->string('disposal_method');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gri_306_waste');
    }
};
