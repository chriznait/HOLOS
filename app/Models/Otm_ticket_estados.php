<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otm_ticket_estados extends Model
{
    use HasFactory;
    protected $table = 'otm_ticket_estados';
    protected $fillable = [
        'descripcion'
    ];
    public $timestamps = false;

    public function otmTickets(){
        return $this->hasMany(OtmTicket::class,'idEstado');
    }


}
