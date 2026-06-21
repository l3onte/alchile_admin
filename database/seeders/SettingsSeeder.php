<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->updateOrInsert(
            ['id' => 1],
            [ 
                'bussines_name' => 'Al Chile',
                'email' => 'alchile@gmail.com',
                'phone' => '123456',
                'address' => 'Barrio Guadalupe',
                'logo_path' => 'logos/logo_default.png',
                'currency' => 'NIO',
                'website' => 'https://alchile.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
