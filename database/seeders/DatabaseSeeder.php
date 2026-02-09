<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// IMPORTANTE: Añade esta línea para que Hash funcione
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
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

}
