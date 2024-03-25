<?php

namespace App\Livewire\Configuracion;

use App\Models\DepartamentoHospital;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Departamento extends Component
{
    use WithPagination;

    public $tituloPagina, $tituloModal, $search;
    public $departamento;

    function mount() : void {
        $this->tituloPagina = 'Departamentos Hospital';
        $this->search = '';
        $this->reseteaDatos();
    }
    function reseteaDatos() : void {
        $this->departamento = new DepartamentoHospital();
    }
    function inicializaDatos($id = "") : void {
        if(empty($id)){
            $this->tituloModal = "Registrar Departamento";
            $this->reseteaDatos();
        }else{
            $this->tituloModal = "Editar Departamento";
            $this->departamento = DepartamentoHospital::find($id);
        }
    }
    function rules() : array {
        return [
            'departamento.descripcion' => 'required'
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
            if(!is_null($this->departamento->id) && $this->departamento->id != ""){
                $message = "Actualizado con exito";
            }else{
                $message = "Registrado con exito";
            }
            $this->departamento->save();

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
            $departamento = DepartamentoHospital::find($id);

            if(is_null($departamento)){
                $resp["type"] = 'error';
                $resp["message"] = 'No encontrado';
            }else{
                $departamento->delete();
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
        $departamentos = DepartamentoHospital::where('descripcion', 'like', '%'.$this->search.'%')
                            ->orderBy('descripcion')
                            ->paginate(10);
        
        return view('livewire.configuracion.departamento', compact('departamentos'));
    }
}
