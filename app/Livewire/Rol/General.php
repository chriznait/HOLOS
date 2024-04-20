<?php

namespace App\Livewire\Rol;

use App\Livewire\Configuracion\Departamento;
use App\Models\DepartamentoHospital;
use App\Models\Rol;
use App\Models\User;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class General extends Component
{
    public $tituloPagina;
    public $user, $empleado, $filMes, $filAnio, $filDepartamento;
    public $departamentos, $anios, $meses;
    public $departamentosRol;
    public $diasMes;

    function mount() : void {
        $this->tituloPagina = "Roles de personal";
        $this->filMes               = (int) date('m');
        $this->filAnio              = (int) date('Y');
        $this->filDepartamento      = "";
        $this->user                 = User::find(auth()->user()->id);
        $this->empleado             = $this->user->empleado;

        if($this->user->hasPermissionTo(5)){
            $this->departamentos = select_values('departamento_hospital', 'descripcion', [], ['descripcion', 'asc']);
        }else{
            $this->departamentos = select_values('departamento_hospital', 'descripcion', ['id', $this->empleado->departamentoId], ['descripcion', 'asc']);
        }
        $this->anios = getAnios();
        $this->meses = getMeses();
        $this->departamentosRol = [];
    }
    function cargarRoles() : void {
        $this->diasMes = getDiasMes($this->filAnio, $this->filMes);
        $this->departamentosRol = DepartamentoHospital::with([
                            'servicios.roles' => function($q){
                                $q->with('empleados.detalles.rTurno')
                                    ->where('estadoId', 2)
                                    ->where('anio', $this->filAnio)
                                    ->where('mes', $this->filMes)
                                    ->when(!empty($this->filDepartamento), function($qq){
                                        $qq->where('departamentoId', $this->filDepartamento);
                                    });
                            }
                        ])
                        ->whereHas('servicios.roles', function($q){
                            $q->where('estadoId', 2)
                                ->where('anio', $this->filAnio)
                                ->where('mes', $this->filMes)
                                ->when(!empty($this->filDepartamento), function($qq){
                                    $qq->where('departamentoId', $this->filDepartamento);
                                });
                        })
                        ->get();
    }
    function descargarXls() {
        
    }
    public function render()
    {
        return view('livewire.rol.general');
    }
}
