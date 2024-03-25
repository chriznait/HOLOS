<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* $roles = [
            [
                'name' => 'Administrador'
            ],
            [
                'name' => 'Usuario'
            ],
        ];
        foreach ($roles as $role) {
            Role::create($role);
        } */
        $administrador = Role::create(['name' => 'Administrador']);
        $usuario = Role::create(['name' => 'Usuario']);
        $administrador->users()->attach(1);
        $usuario->users()->attach(2);

        $permisoAutorizaServicio        = Permission::create(['name' => 'permiso autoriza servicio']);
        $permisoAutorizaDepartamento    = Permission::create(['name' => 'permiso autoriza departamento']);
        $permisoAutorizaGeneral         = Permission::create(['name' => 'permiso autoriza general']);
        $permisoAsignaSalidaRetorno     = Permission::create(['name' => 'permiso asigna salida/retorno']);


    }
}
