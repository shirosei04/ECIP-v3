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
        Schema::create('tuition_fees', function (Blueprint $table) {
            $table->bigIncrements('tf_id');
            $table->string('for_grade_lvl');
            $table->float('tuition_fee', 10, 2);
            $table->float('misc_fee', 10, 2);
            $table->timestamps();
        });

        DB::table('tuition_fees')->insert(
            array(
                [
                    'for_grade_lvl' =>  '0',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '1',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '2',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '3',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '4',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '5',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '6',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '7',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '8',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '9',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '10',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '11',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
                ],
                [
                    'for_grade_lvl' =>  '12',
                    'tuition_fee' => '0',
                    'misc_fee' => '0',
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
        Schema::dropIfExists('tuition_fees');
    }
};
