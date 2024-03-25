<?php

namespace Database\Seeders;

use App\Models\EstadoPermiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoPermisoSeeder extends Seeder
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
            ],
            [
                'descripcion' =>  'Activo',
                'class' => 'badge rounded-pill badge-light-primary me-1'
            ],
            [
                'descripcion' =>  'Finalizado',
                'class' => 'badge rounded-pill badge-light-dark me-1'
            ],
            [
                'descripcion' =>  'Anulado',
                'class' => 'badge rounded-pill badge-light-warning me-1'
            ],
        ];

        foreach ($data as $item) {
            EstadoPermiso::create($item);
        }
    }
}
