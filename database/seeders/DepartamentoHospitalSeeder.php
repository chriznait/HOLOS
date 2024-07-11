<?php

namespace Database\Seeders;

use App\Models\DepartamentoHospital;
use App\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoHospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $departamentos = [
            [
                'descripcion' => 'Administración',
                'servicios' => [
                    [
                        'descripcion' => 'Administración',
                    ],
                ]
            ],
            [
                'descripcion' => 'Obstetricia',
                'servicios' => [
                    [
                        'descripcion' => 'Emergencia',
                    ],
                    [
                        'descripcion' => 'Hospitalizacion',
                    ],
                ]
            ],
            [
                'descripcion' => 'Enfermería',
                'servicios' => [
                    [
                        'descripcion' => 'Emergencia',
                    ],
                    [
                        'descripcion' => 'Hospitalizacion',
                    ],
                    [
                        'descripcion' => 'Consultorio Externo',
                    ],
                ]
            ],
        ];

        foreach ($departamentos as $item) {
            $departamento = DepartamentoHospital::create(['descripcion' => $item['descripcion']]);

            foreach ($item['servicios'] as $servicio) {
                Servicio::create(['descripcion' => $servicio['descripcion'], 'departamentoId' => $departamento->id]);
            }
        }
    }
}
