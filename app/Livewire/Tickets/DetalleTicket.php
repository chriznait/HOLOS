<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\OtmTicket;

class DetalleTicket extends Component
{
    public $tituloPagina, $tituloModal;
    public OtmTicket $ticket;
    
    public function mount() : void {
        $this->tituloModal = "Detalle de ticket";
        $this->reseteaDatos();
    }

    function reseteaDatos() : void {
        $this->ticket = new OtmTicket();
    }
    function inicializaDatos($id = "") : void {
        if(empty($id)){
            $this->reseteaDatos();
        }else{
            $ticket = OtmTicket::find($id);
            $this->ticket = $ticket;
            
        }
        //dd($id);
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
        return view('livewire.tickets.detalle-ticket');
    }
}
