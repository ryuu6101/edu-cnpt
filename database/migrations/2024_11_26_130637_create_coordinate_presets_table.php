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
        Schema::create('coordinate_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('department')->nullable();
            $table->string('school')->nullable();
            $table->string('class')->nullable();
            $table->string('semester')->nullable();
            $table->string('subject')->nullable();
            $table->string('starting_row')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinate_presets');
    }
};
