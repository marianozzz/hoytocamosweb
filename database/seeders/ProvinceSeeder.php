<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $argentinaId = DB::table('countries')->where('slug', 'argentina')->value('id');

        if (!$argentinaId) {
            $this->command->error('Argentina no existe. Ejecuta CountrySeeder primero.');
            return;
        }

        // 23 provincias + Ciudad Autónoma de Buenos Aires
        $provinces = [
            'Buenos Aires',
            'Ciudad Autónoma de Buenos Aires',
            'Catamarca',
            'Chaco',
            'Chubut',
            'Córdoba',
            'Corrientes',
            'Entre Ríos',
            'Formosa',
            'Jujuy',
            'La Pampa',
            'La Rioja',
            'Mendoza',
            'Misiones',
            'Neuquén',
            'Río Negro',
            'Salta',
            'San Juan',
            'San Luis',
            'Santa Cruz',
            'Santa Fe',
            'Santiago del Estero',
            'Tierra del Fuego, Antártida e Islas del Atlántico Sur',
            'Tucumán',
        ];

        foreach ($provinces as $name) {
            DB::table('provinces')->updateOrInsert(
                ['country_id' => $argentinaId, 'name' => $name],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}