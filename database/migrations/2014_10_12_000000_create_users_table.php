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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role');
            $table->boolean('is_verified');
            $table->date('date_of_registration');
            $table->string('sex');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('region');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('house_no');
            $table->string('nationality');
            $table->string('religion');
            $table->string('ethnicity');
            $table->string('mother_tongue');
            $table->string('cell_no')->nullable();
            $table->string('tel_no')->nullable();
            $table->string('email')->unique();
            $table->string('fb_acc')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username');
            $table->string('password');
            $table->boolean('status')->default('1');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
