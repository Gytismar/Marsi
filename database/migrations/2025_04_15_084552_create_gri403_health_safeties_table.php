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
        Schema::create('gri_403_health_safety', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->smallInteger('reporting_year');
            $table->integer('total_workforce');
            $table->integer('incidents_of_injury');
            $table->integer('lost_days');
            $table->integer('fatalities')->nullable();
            $table->decimal('health_safety_training', 10, 2);
            $table->string('management_system_coverage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gri_403_health_safety');
    }
};
