<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolMenu extends Model
{
    use HasFactory;

    protected $table        = 'rol_menu';
    protected $fillable     = ['rolId', 'menuId', 'ver', 'crear', 'editar', 'eliminar'];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
