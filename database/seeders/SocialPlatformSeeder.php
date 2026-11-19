<?php

namespace Database\Seeders;

use App\Models\SocialPlatform;
use Illuminate\Database\Seeder;

class SocialPlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            [
                'name' => 'Instagram',
                'icon' => 'bi-instagram',
                'base_url' => 'https://instagram.com/',
            ],
            [
                'name' => 'Facebook',
                'icon' => 'bi-facebook',
                'base_url' => 'https://facebook.com/',
            ],
            [
                'name' => 'TikTok',
                'icon' => 'bi-tiktok',
                'base_url' => 'https://tiktok.com/@',
            ],
            [
                'name' => 'YouTube',
                'icon' => 'bi-youtube',
                'base_url' => 'https://youtube.com/@',
            ],
            [
                'name' => 'X (Twitter)',
                'icon' => 'bi-twitter-x',
                'base_url' => 'https://x.com/',
            ],
            [
                'name' => 'Spotify',
                'icon' => 'bi-spotify',
                'base_url' => 'https://open.spotify.com/artist/',
            ],
            [
                'name' => 'Bandcamp',
                'icon' => 'bi-music-note-beamed',
                'base_url' => 'https://bandcamp.com/',
            ],
            [
                'name' => 'SoundCloud',
                'icon' => 'bi-soundwave',
                'base_url' => 'https://soundcloud.com/',
            ],
            [
                'name' => 'WhatsApp',
                'icon' => 'bi-whatsapp',
                'base_url' => 'https://wa.me/',
            ],
            [
                'name' => 'Sitio web',
                'icon' => 'bi-globe',
                'base_url' => null,
            ],
        ];

        foreach ($platforms as $data) {
            SocialPlatform::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'icon' => $data['icon'],
                    'base_url' => $data['base_url'],
                    'active' => true,
                ]
            );
        }
    }
}