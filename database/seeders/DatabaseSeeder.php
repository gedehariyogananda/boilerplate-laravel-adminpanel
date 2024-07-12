<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Campain;
use App\Models\HistoryCampain;
use App\Models\ReqCamp;
use App\Models\User;
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
        User::create([
            'name' => 'Gede Hari Yoga Nanda',
            'roles' => 'admin',
            'email' => 'gede@gmail.com',
            'password' => Hash::make('password'),
            'institusi' => 'PENS',
        ]);

        User::create([
            'name' => 'Handaru Dwiking',
            'roles' => 'user',
            'email' => 'handaru@gmail.com',
            'password' => Hash::make('password'),
            'institusi' => 'PENS',
        ]);
    }
}
