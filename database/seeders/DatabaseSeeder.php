<?php

namespace Database\Seeders;

use App\Models\User;
<<<<<<< HEAD
use Illuminate\Database\Seeder;
// IMPORTANTE: Añade esta línea para que Hash funcione
use Illuminate\Support\Facades\Hash;
=======
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
<<<<<<< HEAD
   public function run(): void
{
    \App\Models\User::updateOrCreate(
        ['email' => 'test@example.com'], // Busca por email
        [
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'fecha_nacimiento' => '2000-01-01',
            'genero' => 'hombre',
            'numero_telefono' => '000000000',
        ]
    );

    \App\Models\User::updateOrCreate(
        ['email' => 'cabrerajosedaniel89@gmail.com'],
        [
            'name' => 'Daniel',
            'password' => Hash::make('4567Famara'),
            'fecha_nacimiento' => '1989-01-01',
            'genero' => 'hombre',
            'numero_telefono' => '600000000',
        ]
    );
}

=======
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
}
