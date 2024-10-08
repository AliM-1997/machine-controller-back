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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('serial_number')->unique();
            $table->enum('status', ['active', 'under maintenance', 'attention'])->default('active');
            $table->string('location')->nullable();
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->date('last_maintenance');
            $table->integer('unit_per_hour')->default(0);
            $table->unsignedDecimal('operating_time', 8, 2)->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
