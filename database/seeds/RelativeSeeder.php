<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Relative;

class RelativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        Relative::create([
            'name' => 'relative',
            'birthday' => $faker->dateTime(),
            'sex' => 'Male',
            'telephone' => $faker->regexify('[0-9]{5}[0-9]{4}'),
            'email' => 'relative@login.com',
            'occupation' => 'relativework',
            'address' => 'rua relative',
            'city' => 'relativecity',
            'country' => 'relativePais',
            'state_province' => 'relativeEstado',
            'zip' => $faker->regexify('[0-9]{5}[0-9]{3}'),
            'password' => Hash::make('password')
        ]);
    }
}
