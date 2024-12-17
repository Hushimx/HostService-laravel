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
        DB::table('vendor')->insert([
            'name' => 'mahmoud',
            'email' => 'hguhfda@gmail.com',
            'password' => Hash::make('password'),
            'phoneNo' => '01202163639',
            'address' => 'adasdas adsadasd',
            'cityId' => 1,
        ]);
    }
}
