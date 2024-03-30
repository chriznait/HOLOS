<?php

namespace App\Livewire\Rol;

use App\Models\DepartamentoHospital;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Administracion extends Component
{
    use WithPagination;
    public $tituloPagina, $tituloModal, $rol;
    public $user, $empleado, $filMes, $filAnio, $filDepartamento;
    public $departamentos, $servicios, $anios, $meses;

    function mount() : void {
        $this->tituloPagina = "Gestión de Roles";
        $this->filMes = (int) date('m');
        $this->filAnio = (int) date('Y');
        $this->filDepartamento = "";
        $this->user = auth()->user();
        $this->empleado = auth()->user()->empleado;
        $this->reseteaData();   

        if($this->user->hasPermissionTo(5)){
            $this->departamentos = select_values('departamento_hospital', 'descripcion', [], ['descripcion', 'asc']);
        }else{
            $this->departamentos = select_values('departamento_hospital', 'descripcion', ['id', $this->empleado->departamentoId], ['descripcion', 'asc']);
        }
        $this->servicios = [];
        $this->anios = getAnios();
        $this->meses = getMeses();
    }
    function changeDepartamento($init = false) : void {
        $this->servicios = select_values('servicio', 'descripcion', ['departamentoId', $this->rol->departamentoId], ['descripcion', 'asc']);
        if(!$init)
            $this->rol->servidioId = "";
    }
    function reseteaData() : void {
        $this->rol = new Rol();
        $this->servicios = [];
    }
    function inicializaDatos($id) : void {
        if(empty($id)){
            $this->reseteaData();
            $this->tituloModal = "Registrar rol";
        }else{
            $this->rol = Rol::find($id);
            $this->tituloModal = "Editar rol";
            $this->changeDepartamento(true);
            $this->dispatch('delayServicioId', servicioId: $this->rol->servicioId);
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
        return [
            'rol.departamentoId'    => 'required',
            'rol.servicioId'        => 'required',
            'rol.anio'              => 'required',
            'rol.mes'               => 'required',
            'rol.observacion'       => '',
        ];
    }
    function validationAttributes() : array {
        return [
            'rol.departamentoId'    => 'departamento',
            'rol.servicioId'        => 'servicio',
            'rol.anio'              => 'año',
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
                $this->rol->estadoId = 1;
                $this->rol->registraId = $this->empleado->id;
            }
            $this->rol->save();

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
            $rol = Rol::find($id);

            if(is_null($rol)){
                $resp["type"] = 'error';
                $resp["message"] = 'No encontrado';
            }else{
                $rol->delete();
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
        $rolesGeneral = $this->user->hasPermissionTo(5);
        $roles = Rol::when(!$rolesGeneral, function($q){
                            $q->where('departamentoId', $this->empleado->departamentoId);
                        })
                        ->where('anio', $this->filAnio)
                        ->where('mes', $this->filMes)
                        ->when(!empty($this->filDepartamento), function($q){
                            $q->where('departamentoId', $this->filDepartamento);
                        })
                        ->paginate(10);
        
        return view('livewire.rol.administracion', compact('roles'));
    }
}
