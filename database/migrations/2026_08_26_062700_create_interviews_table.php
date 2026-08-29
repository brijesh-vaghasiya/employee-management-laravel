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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
                        $table->string('education')->nullable();
                        $table->string('experience')->nullable();
                        $table->string('previous_company')->nullable();
                        $table->string('position');
                        $table->text('skills')->nullable();
                        $table->decimal('ctc', 10, 2)->nullable();
                        $table->decimal('expected_ctc', 10, 2)->nullable();
                        $table->string('cv_path')->nullable();
                        $table->date('interview_date');
                        $table->string('interviewer')->nullable();
                        $table->string('department')->nullable();
                        $table->string('status')->default('Scheduled'); // Scheduled, Completed, Hired, Rejected
                        $table->text('notes')->nullable();
                        $table->boolean('bg_approval')->default(false);
                        $table->boolean('edu_approval')->default(false);
                        $table->boolean('salary_approval')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
