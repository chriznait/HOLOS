<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\RolMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = Menu::all();
        foreach ($menus as $menu) {

            $tieneHijos = Menu::where('parentId', $menu->id)->exists();
            $item = [
                'rolId' => 1,
                'menuId' => $menu->id,
            ];

            if($tieneHijos){
                $permisos = [
                    'ver' => 1,
                    'crear' => 0,
                    'editar' => 0,
                    'eliminar' => 0,
                ];
            }else{
                $permisos = [
                    'ver' => 1,
                    'crear' => 1,
                    'editar' => 1,
                    'eliminar' => 1,
                ];
            }

            RolMenu::create(array_merge($item, $permisos));
        }
    }
}
