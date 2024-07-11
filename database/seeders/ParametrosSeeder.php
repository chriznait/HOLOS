<?php

namespace Database\Seeders;

use App\Models\Parametros;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParametrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datos = [
            [
                'descripcion' => 'nombre de institucion',
                'valor' => 'HOSPITAL ALTO INCLAN'
            ],
            [
                'descripcion' => 'direccion',
                'valor' => 'Av. las vegonias Nro 1547'
            ],
            [
                'descripcion' => 'Nro telefonico',
                'valor' => '966654874'
            ],
        ];
        foreach ($datos as $item) {
            Parametros::create($item);
        }
    }
}
