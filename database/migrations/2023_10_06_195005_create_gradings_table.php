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
        Schema::create('gradings', function (Blueprint $table) {
            $table->bigIncrements('grading_id');
            $table->string('grading');
            $table->boolean('status')->default('0');
        });

        DB::table('gradings')->insert(
            array(
                [
                    'grading' => '1st',
                    'status' => '1'
                ],
                [
                    'grading' => '2nd',
                    'status' => '0'
                ],
                [
                    'grading' => '3rd',
                    'status' => '0'
                ],
                [
                    'grading' => '4th',
                    'status' => '0'
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gradings');
    }
};
