<?php

namespace App\Livewire\Rol;

use App\Models\Empleado;
use App\Models\Rol;
use App\Models\RolDetalle;
use App\Models\RolEmpleado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SubirRol extends Component
{
    use WithFileUploads;
    
    public $archivo;
    
    public $tituloModal, $idModal;
    public $rol;
    public $errores;

    function mount() : void {
        $this->tituloModal = "Subir rol";
        $this->idModal = "mdl-subir-rol";
        $this->rol = new Rol();
        $this->errores = [];
    }
    function inicializaDatos($id) : void {
        $this->rol = Rol::find($id);
        $this->archivo = null;
        $this->errores = [];
        $this->reset('archivo'); 
    }
    function cierraSubirRol(){
        $this->dispatch('closeModal', $this->idModal);
    }
    #[On('muestraSubirRol')]
    function muestraSubirRol($id) : void {
        $this->inicializaDatos($id);
        $this->dispatch('openModal', $this->idModal);
    }
    function rules() : array {
        return [
            'archivo' => 'required|mimes:xlsx|max:2048',
            'rol.filePath' => '',
            'rol.fileName' => '',
        ];
    }
    /* function validationAttributes() : Returntype {
        return [
            'archivo' => 'required|mimes:xlsx|max:2048'
        ];
    } */
    function guardarArchivo() : void {
        $this->validate();
        
        DB::beginTransaction();

        try {
            $originalName = $this->archivo->getClientOriginalName();
            $extension = $this->archivo->getClientOriginalExtension();
            $baseName = pathinfo($originalName, PATHINFO_FILENAME);
            
            $i = 1;
            $newName = $this->rol->anio.'_'.$this->rol->mes.'_'.$this->rol->departamentoId.'_'.$this->rol->servicioId.'.'.$extension;
            $path = 'files/roles';

            //si existe un archivo con igual nombre, cambia el nombre y lo guarda
            //si se sin el while simplemente reemplaza el 
            while (Storage::exists($path . '/' . $newName)) {
                $newName = $baseName . '_' . $i . '.' . $extension;
                $i++;
            }
            
            $filePath = $this->archivo->storeAs($path, $newName);

            $detalles = $this->guardaDetalles($filePath);

            if(empty($detalles)){
                $this->rol->filePath = $filePath;
                $this->rol->fileName = $originalName;
                $this->rol->save();
                $resp["type"] = 'success';
                $resp["message"] = 'Archivo cargado con exito';
                DB::commit();
                $this->cierraSubirRol();
                $this->dispatch('inicializaDatos', id: $this->rol->id)->to(DetalleRol::class);
            }else{
                DB::rollback();
                $this->errores = $detalles;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $resp["type"] = 'error';
            $resp["message"] = $e->getMessage();
        }
        if(isset($resp)) $this->dispatch('alert', $resp);
    }
    function guardaDetalles($filePath) : array {
        $dias = getDiasMes($this->rol->anio, $this->rol->mes);

        
        $absolutePath = storage_path('app/' . $filePath);
        RolEmpleado::where('rolId', $this->rol->id)->delete();
        // Cargar el archivo Excel
        if (Storage::exists($filePath)) {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($absolutePath);
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow(); // Última fila con datos
            /* $highestColumn = $sheet->getHighestColumn(); // Última columna con datos */
            /* $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); */
            $ini = 6;
            $errores = [];
            $items = [];
            for ($i=$ini; $i <= $highestRow; $i++) { 
                $nroDocumento = $sheet->getCell('A' . $i)->getValue();
                $nombre = $sheet->getCell('B' . $i)->getValue();

                if(empty($nroDocumento)){
                    break;
                }

                $empleado = Empleado::where('nroDocumento', $nroDocumento)->first();
                if(!is_null($empleado)){

                    $existe = RolEmpleado::where('empleadoId', $empleado->id)
                                            ->whereHas('rol', function($q){
                                                $q->where('anio', $this->rol->anio)
                                                    ->where('mes', $this->rol->mes)
                                                    ->where('id', '<>', $this->rol->id);
                                            })
                                            ->with('rol.departamento', 'rol.servicio')
                                            ->first();
                    if(is_null($existe)){
                        $rolEmpleado = RolEmpleado::create([
                            'rolId'         => $this->rol->id,
                            'empleadoId'    => $empleado->id,
                            'tipoContratoId' => $empleado->tipoContratoId,
                            'cargoId'       => $empleado->cargoId,
                            'profesionId'   => $empleado->profesionId,
                        ]);
                        
                        for ($j=3; $j < count($dias)+3; $j++) { 
                            $letra = numeroLetra($j);
                            $turno = $sheet->getCell($letra . $i)->getValue();
                            $dia = $sheet->getCell($letra . '5')->getValue();
                            if(!empty($turno)){
                                $items[] = [
                                    'rolEmpleadoId' => $rolEmpleado->id,
                                    'turno' => $turno,
                                    'dia' => $dia
                                ];
                            }
                        }
                        if($empleado->departamentoId != $this->rol->departamentoId && 
                            $empleado->servicioId != $this->rol->servicioId)
                        {
                            $empleado->departamentoId = $this->rol->departamentoId;
                            $empleado->servicioId = $this->rol->servicioId;
                            $empleado->save();
                        }
                    }else{
                        $errores[] = '('.$nroDocumento.') '.$nombre.', ya se encuentra registrado en otro rol';
                    }
                }else{
                    $errores[] = '('.$nroDocumento.') '.$nombre.', no fue encontrado';
                }
            }
            if(empty($errores))
                RolDetalle::insert($items);
            
        } else {
            $errores[] = "archivo no encontrado";
        }
        return $errores;
    }
    public function render()
    {
        return view('livewire.rol.subir-rol');
    }
}
