<?php

namespace App\Livewire\Otm;

use Livewire\Component;
use App\Models\OtmTicket;
use App\Models\User;
use App\Models\Otm_modalidad_atenciones;
use GuzzleHttp\Psr7\Request;

class FormOtm extends Component
{
    public $id;
    public $crud;
    public $idEquipo='',$ubicacion;
    public $detalleProblema;
    public $diagTecnico;
    public $prioridad,$idOtmModalidadAtencion,$fechaInicio,$fechaFin;
    public $descripcionTrabajo=[];
    public $cantidad=1;
    

    public function mount($id){
        $this->id = $id;
        $this->cantidad = 1;

        
        //$this->servicio
    }

    public function render()
    {
        $user = User::find(auth()->user()->id);
        $empleado = $user->empleado;
        $permisosId = $user->getAllPermissions()->pluck('id')->toArray();
        $otm = OtmTicket::with('personalAtiende', 'servicio', 'estado')
                        ->where('id', $this->id)
                        ->first();
        $this->ubicacion = $otm->ubicacion;
        $this->detalleProblema = $otm->detalleProblema;
        //dd($otm);
        $modalidadAtencion = Otm_modalidad_atenciones::all();

        return view('livewire.otm.form-otm', 
            compact('otm', 'modalidadAtencion'
            ));
    }

    public function agregarDetalleTrabajo(){
        $cantidad = $this->cantidad;
        //$this->descripcionTrabajo =  array_fill(0, $cantidad, '');
        //$cantidad = $this->cantidad;
        //dd($cantidad);
        
        return view('livewire.otm.form-otm', 
            compact('cantidad'
            ));
    }

    public function eliminarDetalleTrabajo($index){
        
        unset($this->descripcionTrabajo[$index]);
        
    }

    public function store(){

        $this->validate([
            'otm.codigo' => 'required',
            'otm.servicioId' => 'required',
            'otm.personalAtiendeId' => 'required',
            'otm.fechaInicio' => 'required',
            'otm.fechaFin' => 'required',
            'otm.descripcion' => 'required',
            'otm.estadoId' => 'required',
        ]);

        $otm = OtmTicket::create($this->otm);
        $this->reset('otm');
        $this->emit('otm-added', $otm->id);
    }

    public function guardarOtm(){

        dd($this->all());
    }

}
