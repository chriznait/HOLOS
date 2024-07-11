<?php

namespace App\Livewire\Permiso;

use App\Models\Permiso;
use Livewire\Attributes\On;
use Livewire\Component;

class FormDetalle extends Component
{
    public Permiso $permiso;
    public $tituloModal;

    function mount() : void {
        $this->tituloModal = "Detalle de permiso";
        $this->reseteaDatos();
    }
    function reseteaDatos() : void {
        $this->permiso = new Permiso();
    }
    function inicializaDatos($id = "") : void {
        if(empty($id)){
            $this->reseteaDatos();
        }else{
            $permiso = Permiso::find($id);
            $this->permiso = $permiso;
        }
    }

    #[On('muestra-modal')]
    function muestraModal($id) : void {
        $this->inicializaDatos($id);
        $this->resetValidation();
        $this->dispatch('openModal');
    }
    function cierraModal(){
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.permiso.form-detalle');
    }
}
