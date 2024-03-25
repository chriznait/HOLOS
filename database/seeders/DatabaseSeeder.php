<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\View\Components\RolMenuItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeed::class,
            TipoContratoSeeder::class,
            TipoSexoSeeder::class,
            TipoDocumentoSeeder::class,
            AreaSeeder::class,
            DepartamentoHospitalSeeder::class,
            ProfesionSeeder::class,
            CargoSeeder::class,
            MenuSeeder::class,
            EmpleadoSeeder::class,
            RolesSeeder::class,
            RolMenuSeeder::class,
            TipoPermisoSeeder::class,
            EstadoPermisoSeeder::class
        ]);
    }
}
