<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $buenosAiresId = DB::table('provinces')
            ->where('name', 'Buenos Aires')
            ->value('id');

        if (!$buenosAiresId) {
            $this->command->error('Provincia de Buenos Aires no existe. Ejecuta ProvinceSeeder primero.');
            return;
        }

        // Algunas ciudades/localidades de la Provincia de Buenos Aires para probar
        $cities = [
            // La Plata (capital)
            'La Plata',
            // Partido de La Matanza
            'San Justo',
            'Ramos Mejía',
            'González Catán',
            'Laferrere',
            // Partido de Lomas de Zamora
            'Lomas de Zamora',
            'Banfield',
            'Temperley',
            // Partido de Quilmes
            'Quilmes',
            'Bernal',
            // Partido de Almirante Brown
            'Adrogué',
            'Burzaco',
            // Partido de General San Martín
            'San Martín',
            // Partido de Avellaneda
            'Avellaneda',
            // Partido de Morón
            'Morón',
            // Partido de Tigre
            'Tigre',
            // Partido de San Isidro
            'San Isidro',
            // Partido de Vicente López
            'Vicente López',
            // Partido de Pilar
            'Pilar',
            // Partido de Escobar
            'Escobar',
        ];

        foreach ($cities as $name) {
            DB::table('cities')->updateOrInsert(
                ['province_id' => $buenosAiresId, 'name' => $name],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}