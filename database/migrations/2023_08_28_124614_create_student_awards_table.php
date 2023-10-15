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
        Schema::create('student_awards', function (Blueprint $table) {
            $table->bigIncrements('sa_id');
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('awardId');
            $table->smallInteger('grade_lvl');
            $table->date('date_awarded');
            $table->timestamps();


            $table->foreign('id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('awardId')->references('award_id')->on('awards')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_awards');
    }
};
