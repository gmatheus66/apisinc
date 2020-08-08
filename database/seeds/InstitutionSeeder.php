<?php

use Illuminate\Database\Seeder;
use App\Institution;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        Institution::create([
            'name' => 'CabelereiraLeila',
            'telephone' => $faker->regexify('[0-9]{5}[0-9]{4}'),
            'CNPJ' => $faker->regexify('[0-9]{5}[0-9]{6}'),
            'address' => 'Rua da Leila',
            'city' => 'InstitutionsCity',
            'country' => 'InstituionsPais',
            'state_province' => 'InstitutionsEstado',
            'zip' => $faker->regexify('[0-9]{5}[0-9]{3}'),
        ]);
    }
}
