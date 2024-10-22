<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicio';

    function departamento() : BelongsTo {
        return $this->belongsTo(DepartamentoHospital::class, 'departamentoId');
    }
    function roles() : HasMany {
        return $this->hasMany(Rol::class, 'servicioId');
    }
    function anexosTelefonicos() : HasMany {
        return $this->hasMany(AnexoTelefonico::class, 'idServicio');
    }
}
