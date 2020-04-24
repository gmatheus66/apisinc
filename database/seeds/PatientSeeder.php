<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pats = factory(Patient::class, 10)->create();

        $faker = Faker\Factory::create();

        Patient::create([
            'name' => 'patient',
            'birthday' => $faker->dateTime(),
            'sex' => 'Female',
            'telephone' => $faker->regexify('[0-9]{5}[0-9]{4}'),
            'email' => 'patient@login.com',
            'occupation' => 'patientwork',
            'address' => 'rua patient',
            'city' => 'patientcity',
            'country' => 'patientPais',
            'state_province' => 'patientEstado',
            'zip' => $faker->regexify('[0-9]{5}[0-9]{3}'),
            'password' => Hash::make('password')
        ]);
    }
}
