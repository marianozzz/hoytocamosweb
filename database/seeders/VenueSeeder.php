<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar Mar del Plata (provincia de Buenos Aires)
        $marDelPlata = City::where('name', 'Mar del Plata')->first();

        // Si no existe, usamos cualquier ciudad de Buenos Aires como fallback
        if (!$marDelPlata) {
            $marDelPlata = City::where('name', 'La Plata')->first();
        }

        if (!$marDelPlata) {
            $this->command->error('No se encontró una ciudad para asignar los venues.');
            return;
        }

        $venues = [
            [
                'name' => 'Bar Botellas',
                'address' => 'Córdoba 1234',
                'description' => 'Bar clásico de la escena under, con escenario para bandas locales.',
            ],
            [
                'name' => 'Centro Cultural Nova',
                'address' => 'San Martín 567',
                'description' => 'Espacio cultural con sala principal, galería y patio.',
            ],
            [
                'name' => 'Café La Grieta',
                'address' => 'Belgrano 890',
                'description' => 'Café íntimo para acústicos y sesiones de autor.',
            ],
            [
                'name' => 'Espacio Cultural El Sótano',
                'address' => 'Rivadavia 432',
                'description' => 'Sótano con capacidad para 200 personas, ideal para recitales.',
            ],
            [
                'name' => 'Teatro Municipal',
                'address' => 'Luro 1234',
                'description' => 'Teatro histórico para obras, stand up y eventos culturales.',
            ],
        ];

        foreach ($venues as $data) {
            Venue::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'description' => $data['description'],
                    'city_id' => $marDelPlata->id,
                ]
            );
        }
    }
}