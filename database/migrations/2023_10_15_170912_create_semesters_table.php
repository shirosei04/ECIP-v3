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
        Schema::create('semesters', function (Blueprint $table) {
            $table->bigIncrements('sem_id');
            $table->string('semester');
            $table->boolean('sem_status')->default('0');
        });

        DB::table('semesters')->insert(
            array(
                [
                    'semester' => '1st',
                ],
                [
                    'semester' => '2nd',
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
        Schema::dropIfExists('semesters');
    }
};
