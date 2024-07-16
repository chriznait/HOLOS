<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    protected $table = 'equipos';
    protected $fillable = [
        'denominacion', 'marca', 'modelo',
        'serie','codPatrimonial','idAmbiente','idServicio',
        'esProyecto','idTipoEquipo'
    ];
    public function ambiente(){
        return $this->belongsTo(Ambiente::class,'idAmbiente');
    }
    public function servicio(){
        return $this->belongsTo(Servicio::class,'idServicio');
    }
    public function tipoEquipo(){
        return $this->belongsTo(Tipo_equipo::class,'idTipoEquipo');
    }
}