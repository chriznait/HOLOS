<?php

namespace App\Livewire\Asistencia;

use App\Models\Marcacion;
use App\Models\MarcacionDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Registros extends Component
{
    use WithPagination, WithFileUploads;
    public $crud, $fecha;
    public $tituloPagina, $tituloModal;
    public $marcacion, $archivo;

    public $tituloDetalle, $idDetalle, $registro;

    function mount(Request $request) : void {
        $this->crud = $request->attributes->get('permisos');
        $this->fecha = date('Y-m-d');
        $this->tituloPagina = "Registro de marcaciones";
        $this->reseteaDatos();

        $this->idDetalle = "mdl-detalle";
        $this->tituloDetalle = "Detalle de registro";
        $this->reseteaDetalle();
    }
    function reseteaDatos() : void {
        $this->marcacion = new Marcacion();
        $this->marcacion->fecha = date('Y-m-d');
        $this->archivo = "";
    }
    function inicializaDatos($id) : void {
        if(empty($id)){
            $this->tituloModal = "Subir marcaciones";
            $this->reseteaDatos();
        }else{
            $this->tituloModal = "Editar marcaciones";
            $this->marcacion = Marcacion::find($id);
        }
    }
    
    function muestraModal($id = "") : void {
        $this->inicializaDatos($id);
        $this->resetValidation();
        $this->dispatch('openModal');
    }
    function cierraModal(){
        $this->dispatch('closeModal');
    }

    function rules() : array {
        return [
            'marcacion.fecha' => 'required|date',
            'archivo' => 'required|mimes:xlsx'
        ];
    }
    function guardar() : void {
        $this->validate();

        DB::beginTransaction();    
        
        try {
            //para subir archivo
            $originalName = $this->archivo->getClientOriginalName();
            $extension = $this->archivo->getClientOriginalExtension();
            /* $baseName = pathinfo($originalName, PATHINFO_FILENAME); */
            $baseName = date('Ymd', strtotime($this->marcacion->fecha));
            
            
            $newName = $baseName.'.'.$extension;
            $path = 'files/marcaciones';

            //si existe un archivo con igual nombre, cambia el nombre y lo guarda
            //si se sin el while simplemente reemplaza el 
            $i = 1;
            while (Storage::exists($path . '/' . $newName)) {
                $newName = $baseName . '_' . $i . '.' . $extension;
                $i++;
            }
            
            $filePath = $this->archivo->storeAs($path, $newName);

            $respuesta = $this->guardaDetalles($filePath);

            $this->marcacion->archivo = $filePath;
            $this->marcacion->cantRegistros = count($respuesta['data']);

            if(!is_null($this->marcacion->id) && $this->marcacion->id != ""){
                $message = "Actualizado con exito";
            }else{
                $message = "Registrado con exito";
                $this->marcacion->userId = Auth::user()->id;
            }
            $this->marcacion->save();

            foreach ($respuesta['data'] as $item) {
                MarcacionDetalle::create(array_merge($item, ['marcacionId' => $this->marcacion->id]));
            }

            $resp["type"] = 'success';
            $resp["message"] = $message;

            DB::commit();
            
            $this->cierraModal();
        } catch (\Exception $e) {
            DB::rollback();
            $resp["type"] = 'error';
            $resp["message"] = 'No se pudo guardar los datos'. $e->getMessage();
        } 
        $this->dispatch('alert', $resp);
    }
    function guardaDetalles($filePath) : array {
        
        $absolutePath = storage_path('app/' . $filePath);
        $respuesta = [];
        
        // Cargar el archivo Excel
        if (Storage::exists($filePath)) {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($absolutePath);
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow(); // Última fila con datos
            /* $highestColumn = $sheet->getHighestColumn(); // Última columna con datos */
            /* $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); */
            $ini = 2;
            for ($i=$ini; $i <= $highestRow; $i++) { 
                

                $codigo = preg_replace('/[^0-9]/', '', $sheet->getCell('A' . $i)->getValue());
                $nombre = $sheet->getCell('B' . $i)->getValue();
                $hora = $sheet->getCell('D' . $i)->getValue();
                $punto = $sheet->getCell('F' . $i)->getValue();

                if(empty($codigo)) break;

                $timestamp = Date::excelToTimestamp($hora);

                $respuesta['data'][] = [
                    'codigo' => $codigo,
                    'nombre' => $nombre,
                    'marcacion' => Carbon::createFromTimestampUTC($timestamp)->toDateTimeString(),
                    'punto' => $punto
                ];
            }
            
        } else {
            $respuesta['errores'] = "archivo no encontrado";
        }
        return $respuesta;
    }

    function eliminar($id){
        DB::beginTransaction();

        try {
            $marcacion = Marcacion::find($id);

            if(is_null($marcacion)){
                $resp["type"] = 'error';
                $resp["message"] = 'No encontrado';
            }else{
                $marcacion->delete();
                $resp["type"] = 'success';
                $resp["message"] = 'Eliminado con exito';
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $resp["type"] = 'error';
            $resp["message"] = 'No se pudo eliminar';
        }
        $this->dispatch('alert', $resp);        
    }
    //////////////////////////////////////////////////////////////////////////////////////
    function reseteaDetalle() : void {
        $this->registro = new Marcacion();
    }
    function muestraModalDetalle($id = "") : void {
        /* $this->inicializaDatos($id);
        $this->resetValidation(); */
        $this->registro = Marcacion::with('detalle.empleado.profesion','detalle.empleado.cargo')
                                    ->find($id);
        $this->dispatch('openModal', $this->idDetalle);
    }
    function cierraModalDetalle(){
        $this->dispatch('closeModal', $this->idDetalle);
    }
    public function render()
    {
        $marcaciones = Marcacion::with('usuario.empleado')->where('fecha', $this->fecha)
                        ->orderBy('id', 'desc')->paginate(10);
        return view('livewire.asistencia.registros', compact('marcaciones'));
    }
}
