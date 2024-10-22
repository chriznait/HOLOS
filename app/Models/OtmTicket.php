<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtmTicket extends Model
{
    use HasFactory;
    protected $table = 'otm_tickets';
    protected $fillable = [
        'idSolicita', 'idServicio', 'idPersonalAtiende', 'idEstadoTicket',
        'idRecepciona', 'fechaCreacion', 'fechaAsignado', 'fechaFinalizado',
        'equipo', 'detalleProblema', 'ubicacion' , 'tipoAtencion', 'observacion',
        'anexo', 'fechaRecepcion'
    ];
    public function servicio(){
        return $this->belongsTo(Servicio::class,'idServicio');
    }
    public function personalAtiende(){
        return $this->belongsTo(Empleado::class,'idSolicita');
    }
    public function personalRecepciona(){
        return $this->belongsTo(Empleado::class,'idRecepciona');
    }
    public function personalAsignado(){
        return $this->belongsTo(Empleado::class,'idPersonalAtiende');
    }
    public function estado(){
        return $this->belongsTo(Otm_ticket_estados::class,'idEstadoTicket');
    }
    public $timestamps = false;

    
}
