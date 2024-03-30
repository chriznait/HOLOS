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
            ],
            [
                'abrev' => 'T',
                'horas' => 6,
            ],
            [
                'abrev' => 'MT',
                'horas' => 12,
            ],
            [
                'abrev' => 'GD',
                'horas' => 12,
            ],
            [
                'abrev' => 'GN',
                'horas' => 12,
            ],
            [
                'abrev' => 'N',
                'horas' => 12,
            ],
            [
                'abrev' => 'MTN',
                'horas' => 18,
            ],
            [
                'abrev' => 'GDN',
                'horas' => 24,
            ],
        ];

        foreach ($datas as $item) {
            Turno::create($item);
        }
    }
}
