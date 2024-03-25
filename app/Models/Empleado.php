<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleado';

    public function scopeSearch($query, $value)
    {
        return $query->where(function($q) use ($value){
            $q->where(DB::raw("CONCAT(apellidoPaterno, ' ', apellidoMaterno, ' ', nombres)"), 'like', '%'.$value.'%')
                ->orWhere('nroDocumento', 'like', '%'.$value.'%');
        });
    }

    function nombreCompleto() : string {
        if(!empty($this->attributes)){
            return $this->attributes['apellidoPaterno'].' '.$this->attributes['apellidoMaterno'].', '.$this->attributes['nombres'];
        }else{
            return "";
        }
    }
    public function area() : BelongsTo {
        return $this->belongsTo(Area::class, 'areaId');
    }
    public function departamento() : BelongsTo {
        return $this->belongsTo(DepartamentoHospital::class, 'departamentoId');
    }
    public function servicio() : BelongsTo {
        return $this->belongsTo(Servicio::class, 'servicioId');
    }
    public function profesion() : BelongsTo {
        return $this->belongsTo(Profesion::class, 'profesionId');
    }
    public function cargo() : HasOne {
        return $this->hasOne(Cargo::class, 'id', 'cargoId');
    }
}
