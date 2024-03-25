<?php
namespace App\Helpers;

use App\Models\RolMenu;
use Illuminate\Database\Eloquent\Model;
class Menu extends Model
{
    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['parentId']) {
                $children = array_merge(
                        $children, 
                        [ array_merge(
                            $line1, 
                            ['submenu' => $this->getChildren($data, $line1) ],
                        ) ]
                    );
            }
        }
        return $children;
    }
    public function optionsMenu()
    {
        $rolesId = auth()->user()->roles->pluck('id')->toArray();
        $menuIds = RolMenu::select('menuId')
                            ->whereIn('rolId', $rolesId)
                            ->where('ver', 1)
                            ->groupBy('menuId')
                            ->get()
                            ->pluck('menuId')
                            ->toArray();
        
        return $this->from('menu')
            ->whereIn('id', $menuIds)
            ->where('enabled', 1)
            ->orderby('parentId')
            ->orderby('order')
            ->orderby('name')
            ->get()
            ->toArray();
    }
    public static function menus()
    {
        $menus = new Menu();
        $data = $menus->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            if(is_null($line['parentId'])){
                $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
                $menuAll = array_merge($menuAll, $item);
            }
        }
        return $menuAll;
    }
}