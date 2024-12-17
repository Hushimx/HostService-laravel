<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors')->insert([
            'name' => 'mahmoud',
            'email' => 'hguhfdsa@gmail.com',
            'password' => Hash::make('omegalolo1'),
            'phoneNo' => '01202163639',
            'updatedAt' => '2024-12-17 17:38:44.5',
            'address' => 'adasdas adsadasd',
            'cityId' => 1,
        ]);

        // DB::table('users')->insert([
        //     'firstName' => 'mahmoud',
        //     'lastName' => 'yousry',
        //     'countryId' => 1,
        //     'updatedAt' => '2024-12-17 17:38:44.5',
        //     'role' => 'SUPER_ADMIN',
        //     'email' => 'hguhfdsa@gmail.com',
        //     'hash' => Hash::make('omegalolo1'),
        // ]);
    }
}
