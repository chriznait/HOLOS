<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Inicio',
                'routeName' => 'inicio',
                'slug' => 'inicio',
                'icon' => 'grid',
                'order' => 1,
            ],
            [
                'name' => 'Permisos',
                'routeName' => 'permiso',
                'slug' => 'permiso',
                'icon' => 'check-square',
                'order' => 2,
                'children' => [
                    [
                        'name' => 'Solicitudes',
                        'routeName' => 'permiso.solicitud',
                        'slug' => 'permiso/solicitud',
                        'icon' => 'circle',
                        'order' => 1,
                    ],
                    [
                        'name' => 'Mis permisos',
                        'routeName' => 'permiso.mis-permisos',
                        'slug' => 'permiso/mis-permisos',
                        'icon' => 'circle',
                        'order' => 2,
                    ],
                ]
            ],
            [
                'name' => 'Administración',
                'routeName' => 'administracion',
                'slug' => 'administracion',
                'icon' => 'users',
                'order' => 3,
                'children' => [
                    [
                        'name' => 'Roles',
                        'routeName' => 'administracion.rol',
                        'slug' => 'administracion/rol',
                        'icon' => 'circle',
                        'order' => 2,
                    ],
                    [
                        'name' => 'Usuarios',
                        'routeName' => 'administracion.usuario',
                        'slug' => 'administracion/usuario',
                        'icon' => 'circle',
                        'order' => 1,
                    ],
                ]
            ],
            [
                'name' => 'Configuración',
                'routeName' => 'configuracion',
                'slug' => 'configuracion',
                'icon' => 'bar-chart',
                'order' => 4,
                'children' => [
                    [
                        'name' => 'Departamentos',
                        'routeName' => 'configuracion.departamento',
                        'slug' => 'configuracion/departamento',
                        'icon' => 'circle',
                        'order' => 1,
                        
                    ],
                    [
                        'name' => 'Servicios',
                        'routeName' => 'configuracion.servicio',
                        'slug' => 'configuracion/servicio',
                        'icon' => 'circle',
                        'order' => 2,
                        
                    ]
                ]
            ],
        ];
        $this->insertDatas($data);
    }
    function insertDatas($array, $parent = null) {
        foreach ($array as $item) {
            if(!is_null($parent)) $item['parentId'] = $parent->id;
            $menu = Menu::create(Arr::except($item, 'children'));
            if (isset($item['children']) && is_array($item['children'])) {
                $this->insertDatas($item['children'], $menu);
            }
        }
    }
}
