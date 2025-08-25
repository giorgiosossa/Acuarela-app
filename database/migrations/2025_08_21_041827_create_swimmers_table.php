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
        Schema::create('swimmers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('skill_id')->nullable();
            $table->foreignId('group_id')->nullable();
            $table->string('review')->nullable();
            $table->string('complement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swimmers');
    }
};
