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
        Schema::create('machineStatistics', function(Blueprint $table){
            $table->id();
            $table->string("machine_name");
            $table->foreign("machine_name")->references("name")->on("machines")->onUpdate("cascade")->onDelete("cascade");
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machinStatistics');
    }
};
