<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'userId'            => 1,
                'apellidoPaterno'   => 'admin',
                'apellidoMaterno'   => 'admin',
                'nombres'           => 'admin',
                'tipoDocumentoId'   => null,
                'nroDocumento'      => '00000000',
                'fechaNacimiento'   => now(),
                'tipoSexoId'        => 1,
                'tipoContratoId'    => 1,
                'areaId'            => 1,
                'profesionId'       => 1,
                'cargoId'           => 1,
                'departamentoId'    => 1,
                'servicioId'        => 1
            ],
            [
                'userId'            => 2,
                'apellidoPaterno'   => 'manqrrique',
                'apellidoMaterno'   => 'aguirre',
                'nombres'           => 'Leonel',
                'tipoDocumentoId'   => 1,
                'nroDocumento'      => '11111111',
                'fechaNacimiento'   => now(),
                'tipoSexoId'        => 1,
                'tipoContratoId'    => 1,
                'profesionId'       => 5,
                'cargoId'           => 1,
                'areaId'            => 1,
                'departamentoId'    => 3,
                'servicioId'        => 4,
            ],
            [
                'userId'            => 3,
                'apellidoPaterno'   => 'puma',
                'apellidoMaterno'   => 'narvaes',
                'nombres'           => 'ernesto',
                'tipoDocumentoId'   => 1,
                'nroDocumento'      => '22222222',
                'fechaNacimiento'   => now(),
                'tipoSexoId'        => 1,
                'tipoContratoId'    => 1,
                'profesionId'       => 5,
                'cargoId'           => 1,
                'areaId'            => 1,
                'departamentoId'    => 3,
                'servicioId'        => 5,
            ],
            [
                'userId'            => 4,
                'apellidoPaterno'   => 'lampa',
                'apellidoMaterno'   => 'ignacio',
                'nombres'           => 'maria elen',
                'tipoDocumentoId'   => 1,
                'nroDocumento'      => '33333333',
                'fechaNacimiento'   => now(),
                'tipoSexoId'        => 1,
                'tipoContratoId'    => 1,
                'profesionId'       => 5,
                'cargoId'           => 1,
                'areaId'            => 1,
                'departamentoId'    => 3,
                'servicioId'        => 6,
            ],
        ];

        foreach ($data as $item) {
            Empleado::create($item);
        }
    }
}
