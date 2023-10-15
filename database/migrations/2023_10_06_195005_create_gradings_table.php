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
                ],
                [
                    'grading' => '2nd',
                ],
                [
                    'grading' => '3rd',
                ],
                [
                    'grading' => '4th',
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
