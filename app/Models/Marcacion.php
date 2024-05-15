<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marcacion extends Model
{
    use HasFactory;
    protected $table = 'marcaciones';
    protected $guarded = [];

    function usuario() : BelongsTo {
        return $this->belongsTo(User::class, 'userId');
    }
    function detalle() : HasMany {
        return $this->hasMany(MarcacionDetalle::class, 'marcacionId');
    }
}
