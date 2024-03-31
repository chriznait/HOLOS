<?php

namespace Database\Seeders;

use App\Models\Turno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'abrev' => 'M',
                'horas' => 6,
                'descripcion' => 'Mañana'
            ],
            [
                'abrev' => 'T',
                'horas' => 6,
                'descripcion' => 'Tarde'
            ],
            [
                'abrev' => 'MT',
                'horas' => 12,
                'descripcion' => 'Mañana y tarde'
            ],
            [
                'abrev' => 'GD',
                'horas' => 12,
                'descripcion' => 'Guardia dia'
            ],
            [
                'abrev' => 'GN',
                'horas' => 12,
                'descripcion' => 'Guardia noche'
            ],
            [
                'abrev' => 'N',
                'horas' => 12,
                'descripcion' => 'Noche'
            ],
            [
                'abrev' => 'MTN',
                'horas' => 24,
                'descripcion' => 'Mañana, tarde y noche'
            ],
            [
                'abrev' => 'GDN',
                'horas' => 24,
                'descripcion' => 'Guardia dia y guardia noche'
            ],
        ];

        foreach ($datas as $item) {
            Turno::create($item);
        }
    }
}
