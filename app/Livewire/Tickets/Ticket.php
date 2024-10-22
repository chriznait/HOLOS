<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OtmTicket as TicketModel;
use App\Models\Empleado;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;

class Ticket extends Component
{

    use WithPagination;
    public $tituloPagina, $tituloModal;
    public $search;
    public $crud;
    public $user;
    public $descripcion_equipo="", $descripcion_problema="";
    public $anexo_telefonico="";
    public $departamento;
    public $servicio;
    public $totServicio;
    public $idServicio="";

    function mount(Request $request) : void {
        
        $this->search = "";
        $this->crud = $request->attributes->get('permisos');
        $this->user = Empleado::find(auth()->user()->id);
        $this->servicio = Servicio::where('id',$this->user->servicioId)->get();
        $departamento = $this->user->departamentoId; // GESTION Y ELECTRO UPS
        
        if($departamento == 4 || $departamento == 9)
            $this->servicio = Servicio::where('departamentoId', $departamento)->get();
        $this->totServicio = count($this->servicio);
    }

    public function render()
    {

        return view('livewire.tickets.ticket', 
            [
            
            ]);
        
    }

    

    public function store()
    {
        //dd($this->totServicio);
        if($this->totServicio==1){
            $this->user = Empleado::find(auth()->user()->id);
            $this->servicio = Servicio::where('id',$this->user->servicioId)->get();
            $this->idServicio = $this->servicio[0]->id;
        }
        /*dd(
            [
                'totServicio' => $this->totServicio,
                'idServicio' => $this->idServicio,
            ]
        );*/
        $this->validate([
            'descripcion_equipo' => 'required',
            'descripcion_problema' => 'required',
            'idServicio' => 'required'
        ]);

        TicketModel::create([
            'idSolicita' => auth()->user()->id,
            'idServicio' => $this->idServicio,
            'idEstadoTicket' => 1,
            'fechaCreacion' => now(),
            'equipo' => $this->descripcion_equipo,
            'detalleProblema' => $this->descripcion_problema,
            'anexo' => $this->anexo_telefonico
        ]);

        $this->reset('descripcion_equipo', 'descripcion_problema', 'anexo_telefonico');
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Ticket creado con éxito']);
    }
}
