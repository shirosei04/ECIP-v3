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
        Schema::create('student_fees', function (Blueprint $table) {
            $table->bigIncrements('studfee_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('year_id');
            $table->string('payment_desc');
            $table->float('payment_amount', 10, 2);
            $table->string('payment_type');
            $table->date('payment_date');
            $table->float('running_balance', 10, 2);
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('year_id')->references('sy_id')->on('school_years')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_fees');
    }
};
