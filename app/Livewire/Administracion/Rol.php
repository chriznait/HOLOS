<?php

namespace App\Livewire\Administracion;

use App\Helpers\Menu;
use App\Models\Menu as MenuModel;
use App\Models\RolMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Rol extends Component
{
    use WithPagination;

    public $tituloPagina, $tituloModal, $search;
    public $rol, $permisos, $menu, $permisosSeleccionados;
    public $crud;

    function mount(Request $request) : void {
        $this->crud = $request->attributes->get('permisos');
        $this->permisos = Permission::all();
        $this->tituloPagina = "Roles";
        $this->search = "";
        $this->setDataMenu();
        $this->reseteaDatos();
        //dd($this->menu);
    }
    function setDetalles($items, $nivel, $padre = null) : array {
        $menu = [];
        foreach ($items as $item) {
            $menu[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'nivel' => $nivel,
                'padre' => $padre,
                'submenu' => (bool) $item['submenu'],
                'ver' => false,
                'crear' => false,
                'editar' => false,
                'eliminar' => false,
            ];
            if($item['submenu']){
                //$menu[] = $this->setDetalles($item['submenu'], $nivel + 1);
                $menu = array_merge($menu, $this->setDetalles($item['submenu'], $nivel + 1, $item['id']));
            }
        }
        return $menu;
    }
    function setDataMenu() : void {
        $menu = Menu::menus();
        $this->menu = $this->setDetalles($menu, 0);
    }
    function changeVer($index) : void {
        
        /* $item = $this->menu[$index];

        if($item['ver'] && !is_null($item['padre'])){
            
            $padre = array_filter($this->menu, function($m) use ($item){
                return $m['id'] == $item['padre'];
            });
            
            $this->menu[array_keys($padre)[0]]['ver'] = true;
        } */
        
    }
    function reseteaMenu($permisos = null) : void {
        foreach (array_keys($this->menu) as $key) {
            $item = &$this->menu[$key];

            $item['ver'] = false;
            $item['crear'] = false;
            $item['editar'] = false;
            $item['eliminar'] = false;
            
            if(!is_null($permisos)){
                $elemento = $permisos->firstWhere('menuId', $item['id']);
                if(!is_null($elemento)){
                    $item['ver'] = (bool) $elemento->ver;
                    $item['crear'] = (bool) $elemento->crear;
                    $item['editar'] = (bool) $elemento->editar;
                    $item['eliminar'] = (bool) $elemento->eliminar;
                }
            }
        }
        
    }
    function reseteaDatos() : void {
        $this->rol = new Role();
        $this->permisosSeleccionados = [];
    }
    function inicializaDatos($id = "") : void {
        if(empty($id)){
            $this->tituloModal = "Registrar Rol";
            $this->reseteaDatos();
            $this->reseteaMenu();
        }else{
            $this->tituloModal = "Editar Rol";
            $this->rol = Role::find($id);
            $this->permisosSeleccionados = $this->rol->permissions->pluck('id')->toArray();
            $menuRol = RolMenu::where('rolId', $this->rol->id)->get();
            $this->reseteaMenu($menuRol);
        }
    }
    
    function muestraModal($id = "") : void {
        $this->inicializaDatos($id);
        $this->resetValidation();
        $this->dispatch('openModal');
    }
    function cierraModal(){
        $this->dispatch('closeModal');
    }
    function rules() : array {
        $rules = [
            'rol.name' => ['required', 'unique:roles,name'.(!is_null($this->rol->id) ? ','.$this->rol->id : '')],
            'menu.*.ver' => '',
            'menu.*.crear' => '',
            'menu.*.editar' => '',
            'menu.*.eliminar' => '',
            'permisosSeleccionados' => '',
        ];

        return $rules;
    }
    function validationAttributes() : array {
        return [
            'rol.name'  => 'nombre',
        ];
    }
    function guardar() : void {
        $this->validate();
        
        DB::beginTransaction();

        try {

            if(!is_null($this->rol->id) && $this->rol->id != ""){
                $message = "Actualizado con exito";
            }else{
                $message = "Registrado con exito";
            }
            
            $this->rol->save();

            $this->rol->syncPermissions(array_map('intval', $this->permisosSeleccionados));

            foreach ($this->menu as $item) {
                $menuItem = RolMenu::where(['rolId' => $this->rol->id, 'menuId' => $item['id']])
                                    ->first();
                if(!is_null($menuItem)){
                    if(!$item['ver'] && !$item['crear'] && !$item['editar'] && !$item['eliminar']){
                        $menuItem->delete();
                        //RolMenu::where(['rolId' => $this->rol->id, 'menuId' => $item['id']])->delete();
                    }else{
                        $menuItem->ver      = $item['ver'];
                        $menuItem->crear    = $item['crear'];
                        $menuItem->editar   = $item['editar'];
                        $menuItem->eliminar = $item['eliminar'];
                        $menuItem->save();
                    }
                }else{
                    if($item['ver'] || $item['crear'] || $item['editar'] || $item['eliminar']){
                        RolMenu::create([
                            'rolId'     => $this->rol->id, 
                            'menuId'    => $item['id'],
                            'ver'       => $item['ver'],
                            'crear'     => $item['crear'],
                            'editar'    => $item['editar'],
                            'eliminar'  => $item['eliminar'],
                        ]);
                    }
                }
            }

            $resp["type"] = 'success';
            $resp["message"] = $message;

            DB::commit();
            
            $this->cierraModal();
        } catch (\Exception $e) {
            DB::rollback();
            $resp["type"] = 'error';
            $resp["message"] = 'No se pudo guardar los datos'. $e->getMessage();
        }
        $this->dispatch('alert', $resp);
    }
    function eliminar($id){
        DB::beginTransaction();

        try {
            $rol = Role::find($id);

            if(is_null($rol)){
                $resp["type"] = 'error';
                $resp["message"] = 'No encontrado';
            }else{
                Role::where('id', $id)->delete();
                $resp["type"] = 'success';
                $resp["message"] = 'Eliminado con exito';
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $resp["type"] = 'error';
            $resp["message"] = 'No se pudo eliminar';
        }
        $this->dispatch('alert', $resp);        
    }
    public function render()
    {
        $roles = Role::where('name', 'like', '%'.$this->search.'%')->paginate(10);
        
        return view('livewire.administracion.rol', [
            'roles' => $roles
        ]);
    }
}
