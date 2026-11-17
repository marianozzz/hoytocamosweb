<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        // Lista amplia de géneros, organizada por categorías para mantenerla legible.
        // El slug se genera automáticamente con Str::slug().
        $genres = [
            // Rock y derivados
            'Rock',
            'Rock Alternativo',
            'Indie Rock',
            'Punk',
            'Pop Punk',
            'Hardcore Punk',
            'Metal',
            'Heavy Metal',
            'Death Metal',
            'Black Metal',
            'Thrash Metal',
            'Nu Metal',
            'Grunge',
            'Post-Rock',
            'Shoegaze',
            'Garage Rock',
            'Rockabilly',
            'Psychobilly',
            'Stoner Rock',
            'Emo',
            'Math Rock',

            // Pop y afines
            'Pop',
            'Synthpop',
            'Dream Pop',
            'Indie Pop',
            'Electropop',
            'K-Pop',
            'J-Pop',
            'Latin Pop',

            // Electrónica
            'Electrónica',
            'House',
            'Deep House',
            'Techno',
            'Trance',
            'Dubstep',
            'Drum and Bass',
            'Ambient',
            'IDM',
            'Electro',
            'Chiptune',
            'Breakbeat',

            // Hip-Hop y urbanos
            'Hip-Hop',
            'Rap',
            'Trap',
            'Drill',
            'Boom Bap',
            'R&B',
            'Neo Soul',
            'Reggaeton',
            'Dembow',

            // Jazz y blues
            'Jazz',
            'Bebop',
            'Swing',
            'Fusion',
            'Smooth Jazz',
            'Blues',
            'Delta Blues',
            'Chicago Blues',

            // Folk y acústicos
            'Folk',
            'Folk Rock',
            'Country',
            'Bluegrass',
            'Acústico',
            'Cantautor',
            'Trova',

            // Latinos y del sur
            'Ska',
            'Reggae',
            'Dancehall',
            'Cumbia',
            'Cumbia Villera',
            'Salsa',
            'Merengue',
            'Bachata',
            'Tango',
            'Folklore',
            'Cuarteto',
            'Chamamé',
            'Bossa Nova',
            'Música Andina',

            // Soul, funk y derivados
            'Soul',
            'Funk',
            'Disco',
            'Gospel',

            // Clásica y experimental
            'Clásica',
            'Ópera',
            'Experimental',
            'Avant-Garde',
            'Noise',

            // Otros
            'World Music',
            'New Age',
            'Bandas Sonoras',
        ];

        foreach ($genres as $name) {
            DB::table('genres')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}