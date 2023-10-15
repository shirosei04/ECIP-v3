<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Hash;
class UserTableData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for($i=1; $i <= 100; $i++){
            $sexArray = array("a" => "Male", "b" => "Female");
            $randomSex =  array_rand($sexArray);
            
            $glArray = array("a" => "1", "b" => "2", "c" => "3", "d" => "4", "e" => "5", "f" => "6", "g" => "7", "h" => "8", "i" => "9", "j" => "10", "k" => "11", "l" => "12", "m" => "0");
            $randomLvl = array_rand($glArray);
            DB::table('users')->insert([
            'role' => 'Student',
            'is_verified' => '1',
            'date_of_registration' => now()->toDateString('Y-m-d'),
            'sex' => $sexArray[$randomSex],
            'first_name' => 'Student'.$i,
            'middle_name' => $i,
            'last_name' => $i,
            'suffix' => '',
            'birth_date' => now()->toDateString('Y-m-d'),
            'birth_place' => 'Bokod, Benguet',
            'region' => 'CAR',
            'province' => 'Benguet',
            'city' => 'Bokod',
            'barangay' => 'Jak-amo',
            'house_no' => $i,
            'nationality' => 'Filipino',
            'religion' => 'Scientology',
            'ethnicity' => 'Igorot',
            'mother_tongue' => 'Ibaloi',
            'cell_no' => '09123456789',
            'tel_no' => '1748945612',
            'email' => 'student'.$i.'@gmail.com',
            'fb_acc' => 'Student' ." " . $i,
            'email_verified_at' => now()->toDateString('Y-m-d'),
            'username' => 'Student' . "_" . $i,
            'password' => Hash::make('123456789'),
            'status' => '1',
            'created_at' => now()->toDateString('Y-m-d'),
            'updated_at' => now()->toDateString('Y-m-d'),
         
            ]);

            DB::table('student_details')->insert([
                'id' => $i,
                'lrn' => '1357160600'.$i,
                'past_school' => '',
                'past_school_address' => '',
                'past_school_id' => '',
                'has_comorbidity' => '0',
                'illnesses' => '',
                'vaccine_status' => 'Boosted',
                'hgfrl' => '1',
                'mogts' => '1',
                'is_madrasah_enrolled' => '0',
                'is_4ps_member' => '0',
                'grade_lvl' => $glArray[$randomLvl],
                'enrollment_status' => '0',
                'created_at' => now()->toDateString('Y-m-d'),
                'updated_at' => now()->toDateString('Y-m-d'),
                ]);
        
        }

        //principal
        DB::table('users')->insert([
            'role' => 'Principal',
            'is_verified' => '1',
            'date_of_registration' => now()->toDateString('Y-m-d'),
            'sex' => 'Male',
            'first_name' => 'Johndy Vladimir Grey Pendragon',
            'middle_name' => 'Abance',
            'last_name' => 'Sadac',
            'suffix' => '',
            'birth_date' => now()->toDateString('Y-m-d'),
            'birth_place' => 'Tuba, Benguet',
            'region' => 'CAR',
            'province' => 'Benguet',
            'city' => 'Tuba',
            'barangay' => 'Poblacion',
            'house_no' => '22',
            'nationality' => 'Filipino',
            'religion' => 'Christian',
            'ethnicity' => 'Igorot',
            'mother_tongue' => 'Ilocano',
            'cell_no' => '09158378703',
            'tel_no' => '0746193613',
            'email' => 'sadacjas101@gmail.com',
            'fb_acc' => 'Sadac Johndy',
            'email_verified_at' => now()->toDateString('Y-m-d'),
            'username' => 'sadac_johndy',
            'password' => Hash::make('ufo7music'),
            'status' => '1',
            'created_at' => now()->toDateString('Y-m-d'),
            'updated_at' => now()->toDateString('Y-m-d'),
        ]);
        //ao
        DB::table('users')->insert([
            'role' => 'Admission Officer',
            'is_verified' => '1',
            'date_of_registration' => now()->toDateString('Y-m-d'),
            'sex' => 'Male',
            'first_name' => 'Addison',
            'middle_name' => 'Matias',
            'last_name' => 'Madalang',
            'suffix' => '',
            'birth_date' => now()->toDateString('Y-m-d'),
            'birth_place' => 'Mt. Province, Benguet',
            'region' => 'CAR',
            'province' => 'Benguet',
            'city' => 'Mt. Province',
            'barangay' => 'Tadian',
            'house_no' => '130',
            'nationality' => 'Filipino',
            'religion' => 'Christian',
            'ethnicity' => 'Igorot',
            'mother_tongue' => 'Kankanaey',
            'cell_no' => '09123456789',
            'tel_no' => '0745612348',
            'email' => 'addison@gmail.com',
            'fb_acc' => 'Addison Matias Madalang',
            'email_verified_at' => now()->toDateString('Y-m-d'),
            'username' => 'madalang_addison',
            'password' => Hash::make('123456789'),
            'status' => '1',
            'created_at' => now()->toDateString('Y-m-d'),
            'updated_at' => now()->toDateString('Y-m-d'),
        ]);
        //student
        DB::table('users')->insert([
            'role' => 'Student',
            'is_verified' => '0',
            'date_of_registration' => now()->toDateString('Y-m-d'),
            'sex' => 'Female',
            'first_name' => 'Kaisser',
            'middle_name' => 'Binay-an',
            'last_name' => 'Bayas',
            'suffix' => '',
            'birth_date' => now()->toDateString('Y-m-d'),
            'birth_place' => 'Bokod, Benguet',
            'region' => 'CAR',
            'province' => 'Benguet',
            'city' => 'Bokod',
            'barangay' => 'Jak-amo',
            'house_no' => '451',
            'nationality' => 'Filipino',
            'religion' => 'Scientology',
            'ethnicity' => 'Igorot',
            'mother_tongue' => 'Ibaloi',
            'cell_no' => '09123456789',
            'tel_no' => '1748945612',
            'email' => 'kaisser@gmail.com',
            'fb_acc' => 'Kaisser Bayas',
            'email_verified_at' => now()->toDateString('Y-m-d'),
            'username' => 'bayas_kaisser',
            'password' => Hash::make('123456789'),
            'status' => '1',
            'created_at' => now()->toDateString('Y-m-d'),
            'updated_at' => now()->toDateString('Y-m-d'),
        ]);
        //teacher
        DB::table('users')->insert([
            'role' => 'Teacher',
            'is_verified' => '1',
            'date_of_registration' => now()->toDateString('Y-m-d'),
            'sex' => 'Male',
            'first_name' => 'Rhey Mon',
            'middle_name' => 'Agusto',
            'last_name' => 'Domine',
            'suffix' => '',
            'birth_date' => now()->toDateString('Y-m-d'),
            'birth_place' => 'Irisan, Benguet',
            'region' => 'CAR',
            'province' => 'Benguet',
            'city' => 'Irisan',
            'barangay' => 'Jak-amo',
            'house_no' => '458',
            'nationality' => 'Filipino',
            'religion' => 'Christian',
            'ethnicity' => 'Igorot',
            'mother_tongue' => 'Ilocano',
            'cell_no' => '09123456789',
            'tel_no' => '0748941482',
            'email' => 'rhey@gmail.com',
            'fb_acc' => 'Rhey Mon Domine',
            'email_verified_at' => now()->toDateString('Y-m-d'),
            'username' => 'domine_rhey',
            'password' => Hash::make('123456789'),
            'status' => '1',
            'created_at' => now()->toDateString('Y-m-d'),
            'updated_at' => now()->toDateString('Y-m-d'),
        ]);
        
    }
}
