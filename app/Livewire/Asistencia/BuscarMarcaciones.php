<?php

namespace App\Livewire\Asistencia;

use App\Models\Empleado;
use App\Models\MarcacionDetalle;
use App\Models\RolEmpleado;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BuscarMarcaciones extends Component
{
    public $tituloPagina;
    function mount() : void {
        $this->tituloPagina = "Buscar marcaciones";
    }

    function getMarcaciones($codigo) {
        $empleado = Empleado::where('codigo', $codigo)->first();
        $marcaciones = MarcacionDetalle::select(DB::raw("DATE_FORMAT(marcacion, '%h:%i %p') AS title"), 
                                                DB::raw("DATE_FORMAT(marcacion, '%Y-%m-%d') AS start"))
                                            ->where('codigo', $empleado->codigo)->get()->toArray();

        $rol = RolEmpleado::select(DB::raw("CONCAT('Turno: ','',D.turno) as title"), 
                            DB::raw("CONCAT(R.anio,'-',LPAD(R.mes,2,'0'),'-',LPAD(D.dia,2,'0')) AS start"),
                            DB::raw("CONCAT('#229954') as color")
                            )
                            ->from('rol_personal_empleado AS E')
                            ->join('rol_personal AS R', 'R.id', '=', 'E.rolId')
                            ->join('rol_personal_detalle AS D', 'D.rolEmpleadoId', '=', 'E.id')
                            ->where('E.empleadoId', $empleado->id)
                            ->where('R.estadoId', 2) //solo rol aprobado
                            ->get()->toArray();
        $data = array_merge($marcaciones, $rol);
        
        return $data;
    }

    public function render()
    {
        return view('livewire.asistencia.buscar-marcaciones');
    }
}
