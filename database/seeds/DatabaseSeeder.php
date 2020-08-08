<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            InstitutionSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            RelativeSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
