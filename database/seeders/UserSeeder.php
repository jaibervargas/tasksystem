<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de que el modelo esté importado
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Nombre del Usuario',
            'email' => 'usuario@example.com',
            'password' => Hash::make('contraseña123'), // Asegúrate de hashear la contraseña
        ]);
    }
}
