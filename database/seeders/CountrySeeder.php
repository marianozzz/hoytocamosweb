<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('countries')->updateOrInsert(
            ['slug' => 'argentina'],
            [
                'name' => 'Argentina',
                'code' => 'AR',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}