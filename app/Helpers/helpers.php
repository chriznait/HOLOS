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
if(!function_exists('getMeses')){
    function getMeses(): array{
        $meses = [
            1 => 'Enero', 
            2 => 'Febrero', 
            3 => 'Marzo', 
            4 => 'Abril', 
            5 => 'Mayo', 
            6 => 'Junio',
            7 => 'Julio', 
            8 => 'Agosto', 
            9 => 'Septiembre', 
            10 => 'Octubre', 
            11 => 'Noviembre', 
            12 => 'Diciembre'
        ];
        return $meses;
    }
}
if(!function_exists('getAnios')){
    function getAnios(): array{
        $anioInicial = 2024;
        $anioActual = (int) date('Y');
        $mesActual = (int) date('m');
        $rango = $mesActual == 12 ? 2 : 1;
        $anios = [];
        for ($i=$anioInicial; $i < $anioActual + $rango; $i++) { 
            $anios[$i] = $i;
        }
        return $anios;
    }
}
if(!function_exists('numeroLetra')){
    function numeroLetra($columnNumber) : string{
        $letters = '';
        while ($columnNumber > 0) {
            $remainder = ($columnNumber - 1) % 26;
            $letters = chr(65 + $remainder) . $letters;
            $columnNumber = (int)(($columnNumber - $remainder) / 26);
        }
        return $letters;
    }
}
if(!function_exists('getDiasMes')){
    function getDiasMes($anio, $mes) : array{
        $date = Carbon::create($anio, $mes, 1);

        $numDays = $date->daysInMonth;
        $resp = [];
        for ($i=1; $i <= $numDays ; $i++) { 
            $dia = ucwords(Carbon::create($anio, $mes, $i)->translatedFormat('l'));
            $resp[$i] = [
                'dia' => $dia,
                'inicial' => $dia[0]
            ];
        }
        return $resp;
    }
}
    