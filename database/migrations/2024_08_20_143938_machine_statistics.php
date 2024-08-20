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
        Schema::create('machine_Statistics', function(Blueprint $table){
            $table->id();
            $table->foreignId("machine_id")->constrained()->onDelete("cascade")->onUpdate("cascade");
            $table->decimal("operational_hours",10,2);
            $table->decimal("MTTR",10,2);
            $table->decimal("MTTD",10,2);
            $table->decimal("MTBF",10,2);
            $table->decimal("upTime",10,2);
            $table->decimal("downTime",10,2);
            $table->decimal("efficiency",10,2);
            $table->decimal("availability",10,2);
            $table->date("date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_Statistics');
    }
};
