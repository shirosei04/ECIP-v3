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
        Schema::create('advisers', function (Blueprint $table) {
            $table->bigIncrements('adviser_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('tyear_id');
            $table->unsignedBigInteger('tsection_id');

            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('tyear_id')->references('sy_id')->on('school_years')->onDelete('restrict');
            $table->foreign('tsection_id')->references('section_id')->on('sections')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advisers');
    }
};
