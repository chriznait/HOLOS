<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoPermiso extends Model
{
    use HasFactory;
    protected $table = 'estado_permiso';
    protected $fillable = ['descripcion', 'class'];
}
