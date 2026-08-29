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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
                        $table->string('leave_type');
                        $table->text('reason');
                        $table->date('from_date');
                        $table->time('from_time')->nullable();
                        $table->date('to_date');
                        $table->time('to_time')->nullable();
                        $table->decimal('total_days', 5, 2)->default(0);
                        $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
                        $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
