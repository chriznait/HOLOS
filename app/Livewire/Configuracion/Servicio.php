<?php

namespace App\Livewire\Configuracion;

use App\Models\DepartamentoHospital;
use App\Models\Servicio as ServicioModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Servicio extends Component
{
    use WithPagination;

    public $tituloPagina, $tituloModal, $departamentos;
    public $servicio;
    public $idDepartamento, $search;

    function mount() : void {
        $this->tituloPagina = 'Servicios';
        $this->search = '';
        $this->idDepartamento = '';
        $this->departamentos = select_values('departamento_hospital', 'descripcion', [], ['descripcion', 'asc']);
        $this->reseteaDatos();
    }
    function reseteaDatos() : void {
        $this->servicio = new ServicioModel();
    }
    function inicializaDatos($id = "") : void {
        if(empty($id)){
            $this->tituloModal = "Registrar Servicio";
            $this->reseteaDatos();
        }else{
            $this->tituloModal = "Editar Servicio";
            $this->servicio = ServicioModel::find($id);
        }
    }
    function rules() : array {
        return [
            'servicio.descripcion' => 'required',
            'servicio.departamentoId' => 'required',
        ];
    }
    function validationAttributes() : array {
        return [
            'servicio.departamentoId' => 'departamento',
        ];
    }
    function muestraModal($id = "") : void {
        $this->inicializaDatos($id);
        $this->resetValidation();
        $this->dispatch('openModal');
    }
    function cierraModal(){
        $this->dispatch('closeModal');
    }
    function guardar() : void {
        $this->validate();
        DB::beginTransaction();

        try {
            if(!is_null($this->servicio->id) && $this->servicio->id != ""){
                $message = "Actualizado con exito";
            }else{
                $message = "Registrado con exito";
            }
            $this->servicio->save();

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
            $servicio = ServicioModel::find($id);

            if(is_null($servicio)){
                $resp["type"] = 'error';
                $resp["message"] = 'No encontrado';
            }else{
                $servicio->delete();
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
        $servicios = ServicioModel::where('descripcion', 'like', '%'.$this->search.'%')
                                    ->when(!empty($this->idDepartamento), function($q){
                                        $q->where('departamentoId', $this->idDepartamento);
                                    })
                                    ->with('departamento')
                                    ->orderBy('descripcion')
                                    ->paginate(10);

        return view('livewire.configuracion.servicio', compact('servicios'));
    }
}
