<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DepartamentoHospital extends Model
{
    use HasFactory;
    protected $table = 'departamento_hospital';

    protected $fillable = ['descripcion'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    function servicios() : HasMany {
        return $this->hasMany(Servicio::class, 'departamentoId');
    }
}
