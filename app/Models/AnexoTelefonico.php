<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnexoTelefonico extends Model
{
    use HasFactory;
    protected $table = 'anexo_telefonicos';
    protected $fillable = ['idServicio', 'descripcionLugar', 'anexo'];

    function servicio(): BelongsTo {
        return $this->belongsTo(Servicio::class, 'idServicio');
    }
}
