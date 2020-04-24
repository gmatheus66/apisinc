<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'birthday' => $faker->dateTime(),
        'sex' => $faker->randomElement(['Male', 'Female', 'Another']),
        'telephone' => $faker->randomNumber(8),
        'email' => $faker->unique()->safeEmail,
        'occupation' => $faker->text(45),
        'address' => $faker->streetName,
        'city' => $faker->city,
        'country' => $faker->country,
        'state_province' => $faker->state,
        'zip' => $faker->randomNumber(8),
        'password' => Hash::make('password'),

    ];
});
