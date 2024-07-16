<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_servicio extends Model
{
    use HasFactory;
    protected $table = 'sub_servicios';
    protected $fillable = [
        'descripcion', 'idServicio'
    ];
    public function servicio(){
        return $this->belongsTo(Servicio::class,'idServicio');
    }

    public $timestamps = false;
}
