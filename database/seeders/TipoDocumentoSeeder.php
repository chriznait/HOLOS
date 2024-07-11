<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = ['DNI','Carnet de Extrangeria', 'Pasaporte', 'S/D'];

        foreach ($datas as $item) {
            TipoDocumento::create(['descripcion' => $item]);
        }
    }
}
