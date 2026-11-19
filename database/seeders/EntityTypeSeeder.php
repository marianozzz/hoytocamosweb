<?php

namespace Database\Seeders;

use App\Models\EntityType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EntityTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Banda',
            'Artista solista',
            'DJ',
            'Productor',
            'Pintor',
            'Ilustrador',
            'Poeta',
            'Fotógrafo',
            'Colectivo',
            'Sello discográfico',
        ];

        foreach ($types as $name) {
            EntityType::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}