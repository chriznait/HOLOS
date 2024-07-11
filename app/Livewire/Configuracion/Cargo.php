<?php

namespace App\Livewire\Configuracion;

use App\Models\Cargo as ModelsCargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Cargo extends Component
{
    use WithPagination;
    public $tituloPagina, $tituloModal;
    public $cargo;
    public $search,$crud;

    function mount(Request $request) : void {
        $this->crud = $request->attributes->get('permisos');
        $this->tituloPagina = 'Cargos';
        $this->search = '';
        $this->reseteaDatos();
    }

    function reseteaDatos() : void {
        $this->cargo = new ModelsCargo();
    }
    function inicializaDatos($id = "") : void {
        if(empty($id)){
            $this->tituloModal = "Registrar Cargo";
            $this->reseteaDatos();
        }else{
            $this->tituloModal = "Editar Cargo";
            $this->cargo = ModelsCargo::find($id);
        }
    }
    function rules() : array {
        return [
            'cargo.descripcion' => 'required',
            'cargo.ordenRolConsolidado' => ''
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
            if(!is_null($this->cargo->id) && $this->cargo->id != ""){
                $message = "Actualizado con exito";
            }else{
                $message = "Registrado con exito";
            }
            $this->cargo->save();

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
            $cargo = ModelsCargo::find($id);

            if(is_null($cargo)){
                $resp["type"] = 'error';
                $resp["message"] = 'No encontrado';
            }else{
                $cargo->delete();
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
        $cargos = ModelsCargo::where('descripcion', 'like', '%'.$this->search.'%')
                                    ->orderBy('descripcion')
                                    ->orderBy('ordenRolConsolidado')
                                    ->paginate(10);
        return view('livewire.configuracion.cargo', compact('cargos'));
    }
}
