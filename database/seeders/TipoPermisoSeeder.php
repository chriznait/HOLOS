<?php

namespace Database\Seeders;

use App\Models\TipoPermiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoPermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Comision de servicio', 'Razones de salud', 'Asunto particular', 'Refrigerio', 'otro'];

        foreach ($data as $item) {
            TipoPermiso::create(['descripcion' => $item]);
        }
    }
}
