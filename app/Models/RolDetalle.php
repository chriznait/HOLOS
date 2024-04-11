<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RolDetalle extends Model
{
    use HasFactory;
    protected $table = "rol_personal_detalle";
    protected $guarded = [];

    function rTurno() : HasOne {
        return $this->hasOne(Turno::class, 'abrev', 'turno');
    }
}
