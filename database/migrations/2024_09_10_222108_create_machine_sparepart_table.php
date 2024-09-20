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
        Schema::create('machine_spare_parts', function (Blueprint $table) {
            $table->id();
            $table->string('machine_serial_number');
            $table->string('spare_part_serial_number');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('machine_serial_number')
                  ->references('serial_number')
                  ->on('machines')
                  ->onDelete('cascade');

            $table->foreign('spare_part_serial_number')
                  ->references('serial_number')
                  ->on('spare_parts')
                  ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_sparepart');
    }
};
