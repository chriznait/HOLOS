<?php

namespace App\Livewire\Tickets;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OtmTicket;
class Listar extends Component
{
    use WithPagination;

    public $tituloPagina, $tituloModal;
    public $search;
    public $crud;

    public function mount(Request $request) : void {
        $this->search = "";
        $this->crud = $request->attributes->get('permisos');
        //dd($this->crud);
    }

    function setEstado($id, $estado) : void {
            
        //dd($id);
            $ticket = OtmTicket::find($id);
            if(auth()->user()->id == $ticket->idSolicita && $estado != 6){
                $this->dispatch('alert', ['type' => 'error', 'message' => 'No puedes actualizar tu propio ticket']);
            }else{
                $datos = [];
        
                if($estado == 2){
                    $datos['idRecepciona'] = auth()->user()->id;
                    $datos['fechaAsignado'] = now();
                }
                
                OtmTicket::where('id', $id)->update(array_merge($datos, ['idEstadoTicket' => $estado]));
            }
    }

    function setTipo ($id, $tipo) : void {
        $datos = [];
        $datos['tipoAtencion'] = $tipo;
        $datos['idEstadoTicket'] = 3;
        OtmTicket::where('id', $id)->update($datos);
    }

    public function render()
    {
        $user = User::find(auth()->user()->id);
        $empleado = $user->empleado;

        $permisosIds = $user->getAllPermissions()->pluck('id')->toArray();
        //dd($this->crud);
        $tickets = OtmTicket::with('personalAtiende', 'servicio','estado')
                            ->orderBy('id', 'desc')
                            
                            ->paginate(10);
        //dd($tickets);

        return view('livewire.tickets.listar', compact('tickets'));
    }


}
