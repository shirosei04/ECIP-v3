<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('subject_id');
            $table->string('subject_name');
            $table->unsignedBigInteger('curriculumId');
            $table->string('subject_grade_lvl');
            $table->string('track');

            $table->foreign('curriculumId')->references('curriculum_id')->on('curriculums')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};
