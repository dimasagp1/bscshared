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
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->string('period', 7)->unique(); // YYYY-MM
            $table->enum('status', ['OPEN', 'CLOSED'])->default('OPEN');
            $table->decimal('apex_score', 5, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('financial_ratios', function (Blueprint $table) {
            $table->id();
            $table->string('period', 7);
            $table->string('category', 50); // Likuiditas, Solvabilitas, Aktivitas, Profitabilitas, Produktivitas
            $table->string('ratio_name', 100);
            $table->decimal('target', 10, 2)->default(0);
            $table->decimal('actual', 10, 2)->default(0);
            $table->decimal('achievement_pct', 5, 2)->default(0);
            $table->string('status', 50)->default('Waspada');
            $table->timestamps();
        });

        Schema::create('department_objectives', function (Blueprint $table) {
            $table->id();
            $table->string('period', 7);
            $table->string('dept_code', 30); // PROD, QC, FIN, HRD, dll.
            $table->string('kpi_code', 50);
            $table->string('kpi_name', 255);
            $table->string('polarity', 20)->default('Naik'); // Naik, Turun, Rentang
            $table->decimal('target', 10, 2)->default(0);
            $table->decimal('actual', 10, 2)->default(0);
            $table->decimal('achievement_pct', 5, 2)->default(0);
            $table->string('status', 50)->default('Waspada'); // Tercapai, Waspada, Di Bawah Target
            $table->timestamps();
        });

        Schema::create('action_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_objective_id')->nullable()->constrained('department_objectives')->onDelete('cascade');
            $table->string('title', 255);
            $table->string('owner_dept', 30);
            $table->integer('progress_pct')->default(0); // 0-100%
            $table->string('status', 50)->default('On Progress'); // On Progress, Completed, Off-Target
            $table->timestamps();
        });

        Schema::create('staging_logs', function (Blueprint $table) {
            $table->id();
            $table->string('period', 7);
            $table->string('dept_code', 30);
            $table->string('idempotency_key', 120)->unique();
            $table->string('status', 50)->default('DELIVERED'); // DELIVERED, SCORED, ERROR, SUPERSEDED
            $table->integer('source_version')->default(1);
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staging_logs');
        Schema::dropIfExists('action_plans');
        Schema::dropIfExists('department_objectives');
        Schema::dropIfExists('financial_ratios');
        Schema::dropIfExists('periods');
    }
};
