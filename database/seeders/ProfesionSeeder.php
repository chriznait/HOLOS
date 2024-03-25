<?php

namespace Database\Seeders;

use App\Models\Profesion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'descripcion' => 'Ingeniero de Sistemas',
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
            Profesion::create($item);
        }
    }
}
