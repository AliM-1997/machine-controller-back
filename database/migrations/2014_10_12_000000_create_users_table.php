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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable()->unique(); // Optional and unique
            $table->string('email')->unique(); // Required and unique
            $table->string('phone_number')->nullable()->unique(); // Optional and unique
            $table->timestamp('email_verified_at')->nullable(); // Optional
            $table->enum('role', ['admin', 'user'])->default('user'); // Default value
            $table->string('password'); // Required
            $table->string('confirmed_Password'); // Required
            $table->string('location')->nullable(); // Optional
            $table->string('image_path')->nullable(); // Optional
            $table->rememberToken(); // Optional
            $table->timestamps(); // Automatically managed by Laravel
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
