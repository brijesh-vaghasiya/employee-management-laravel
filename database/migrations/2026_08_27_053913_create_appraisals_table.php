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
        Schema::create('appraisals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('review_cycle_id')->constrained()->cascadeOnDelete();
            $table->text('self_review')->nullable();
            $table->text('manager_review')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->enum('status', ['Draft', 'Employee Submitted', 'Evaluated'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appraisals');
    }
};
