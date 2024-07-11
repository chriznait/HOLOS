<?php

namespace App\Livewire\Permiso;

use App\Models\Empleado;
use App\Models\Permiso;
use App\Models\TipoPermiso;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class FormSolicitud extends Component
{
    public $nroDocumento;
    public $empleado;
    public $permiso;
    public $mensajes;

    function mount() : void {
        $this->reseteaDatos();
    }

    function reseteaDatos() : void {
        $this->empleado = new Empleado();
        $this->permiso = new Permiso();
        $this->nroDocumento = "";
        $this->mensajes = "";
    }
    function permisosAnteriores($empleadoId): void{
        
        $permisos = Permiso::where('empleadoId', $empleadoId)->whereIn('estadoId', [1,2,4])->with('estado')->first();
        if(!is_null($permisos)){
            $this->mensajes = 'Usted tiene un permiso '.$permisos->estado->descripcion.' con fecha '.date('d/m/Y H:i', strtotime($permisos->created_at));
        }
    }
    function buscarDNI() : void {
        $empleado = Empleado::firstWhere('nroDocumento', $this->nroDocumento);
        $this->mensajes = "";
        if(!is_null($empleado)){
            $this->permisosAnteriores($empleado->id);

            if(empty($this->mensajes)){
                $this->empleado = $empleado;
                $this->permiso->empleadoId      = $empleado->id;
                $this->permiso->departamentoId  = $empleado->departamentoId;
                $this->permiso->servicioId      = $empleado->servicioId;
            }
            
        }else{
            $this->empleado = new Empleado();
            $resp["type"] = 'error';
            $resp["message"] = 'Nro de documento no encontrado';
            $this->dispatch('alert', $resp);
        }
    }

    function rules() : array {
        return [
            'permiso.fundamento'    => 'required',
            'permiso.destino'       => 'required',
            'permiso.tipoId'        => 'required',
            'permiso.empleadoId'    => 'required',
            'permiso.departamentoId'=> 'required',
            'permiso.servicioId'    => 'required',
        ];
    }
    function validationAttributes() : array {
        return [
            'permiso.tipoId'        => 'tipo',
            'permiso.empleadoId'    => 'empleado',
            'permiso.departamentoId'=> 'departamento',
            'permiso.servicioId'    => 'servicio',
        ];
    }
    function guardar() : void {
        
        $this->validate();
        
        DB::beginTransaction();

        try {

            $message = "Registrado con exito";
            $this->permiso->save();

            $resp["type"] = 'success';
            $resp["message"] = $message;

            DB::commit();
            
            $this->reseteaDatos();
        } catch (\Exception $e) {
            DB::rollback();
            $resp["type"] = 'error';
            $resp["message"] = 'No se pudo guardar los datos'. $e->getMessage();
        }
        $this->dispatch('alert', $resp);
    }

    #[Layout('layouts.guest')] 
    public function render()
    {
        $tipos = TipoPermiso::all();
        return view('livewire.permiso.form-solicitud', compact('tipos'));
    }
}
