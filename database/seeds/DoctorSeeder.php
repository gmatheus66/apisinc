<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Doctor;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        Doctor::create([
            'name' => 'doctor',
            'email' => 'doctor@login.com',
            'crm' => $faker->regexify('([0-9]{4})-([A-Z]{2})'),
            'specialization' => 'Clinico Geral',
            'password' => Hash::make('password')
        ]);
        
    }
}
