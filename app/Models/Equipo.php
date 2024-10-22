<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Iluminate\Support\Facades\DB;


class Equipo extends Model
{
    use HasFactory;
    protected $table = 'equipos';
    protected $fillable = [
        'denominacion', 'marca', 'modelo',
        'serie','codPatrimonial','idAmbiente','idServicio',
        'esProyecto','idTipoEquipo'
    ];

    public function scopeSearch($query, $value){
        //dd($value);
        return $query->where(function($q) use ($value){
            $q->where('denominacion','like','%'.$value.'%')
                ->orWhere('marca','like','%'.$value.'%')
                ->orWhere('modelo','like','%'.$value.'%')
                ->orWhere('serie','like','%'.$value.'%')
                ->orWhere('codPatrimonial','like','%'.$value.'%');
        });
    }

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