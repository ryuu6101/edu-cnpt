<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('id_code')->nullable();
            $table->string('student_code')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('school_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->boolean('is_error')->default(false);
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
        Schema::dropIfExists('students');
    }
}
