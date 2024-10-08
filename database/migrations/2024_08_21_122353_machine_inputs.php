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
        Schema::create('machine_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('operating_time', 10, 2); 
            $table->decimal('down_time', 10, 2); 
            $table->decimal('number_of_failure', 10, 2);
            $table->decimal('actual_output', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_inputs');
    }
};
