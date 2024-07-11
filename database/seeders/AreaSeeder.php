<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            [
                'id' => 1,
                'descripcion' => 'Administración'
            ],
            [
                'id' => 2,
                'descripcion' => 'Emergencia',
            ],
            [
                'id' => 3,
                'descripcion' => 'Hospitalización',
            ],
            [
                'id' => 4,
                'descripcion' => 'Consultorio Externo'
            ],
        ];
        /* DB::beginTransaction();
        DB::unprepared('SET IDENTITY_INSERT area ON'); */
        foreach ($areas as $item) {
            Area::create($item);
        }
        /* DB::unprepared('SET IDENTITY_INSERT area OFF');
        DB::commit(); */
    }
}
