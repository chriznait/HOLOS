<?php

namespace App\Livewire\Otm;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OtmTicket;

class MisOtm extends Component
{
    use WithPagination;

    public $tituloPagina, $tituloModal;
    public $search;
    public $crud;

    public function mount(Request $request) : void {
        $this->search = "";
        $this->crud = $request->attributes->get('permisos');
        
    }

    public function render()
    {
        $user = User::find(auth()->user()->id);
        $empleado = $user->empleado;

        $permisosIds = $user->getAllPermissions()->pluck('id')->toArray();

        $tickets = OtmTicket::with('personalAtiende', 'servicio','estado')
                            ->where
                                ([
                                    ['idPersonalAtiende', auth()->user()->id],
                                    ['idEstadoTicket', 3]
                                ])
                            ->orderBy('id', 'desc')
                            ->paginate(10);

        return view('livewire.otm.mis-otm', compact('tickets'));
    }
}
