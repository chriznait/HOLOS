<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;
    protected $table = 'ambientes';
    protected $fillable = [
        'descripcion', 'codigo', 'idServicio', 'idSubservicio'
    ];
    public function servicio(){
        return $this->belongsTo(Servicio::class,'idServicio');
    }
    public function subservicio(){
        return $this->belongsTo(Sub_servicio::class,'idSubservicio');
    }
    
    public $timestamps = false;
}
