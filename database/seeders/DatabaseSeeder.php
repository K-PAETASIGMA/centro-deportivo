<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cancha;
use Spatie\Permission\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear Roles
        $admin = Role::create(['name' => 'admin']);
        $cliente = Role::create(['name' => 'cliente']);

        // 2. Crear Usuarios de prueba
        $userAdmin = User::factory()->create([
            'name' => 'Admin del Centro',
            'email' => 'admin@deportivo.com',
        ]);
        $userAdmin->assignRole($admin);

        $userCliente = User::factory()->create([
            'name' => 'Juan Perez',
            'email' => 'juan@gmail.com',
        ]);
        $userCliente->assignRole($cliente);

        // 3. Crear Canchas de ejemplo
        Cancha::create(['nombre' => 'Cancha de Fútbol 7', 'tipo' => 'fútbol', 'precio_por_hora' => 25.00]);
        Cancha::create(['nombre' => 'Cancha de Tenis Arcilla', 'tipo' => 'tenis', 'precio_por_hora' => 15.00]);
        Cancha::create(['nombre' => 'Cancha de Básquet Pro', 'tipo' => 'básquet', 'precio_por_hora' => 20.00]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
