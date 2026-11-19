<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Recital',
            'Fiesta',
            'Obra de teatro',
            'Stand up',
            'Exposición',
            'Feria',
            'Charla',
            'Taller',
            'Festival',
            'Cine',
        ];

        foreach ($types as $name) {
            EventType::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}