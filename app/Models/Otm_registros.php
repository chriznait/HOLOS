<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otm_registros extends Model
{
    use HasFactory;
    protected $table = 'otm_registros';

    protected $fillable = [
        'idServAtiende',
        'idServSolicita',
        'idEquipo',
        'tipoMantenimiento',
        'numero',
        'fechaOtm',
        'ubiFisica',
        'descripcionProblema',
        'idOtmEstadoEquipo',
        'fechaSolicita',
        'fechaRecepcion',
        'diagTecnico',
        'prioridad',
        'idOtmModalidadAtencion',
        'idTicket',
        'fechaInicio',
        'fechaFin',
        'garantiaServicio',
        'costoServicio',
        'recomendaciones',
        'estadoFinal',
        'costoManoObra',
        'costoMateriales',
        'costoOtros',
        'costoTotal',
        'detalleOtrosCostos',
        'idPersonalRegistra',
        'fechaRegistro',
        'observaciones',
        'idRevision',
        'fechaRevision',
        'idJefeMantenimiento',
        'fechaJefeMantenimiento',
        'idJefeArea',
        'fechaJefeArea'
    ];

    public function servicioAtiende(){
        return $this->belongsTo(Servicio::class,'idServAtiende');
    }
    public function servicioSolicita(){
        return $this->belongsTo(Servicio::class,'idServSolicita');
    }
    public function equipo(){
        return $this->belongsTo(Equipo::class,'idEquipo');
    }
    public function otmModalidadAtencion(){
        return $this->belongsTo(Otm_modalidad_atenciones::class,'idOtmModalidadAtencion');
    }
}
