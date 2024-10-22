<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otm_modalidad_atenciones extends Model
{
    use HasFactory;
    protected $table = 'otm_modalidad_atenciones';
    protected $fillable = [
        'denominacion',
    ];
    public $timestamps = false;

    public function otmRegistros(){
        return $this->hasMany(Otm_registros::class,'idOtmModalidadAtencion');
    }
}
