<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarcacionDetalle extends Model
{
    use HasFactory;
    protected $table = 'marcaciones_detalle';
    protected $guarded = [];

    function empleado() : BelongsTo {
        return $this->belongsTo(Empleado::class, 'codigo', 'codigo');
    }
}
