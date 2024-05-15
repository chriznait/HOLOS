<?php

namespace App\Livewire\Asistencia;

use App\Models\Empleado;
use App\Models\MarcacionDetalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MisMarcaciones extends Component
{
    public $tituloPagina;
    function mount() : void {
        $this->tituloPagina = "Mis marcaciones";
    }
    function getMarcaciones() {
        $empleado = Empleado::where('userId', Auth::user()->id)->first();
        $marcaciones = MarcacionDetalle::select(DB::raw("DATE_FORMAT(marcacion, '%H:%i:%s') AS title"), 
                                                DB::raw("DATE_FORMAT(marcacion, '%Y-%m-%d') AS start"))
                                            ->where('codigo', $empleado->codigo)->get()->toArray();
        return $marcaciones;
    }
    public function render()
    {
        return view('livewire.asistencia.mis-marcaciones');
    }
}
