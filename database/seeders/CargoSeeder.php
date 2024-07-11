<?php

namespace Database\Seeders;

use App\Models\Cargo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'descripcion' => 'Ing. de Sistemas',
            ],
            [
                'descripcion' => 'Medico Especialista',
            ],
            [
                'descripcion' => 'Enfermero',
            ],
            [
                'descripcion' => 'Tenico en Enfermeria',
            ],
            [
                'descripcion' => 'Obstetra',
            ],
        ];

        foreach ($data as $item) {
            Cargo::create($item);
        }
    }
}
