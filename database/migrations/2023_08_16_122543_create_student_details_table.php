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
        Schema::create('student_details', function (Blueprint $table) {
            $table->bigIncrements('detail_id');
            $table->unsignedBigInteger('id');
            $table->string('lrn');
            $table->string('past_school')->nullable();
            $table->string('past_school_address')->nullable();
            $table->string('past_school_id')->nullable();
            $table->boolean('has_comorbidity');
            $table->string('illnesses')->nullable();
            $table->string('vaccine_status');
            $table->boolean('hgfrl'); //has_guardian_for_remote_learning
            $table->string('mogts'); //method of going to school
            $table->boolean('is_madrasah_enrolled'); 
            $table->boolean('is_4ps_member'); 
            $table->smallInteger('grade_lvl'); 
            $table->boolean('enrollment_status')->default('0');
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_details');
    }
};
