<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'status' => 1, // Activo
            'user_id' => 1, // Valor por defecto
        ]);

        // Crear usuarios de prueba con rol empleado
        User::create([
            'name' => 'Employee One',
            'first_name' => 'Juan',
            'last_name' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'password' => Hash::make('password123'),
            'role' => 'empleado',
            'status' => 1, // Activo
            'user_id' => 2, // Valor por defecto
        ]);

        User::create([
            'name' => 'Employee Two',
            'first_name' => 'María',
            'last_name' => 'González',
            'email' => 'maria.gonzalez@example.com',
            'password' => Hash::make('password123'),
            'role' => 'empleado',
            'status' => 1, // Activo
            'user_id' => 3, // Valor por defecto
        ]);
    }
}
