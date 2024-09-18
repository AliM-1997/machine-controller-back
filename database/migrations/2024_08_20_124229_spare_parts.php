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
        Schema::create('spare_Parts' ,function(Blueprint $table){
            $table->id();
            $table->string("name");
            $table->string("serial_number")->unique();
            $table->integer("quantity")->default(0);
            $table->text("description")->nullable();
            $table->string("image_path")->nullable();
            $table->enum('type', ['Mechanical', 'Electrical','Oil']);  
            $table->decimal('standard_pressure', 8, 2)->nullable(); 
            $table->integer('life_cycle')->nullable();              
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spare_Parts');
    }
};
