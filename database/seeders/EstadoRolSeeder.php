<?php

namespace Database\Seeders;

use App\Models\EstadoRol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoRolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'descripcion' => 'Pendiente', 
                'class' => 'badge rounded-pill badge-light-secondary me-1'
            ],
            [
                'descripcion' => 'Aprobado',
                'class' => 'badge rounded-pill badge-light-success me-1'
            ],
            [
                'descripcion' =>  'Rechazado',
                'class' => 'badge rounded-pill badge-light-danger me-1'
            ]
        ];

        foreach ($data as $item) {
            EstadoRol::create($item);
        }
    }
}
