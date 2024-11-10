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
        Schema::table('scoreboards', function (Blueprint $table) {
            $table->string('tx5')->nullable();
            $table->string('ddggk')->nullable();
            $table->string('ddgck')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scoreboards', function (Blueprint $table) {
            $table->dropColumn('tx5');
            $table->dropColumn('ddggk');
            $table->dropColumn('ddgck');
        });
    }
};
