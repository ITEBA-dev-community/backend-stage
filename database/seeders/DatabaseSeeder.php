<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'nim' => 1,
            'username' => 'chrys',
            'email' => 'chrys@gmail.com',
            'password' => Hash::make('password'),
        ]);

        \App\Models\User::create([
            'nim' => 2,
            'username' => 'virgo',
            'email' => 'virgo@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
