<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RolEmpleado extends Model
{
    use HasFactory;
    protected $table = "rol_personal_empleado";
    protected $guarded = [];

    function detalles() : HasMany {
        return $this->hasMany(RolDetalle::class, 'rolEmpleadoId');
    }
    function empleado() : HasOne {
        return $this->hasOne(Empleado::class, 'id', 'empleadoId');
    }
    function rol() : BelongsTo {
        return $this->belongsTo(Rol::class, 'rolId');
    }
}
