<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;

class EquipoController extends Controller
{
    
    function buscarEquipo( Request $request ) {
        $buscar = $request->get('search');
        //dd($request->all());
        $equipos = Equipo::when(!empty($buscar), function($q) use ($buscar){
                                    $q->search($buscar)->get();
                                })
                                ->with('ambiente','servicio','tipoEquipo')
                                ->get()->map(function($item){
                                    $resp['id']             = $item->id;
                                    $resp['text']           = $item->denominacion;
                                    $resp['marca']          = $item->marca;
                                    $resp['modelo']         = $item->modelo;
                                    $resp['serie']          = $item->serie;
                                    $resp['codPatrimonial'] = $item->codPatrimonial;
                                    $resp['ambiente']       = $item->ambiente ? $item->ambiente->descripcion : null;
                                    $resp['servicio']        = $item->servicio ? $item->servicio->descripcion : null;
                                    $resp['tipoEquipo']     = $item->tipoEquipo ? $item->tipoEquipo->descripcion : null;

                                    return $resp;
                                });
        return response()->json([
            'results' => $equipos
        ]);
    }
}
