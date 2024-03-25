<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicio';

    function departamento() : BelongsTo {
        return $this->belongsTo(DepartamentoHospital::class, 'departamentoId');
    }
}
