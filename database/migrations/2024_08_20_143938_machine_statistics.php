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
        Schema::create('machine_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('MTTR', 10, 2)->nullable();               // down time / number of failure
            $table->decimal('MTBF', 10, 2)->nullable();               // total operating time / number of failure
            // $table->decimal('MTTD', 10, 2);                        // total detection time / number of failure
            $table->decimal('availability', 10, 2)->nullable();       // MTBF / MTBF + MTBR
            $table->decimal('upTime', 10, 2)->nullable();             // operating time * availability
            $table->decimal('efficiency', 10, 2)->nullable();         // actual output / theoretical output * 100
            $table->date('date');
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
