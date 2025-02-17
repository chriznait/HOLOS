<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        if(isset($this->attributes['mes'])){
            return getMeses()[$this->attributes['mes']];
        }
        return "";
    }
    function registra(): HasOne{
        return $this->hasOne(Empleado::class, 'id', 'registraId');
    }
    function publica(): HasOne{
        return $this->hasOne(Empleado::class, 'id', 'publicaId');
    }
    function revisa(): HasOne{
        return $this->hasOne(Empleado::class, 'id', 'revisaId');
    }
    function fechaPublicacion() : string {
        if(isset($this->attributes['fechaHoraPublica']))
            return date('d/m/Y H:i', strtotime($this->attributes['fechaHoraPublica']));
        return "";
    }
    function fechaCreacion() : string {
        if(isset($this->attributes['created_at']))
            return date('d/m/Y H:i', strtotime($this->attributes['created_at']));
        return "";
    }
    function fechaRevision() : string {
        if(isset($this->attributes['fechaHoraRevisa']))
            return date('d/m/Y H:i', strtotime($this->attributes['fechaHoraRevisa']));
        return "";
    }
    function empleados() : HasMany {
        return $this->hasMany(RolEmpleado::class, 'rolId');
    }
}
