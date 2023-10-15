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
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('sched_id');
            $table->unsignedBigInteger('sub_id');
            $table->string('semester');
            $table->string('days');
            $table->string('time_start');
            $table->string('time_end');
            $table->unsignedBigInteger('id')->nullable();
            $table->unsignedBigInteger('sect_id');
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('room_id')->nullable();
            
            $table->foreign('sub_id')->references('subject_id')->on('subjects')->onDelete('restrict');
            $table->foreign('id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('sect_id')->references('section_id')->on('sections')->onDelete('restrict');
            $table->foreign('year_id')->references('sy_id')->on('school_years')->onDelete('restrict');
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
