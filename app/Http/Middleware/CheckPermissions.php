<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\RolMenu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $rutasParaValidar = Menu::get()->pluck('routeName')->toArray();
        /* $rutasAdicionales = ['permiso.solicita'];
        $rutasParaValidar = array_merge($rutasParaValidar, $rutasAdicionales); */
        
        $rutaActual = $request->route()->getName();

        if(!in_array($rutaActual, $rutasParaValidar)){
            return $next($request);
        }

        $menuId = Menu::firstWhere('routeName', $request->route()->getName())->id;
        $rolesId = auth()->user()->roles->pluck('id')->toArray();

        $permissions = RolMenu::selectRaw('
                                        MAX(CASE WHEN ver = 1 THEN 1 ELSE 0 END) AS ver,
                                        MAX(CASE WHEN crear = 1 THEN 1 ELSE 0 END) AS crear,
                                        MAX(CASE WHEN editar = 1 THEN 1 ELSE 0 END) AS editar,
                                        MAX(CASE WHEN eliminar = 1 THEN 1 ELSE 0 END) AS eliminar
                                    ')
                                ->where('menuId', $menuId)
                                ->whereIn('rolId', $rolesId)
                                ->first()->toArray();

        $request->attributes->add(['permisos' => $permissions]);
        return $next($request);
    }
}
