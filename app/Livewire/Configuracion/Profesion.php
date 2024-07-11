<?php

namespace App\Livewire\Configuracion;

use App\Models\Profesion as ModelsProfesion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Profesion extends Component
{
    use WithPagination;
    public $tituloPagina, $tituloModal;
    public $profesion;
    public $search,$crud;

    function mount(Request $request) : void {
        $this->crud = $request->attributes->get('permisos');
        $this->tituloPagina = 'Profesiones';
        $this->search = '';
        $this->reseteaDatos();
    }

    function reseteaDatos() : void {
        $this->profesion = new ModelsProfesion();
    }
    function inicializaDatos($id = "") : void {
        if(empty($id)){
            $this->tituloModal = "Registrar Profesión";
            $this->reseteaDatos();
        }else{
            $this->tituloModal = "Editar Profesión";
            $this->profesion = ModelsProfesion::find($id);
        }
    }
    function rules() : array {
        return [
            'profesion.descripcion' => 'required',
        ];
    }
    /* function validationAttributes() : array {
        return [
            'servicio.departamentoId' => 'departamento',
        ];
    } */
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
            if(!is_null($this->profesion->id) && $this->profesion->id != ""){
                $message = "Actualizado con exito";
            }else{
                $message = "Registrado con exito";
            }
            $this->profesion->save();

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
            $profesion = ModelsProfesion::find($id);

            if(is_null($profesion)){
                $resp["type"] = 'error';
                $resp["message"] = 'No encontrado';
            }else{
                $profesion->delete();
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
        $profesiones = ModelsProfesion::where('descripcion', 'like', '%'.$this->search.'%')
                                    ->orderBy('descripcion')
                                    ->paginate(10);

        return view('livewire.configuracion.profesion', compact('profesiones'));
    }
}
