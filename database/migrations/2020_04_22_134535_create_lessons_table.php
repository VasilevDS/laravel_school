<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->integer('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->integer('theme_id');
            $table->foreign('theme_id')->references('id')->on('themes');
            $table->integer('event_id');
            $table->foreign('event_id')->references('id')->on('events');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
