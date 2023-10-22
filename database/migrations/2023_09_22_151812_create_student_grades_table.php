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
        Schema::create('student_grades', function (Blueprint $table) {
            $table->bigIncrements('sg_id');
            $table->unsignedBigInteger('stud_id');
            $table->unsignedBigInteger('schedule_id');
            $table->string('frst_grade')->nullable();
            $table->string('scnd_grade')->nullable();
            $table->string('thrd_grade')->nullable();
            $table->string('frth_grade')->nullable();
            $table->boolean('view_status')->default(1);

            $table->foreign('stud_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('schedule_id')->references('sched_id')->on('schedules')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_grades');
    }
};
