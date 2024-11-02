<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVneduSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vnedu_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('sheet_name')->nullable();
            $table->unsignedBigInteger('vnedu_file_id')->nullable();
            $table->unsignedBigInteger('vnedu_subject_id')->nullable();
            $table->integer('sheet_index')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vnedu_sheets');
    }
}
