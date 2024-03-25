<?php

namespace Database\Seeders;

use App\Models\TipoSexo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['Masculino', 'Femenino'];

        foreach ($data as $item) {
            TipoSexo::create(['descripcion' => $item]);
        }
    }
}
