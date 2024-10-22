<?php

namespace App\Livewire\Configuracion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sub_servicio as SubServicioModel;
use Illuminate\Http\Request;
use App\Models\Servicio as ServicioModel;
use App\Models\DepartamentoHospital as DepartamentoHospitalModel;

class SubServicio extends Component
{
    use WithPagination;

    public $servicio;
    public $tituloPagina, $tituloModal;
    public $servicios = [], $departamentos;
    public $subServicio;
    public $idServicio, $search, $idDepartamento;
    public $crud;

    public function mount(Request $request) : void {
        $this->crud = $request->attributes->get('permisos');
        $this->tituloPagina = 'Sub Servicios';
        $this->search = '';
        $this->idServicio = '';
        $this->idDepartamento = '';
        $this->departamentos = DepartamentoHospitalModel::all();
        $this->servicios = ServicioModel::where('id', $this->idDepartamento)->get();
    }
    public function updatedServicio($value) : void {
        $this->servicios = ServicioModel::where('departamento_id', $value)->get();
        $this->servicio = $this->servicios->first()->id ?? '';
    }

    public function render()
    {
        return view('livewire.configuracion.sub-servicio');
    }
}
