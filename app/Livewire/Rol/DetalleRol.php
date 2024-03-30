<?php

namespace App\Livewire\Rol;

use App\Models\Rol;
use Livewire\Attributes\On;
use Livewire\Component;

class DetalleRol extends Component
{
    public $tituloModal, $idModal;
    public $rol;

    function mount() : void {
        $this->tituloModal = "Detalle Rol";
        $this->idModal = "mdl-rol-detalle";
        $this->rol = new Rol();
    }
    function inicializaDatos($id) : void {
        $this->rol = Rol::find($id);
    }
    #[On('muestraDetalle')]
    function mostrarDetalle($id) : void {
        $this->inicializaDatos($id);
        $this->dispatch('openModal', $this->idModal);
    }
    function cierraDetalle(){
        $this->dispatch('closeModal', $this->idModal);
    }
    function setEstado($estadoId) : void {
        $this->rol->estadoId = $estadoId;
        $this->rol->save();
        $this->cierraDetalle();

        $resp["type"] = 'success';
        $resp["message"] = 'Actualizado con exito';

        $this->dispatch('alert', $resp);

        $this->dispatch('refresh')->to(Administracion::class);
    }
    public function render()
    {
        return view('livewire.rol.detalle-rol');
    }
}
