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
        Schema::create('jets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model');
            $table->unsignedSmallInteger('capacity');
            $table->unsignedSmallInteger('hourly_rate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jets');
    }
};
