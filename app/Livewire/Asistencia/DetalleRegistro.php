<?php

namespace App\Livewire\Asistencia;

use App\Models\Marcacion;
use App\Models\MarcacionDetalle;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use SebastianBergmann\Type\VoidType;

class DetalleRegistro extends Component
{
    use WithPagination;

    public $tituloPagina, $idModal;
    public $marcaciones;

    function mount($idRegistro) : void {
        $this->marcaciones = Marcacion::find($idRegistro);
        if(is_null($this->marcaciones)){
            $this->redirectRoute('asistencia.registros');
        }
        $this->tituloPagina = "Detalle de registro";
        $this->idModal = "mdl-detalle-registro";
      
    }
    /* function reseteaDatos() : void {
        $this->marcaciones = new Marcacion();
        $this->detalles = [];
    }
    function inicializaDatos($id) : void {
        if(empty($id)){
            $this->reseteaDatos();
        }else{
            $this->marcaciones = Marcacion::with('detalle.empleado.profesion','detalle.empleado.cargo')
                                    ->find($id);
           
        }
    } 
    #[On('muestra-modal')]
    function muestraModal($id = "") : void {
        $this->inicializaDatos($id);
        $this->dispatch('openModal', $this->idModal);
    }
    function cierraModal(){
        $this->dispatch('closeModal');
    } */
    public function render()
    {
        $detalles = MarcacionDetalle::where('marcacionId', $this->marcaciones->id)
                                        ->with('empleado.profesion','empleado.cargo')
                                        ->paginate(1000);

        return view('livewire.asistencia.detalle-registro', compact('detalles'));
    }
}
