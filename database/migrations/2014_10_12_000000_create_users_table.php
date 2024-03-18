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
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('ul')->nullable();
            $table->enum('status', ['Enabled', 'Disabled'])->nullable();
            $table->integer('view')->nullable();
            $table->foreignId('group_id')->index()->nullable();
            $table->foreignId('state_id')->index()->nullable();
            $table->string('state', 50);
            $table->string('role', 50);
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_logout')->nullable();
            $table->timestamps();
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
