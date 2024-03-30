<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rol extends Model
{
    use HasFactory;
    protected $table = "rol_personal";
    protected $guarded = [];

    function estado() : HasOne {
        return $this->hasOne(EstadoRol::class, 'id', 'estadoId');
    }
    function departamento() : HasOne {
        return $this->hasOne(DepartamentoHospital::class, 'id', 'departamentoId');
    }
    function servicio() : HasOne {
        return $this->hasOne(Servicio::class, 'id', 'servicioId');
    }
    function mes(){
        return getMeses()[$this->attributes['mes']];
    }
}
