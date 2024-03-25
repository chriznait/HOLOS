<?php

use App\Models\Sisgalen\TipoEdad;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if (! function_exists('select_values')) {
    function select_values($table, $field, $where = [], $order = "", $key = "id")
    {
        $datas = DB::table($table);
        if(!empty($order))
            $datas->orderBy($order[0], $order[1]);
        if(!empty($where)){
            if(count($where) == 2)
                $datas->where($where[0], $where[1]);
            else if(count($where) == 3)
                $datas->where($where[0], $where[1], $where[2]);
        }
        $datas = $datas->get();
        
        $resp = [];

        foreach ($datas as $item)
            $resp[$item->$key] = $item->$field;

        return $resp;
    }
}
if(!function_exists('encoding')){
    function encoding($string): string{
        return mb_convert_encoding($string, "ISO-8859-1", "UTF-8");
    }
}
if(!function_exists('trimString')){
    function trimString ( $cadena, $longitud = 75 ) {
        //Eliminamos las etiquetas HTML
        $cadena = trim ( strip_tags ( $cadena ) );
        
        if ( strlen ( $cadena ) > $longitud ) {
            //Acortamos la cadena a la longitud dada
            $cadena = substr ( $cadena, 0, $longitud + 1 );
            
            //Expresión regular de espacio en blanco
            $regExp = "/[\s]|&nbsp;/";              
            
            //Dividimos la cadena en palabras y la guardamos en un array        
            $palabras = preg_split ( $regExp, $cadena, -1, PREG_SPLIT_NO_EMPTY ); 
            
            //Buscamos la expresión regular al final de la cadena
            preg_match ( $regExp, $cadena, $ultimo, 0, $longitud ); 
            
            if ( empty ( $ultimo ) ) {
                //Si la última palabra no estaba seguida por un espacio en blanco,
                //la eliminamos del conjunto de palabras
                array_pop ( $palabras );
            }
            
            //Creamos la cadena resultante por la unión del conjunto de palabras
            $cadena = implode ( ' ', $palabras );
        }
        
        return $cadena;
    }
}

    