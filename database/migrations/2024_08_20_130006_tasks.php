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
        
            Schema::create('tasks', function (Blueprint $table) {
                $table->id(); 
                $table->foreignId("user_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
                $table->string('machine_serial_number');
                $table->foreign('machine_serial_number')->references('serial number')->on('machines')->onUpdate('cascade')->onDelete('cascade');
                $table->text('jobDescription'); 
                $table->date('assignedDate'); 
                $table->date('dueDate');
                $table->string("location");
                $table->timestamps(); 
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');

    }
};
