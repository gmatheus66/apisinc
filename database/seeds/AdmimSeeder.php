<?php

use Illuminate\Database\Seeder;
use App\Admim;

class AdmimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admim::create([
            'name' => 'admim',
            'email' => 'admim@login.com',
            'password' => Hash::make('password')
        ]);
    }
}
