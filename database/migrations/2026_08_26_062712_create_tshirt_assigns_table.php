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
        Schema::create('tshirt_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tshirt_id')->constrained('tshirts')->onDelete('cascade');
                        $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
                        $table->date('assigned_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tshirt_assigns');
    }
};
