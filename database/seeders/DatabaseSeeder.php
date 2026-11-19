<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario de prueba
           User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password'  => 123456789,
            ]);
        

        // 1. Roles y permisos (primero, para que exista el rol admin)
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // 2. Usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@hoytocamos.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // 3. Datos geográficos y musicales
        $this->call([
            GenreSeeder::class,
            CountrySeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            EventTypeSeeder::class,
            VenueSeeder::class,
            SocialPlatformSeeder::class,
            EntityTypeSeeder::class,
        ]);
    }
}