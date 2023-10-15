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
        Schema::create('audits', function (Blueprint $table) {
            $table->bigIncrements('audit_id');
            $table->unsignedBigInteger('transaction_id');
            $table->string('transaction_description');
            $table->float('transaction_amount', 10, 2);
            $table->date('transaction_date');
            $table->string('transaction_type');
            $table->timestamps();

            $table->foreign('transaction_id')->references('studfee_id')->on('student_fees')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audits');
    }
};
