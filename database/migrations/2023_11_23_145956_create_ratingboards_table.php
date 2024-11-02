<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratingboards', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('semester_id')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('school_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->unsignedInteger('student_id')->nullable();
            $table->string('tu_quan')->nullable();
            $table->string('hop_tac')->nullable();
            $table->string('tu_hoc')->nullable();
            $table->string('cham_hoc')->nullable();
            $table->string('tu_tin')->nullable();
            $table->string('trung_thuc')->nullable();
            $table->string('doan_ket')->nullable();
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
        Schema::dropIfExists('ratingboards');
    }
}
