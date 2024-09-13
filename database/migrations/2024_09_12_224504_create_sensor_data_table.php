<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('sensor_data', function (Blueprint $table) {
        $table->id();
        $table->float('temperature');
        $table->float('humidity');
        $table->float('air_temperature');
        $table->float('process_temperature');
        $table->float('rotational_speed');
        $table->float('torque');
        $table->float('tool_wear');
        $table->float('lifecycle');
        $table->float('operational_time');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
