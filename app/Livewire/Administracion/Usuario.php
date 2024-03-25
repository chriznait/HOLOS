<?php

namespace App\Livewire\Administracion;

use App\Livewire\Configuracion\Departamento;
use App\Models\DepartamentoHospital;
use App\Models\Empleado;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Usuario extends Component
{
    use WithPagination;

    public $tituloPagina, $tituloModal, $servicios;
    public $empleado, $usuario, $actualizaCredenciales, $usuarioPassword;
    public $selectedRoles;

    public $search;

    function mount() : void {
        $this->servicios = collect();

        $this->search = "";

        $this->reseteaDatos();
    }
    function reseteaDatos() : void {
        $this->empleado = new Empleado();
        $this->usuario = new User();
        $this->selectedRoles = [];
        $this->actualizaCredenciales = true;
    }
    function inicializaDatos($id = "") : void {
        if(empty($id)){
            $this->tituloModal = "Registrar Usuario";
            $this->reseteaDatos();
        }else{
            $empleado = Empleado::find($id);
            $this->changeDepartamento($empleado->departamentoId, true);
            $this->tituloModal = "Editar Usuario";
            $this->actualizaCredenciales = false;
            $this->empleado = $empleado;
            $this->usuario = User::find($this->empleado->userId);
            $this->selectedRoles = $this->usuario->roles->pluck('id')->toArray();
            $this->dispatch('delayServicioId', servicioId: $empleado->servicioId);
        }
        $this->usuarioPassword = "";
    }
    
    function muestraModal($id = "") : void {
        $this->inicializaDatos($id);
        $this->resetValidation();
        $this->dispatch('openModal');
    }
    function cierraModal(){
        $this->dispatch('closeModal');
    }
    function changeDepartamento($departamentoId, $init = false) : void {
        $this->servicios = select_values('servicio', 'descripcion', ['departamentoId', $departamentoId], ['descripcion', 'asc']);
        /* $this->servicios = Servicio::where('departamentoId', $departamentoId)->get(); */
        if(!$init)
            $this->empleado->servicioId = '';
    }
    function rules() : array {
        $rules = [
            'empleado.apellidoPaterno'  => 'required',
            'empleado.apellidoMaterno'  => 'required',
            'empleado.nombres'          => 'required',
            'empleado.tipoDocumentoId'  => 'required',
            'empleado.nroDocumento'     => ['required', 'unique:empleado,nroDocumento'.(!is_null($this->empleado->id) ? ','.$this->empleado->id : '')],
            'empleado.fechaNacimiento'  => 'required',
            'empleado.tipoSexoId'       => 'required',
            'empleado.tipoContratoId'   => 'required',
            'empleado.profesionId'      => 'required',
            'empleado.cargoId'          => 'required',
            'empleado.departamentoId'   => 'required',
            'empleado.servicioId'       => 'required',
            'usuario.username'          => '',
            'usuarioPassword'           => '',
        ];
        if($this->actualizaCredenciales){
            $rules['usuario.username'] = ['required', 'unique:users,username'.(!is_null($this->usuario->id) ? ','.$this->usuario->id : '')];
            $rules['usuarioPassword'] = 'required';
        }

        return $rules;
    }
    function validationAttributes() : array {
        return [
            /* 'empleado.apellidoPaterno'  => 'required',
            'empleado.apellidoMaterno'  => 'required',
            'empleado.nombres'          => 'required', */
            'empleado.tipoDocumentoId'  => 'tipo documento',
            'empleado.nroDocumento'     => 'número documento',
            'empleado.fechaNacimiento'  => 'fecha de nacimiento',
            'empleado.tipoSexoId'       => 'sexo',
            'empleado.profesionId'      => 'profesion',
            'empleado.cargoId'          => 'cargo',
            'empleado.tipoContratoId'   => 'tipo contrato',
            'empleado.departamentoId'   => 'area',
            'empleado.servicioId'       => 'servicio',
            'usuario.username'          => 'usuario',
            'usuarioPassword'           => 'contraseña',
        ];
    }
    function guardar() : void {
        $this->validate();

        DB::beginTransaction();

        try {
            if($this->actualizaCredenciales){
                $this->usuario->password = Hash::make($this->usuarioPassword);
                $this->usuario->save();
            }

            if(!is_null($this->empleado->id) && $this->empleado->id != ""){
                $message = "Actualizado con exito";
            }else{
                $message = "Registrado con exito";
                $this->empleado->userId = $this->usuario->id;
            }
            $this->usuario->syncRoles(array_map('intval', $this->selectedRoles));
            $this->empleado->save();


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
            $empleado = Empleado::find($id);

            if(is_null($empleado)){
                $resp["type"] = 'error';
                $resp["message"] = 'No encontrado';
            }else{
                $empleado->delete();
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
        $empleados      = Empleado::search($this->search)
                                ->with(['area','servicio'])
                                /* ->where('id', '<>', 1) */
                                ->paginate(10);
                                
        $departamentos  = select_values('departamento_hospital', 'descripcion', [], ['descripcion', 'asc']);
        $tiposSexo      = select_values('tipo_sexo', 'descripcion', [], ['descripcion', 'asc']);
        $tiposContrato  = select_values('tipo_contrato', 'descripcion', [], ['descripcion', 'asc']);
        $tiposDocumento = select_values('tipo_documento', 'descripcion', [], ['descripcion', 'asc']);
        $profesiones    = select_values('profesion', 'descripcion', [], ['descripcion', 'asc']);
        $cargos         = select_values('cargo', 'descripcion', [], ['descripcion', 'asc']);
        $roles          = select_values('roles', 'name', [], ['name', 'asc']);
        
        return view('livewire.administracion.usuario', 
            compact('empleados', 'departamentos', 'tiposSexo', 'tiposContrato', 'tiposDocumento', 'profesiones', 'roles', 'cargos')
        );
    }
}
