<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolEmpleado extends Model
{
    use HasFactory;
    protected $table = "rol_personal_empleado";
    protected $guarded = [];
}
