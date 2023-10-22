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
            $table->boolean('is_verified')->default('0');
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

        DB::table('users')->insert(
            array(
                [
                    'role' => 'Principal',
                    'is_verified' => '1',
                    'date_of_registration' => now()->toDateString('Y-m-d'),
                    'sex' => 'Male',
                    'first_name' => 'Johndy',
                    'middle_name' => 'Abance',
                    'last_name' => 'Sadac',
                    'suffix' => 'Abance',
                    'birth_date' => '2001-05-03',
                    'birth_place' => 'Tuba, Benguet',
                    'region' => 'CAR',
                    'city' => 'Tuba',
                    'province' => 'Benguet',
                    'barangay' => 'Poblacion',
                    'house_no' => '22',
                    'nationality' => 'Filipino',
                    'religion' => 'Christianity',
                    'ethnicity' => 'Igorot',
                    'mother_tongue' => 'Ilocano',
                    'cell_no' => '09123456789',
                    'tel_no' => '0746193613',
                    'email' => 'sadacpogi@gmail.com',
                    'fb_acc' => 'Sadac Johndy',
                    'username' => 'sadac_johndy',
                    'password' => Hash::make('123456789'),
                ],
                [
                    'role' => 'Admission Officer',
                    'is_verified' => '1',
                    'date_of_registration' => now()->toDateString('Y-m-d'),
                    'sex' => 'Male',
                    'first_name' => 'Addison',
                    'middle_name' => 'Matias',
                    'last_name' => 'Madalang',
                    'suffix' => '',
                    'birth_date' => '1998-06-15',
                    'birth_place' => 'Mt. Province, Benguet',
                    'region' => 'CAR',
                    'city' => 'MT. Province',
                    'province' => 'Benguet',
                    'barangay' => 'Tadian',
                    'house_no' => '69',
                    'nationality' => 'Filipino',
                    'religion' => 'Christianity',
                    'ethnicity' => 'Igorot',
                    'mother_tongue' => 'Kankana-ey',
                    'cell_no' => '09123456789',
                    'tel_no' => '0745698458',
                    'email' => 'dangkaw@gmail.com',
                    'fb_acc' => 'Addison Madalang',
                    'username' => 'madalang_addison',
                    'password' => Hash::make('123456789'),
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
        Schema::dropIfExists('users');
    }
};
