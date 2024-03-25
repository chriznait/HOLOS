<?php

namespace App\Livewire\Permiso;

use App\Models\Permiso;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Solicitud extends Component
{
    use WithPagination;

    public $tituloPagina, $tituloModal;

    public $search;

    function mount() : void {
        $this->search = "";
    }

    function setEstado($id, $estado) : void {

        $datos = [];

        if($estado == 2 || $estado == 3 || $estado == 6){
            $datos['autorizaId'] = auth()->user()->id;
            $datos['fechaHoraAutoriza'] = now();
        }else if($estado == 4){
            $datos['responsableSalidaId'] = auth()->user()->id;
            $datos['fechaHoraSalida'] = now();
        }else if($estado == 5){
            $datos['responsableRetornoId'] = auth()->user()->id;
            $datos['fechaHoraRetorno'] = now();
        }
        
        Permiso::where('id', $id)->update(array_merge($datos, ['estadoId' => $estado]));
    }

    public function render()
    {
        $user = User::find(auth()->user()->id);
        $empleado = $user->empleado;

        $permisosIds = $user->getAllPermissions()->pluck('id')->toArray();
        if (count(array_intersect($permisosIds, [1,2,3])) > 0) {
            $permisos = Permiso::with('empleado', 'departamento','servicio', 'tipo')
                                ->orderBy('id', 'desc')
                                ->whereHas('empleado', function($e) use ($user, $empleado){
                                    $e->search($this->search);
                                })
                                ->when(!$user->hasPermissionTo(3) && $user->hasPermissionTo(2), function($q) use ($empleado){
                                    $q->where('departamentoId', $empleado->departamentoId);
                                })
                                ->when(!$user->hasPermissionTo(3) && !$user->hasPermissionTo(2) && $user->hasPermissionTo(1), function($q) use ($empleado){
                                    $q->where('servicioId', $empleado->servicioId);
                                })
                                ->paginate(10);
        }else{
            $permisos = collect();
        }

        return view('livewire.permiso.solicitud', compact('permisos'));
    }
}
