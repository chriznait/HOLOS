<?php

namespace Database\Seeders;

use App\Models\TipoContrato;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['CAS', 'Nombrado', 'Tercero'];

        foreach ($data as $item) {
            TipoContrato::create(['descripcion' => $item]);
        }
    }
}
