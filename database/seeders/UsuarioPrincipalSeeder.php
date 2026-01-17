<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuarioPrincipalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Roles (si no existen)
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleCliente = Role::firstOrCreate(['name' => 'cliente']);

        // 2. Crear Usuario Administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin Sistema',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole($roleAdmin);

        // 3. Crear Usuario Cliente
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@test.com'],
            [
                'name' => 'Juan Cliente',
                'password' => Hash::make('cliente123'),
            ]
        );
        $cliente->assignRole($roleCliente);

        $this->command->info('Usuarios de prueba creados con éxito.');
    }
}
