<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    function buscarEmpleado(Request $request) {
        $buscar = $request->get('search');

        /* $respuesta = [];
        if(!empty($buscar)){
            $empleados = Empleado::search($buscar)->get();
            foreach ($empleados as $emp) {
                $respuesta[] = [
                    'id' => $emp->id,
                    'text' => $emp->nombreCompleto()
                ];
            }
        } */
        $empleados = Empleado::when(!empty($buscar), function($q) use ($buscar){
                                    $q->search($buscar)->get();
                                })
                                ->with('departamento','profesion','servicio','cargo')
                                ->get()->map(function($item){
                                    $resp['id']             = $item->id;
                                    $resp['text']           = $item->nombreCompleto();
                                    $resp['nroDocumento']   = $item->nroDocumento;
                                    $resp['codigo']         = $item->codigo;
                                    $resp['departamento']   = $item->departamento?->descripcion;
                                    $resp['servicio']       = $item->servicio?->descripcion;
                                    $resp['cargo']          = $item->cargo?->descripcion;
                                    $resp['profesion']      = $item->profesion?->descripcion;

                                    return $resp;
                                });
        return response()->json([
            'results' => $empleados
        ]);
    }
}
