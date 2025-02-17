<?php

namespace App\Livewire\Permiso;

use App\Models\Permiso;
use Livewire\Component;
use Livewire\WithPagination;

class MisPermisos extends Component
{
    use WithPagination;

    public $tituloPagina, $search;
    function mount() : void {
        $this->tituloPagina = "Mis permisos";
        $this->search = "";
    }
    public function render()
    {
        $empleado = auth()->user()->empleado;

        $permisos = Permiso::with('empleado.departamento','empleado.servicio', 'tipo', 'autoriza')
                            ->where('empleadoId', $empleado->id)
                            ->orderBy('id', 'desc')
                            ->paginate(10);
        return view('livewire.permiso.mis-permisos', compact('permisos'));
    }
}
