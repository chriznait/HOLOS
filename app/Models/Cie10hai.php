<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cie10hai extends Model
{
    use HasFactory;
    protected $table = 'cie10hais';
    protected $fillable = ['codigo', 'descripcion', 'descrip_grupo', 'tipo','descrip_tipo', 'flag'];

}
