<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Permiso extends Model
{
    use HasFactory;
    protected $table = 'permiso';
    protected $guarded = [];

    function estado() : BelongsTo {
        return $this->belongsTo(EstadoPermiso::class, 'estadoId');
    }
    function empleado() : HasOne {
        return $this->hasOne(Empleado::class, 'id', 'empleadoId');
    }
    function autoriza() : HasOne {
        return $this->hasOne(Empleado::class, 'id', 'autorizaId');
    }
    function departamento() : HasOne {
        return $this->hasOne(DepartamentoHospital::class, 'id', 'departamentoId');
    }
    function servicio() : HasOne {
        return $this->hasOne(Servicio::class, 'id', 'servicioId');
    }
    function tipo() : HasOne {
        return $this->hasOne(TipoPermiso::class, 'id', 'tipoId');
    }
}
