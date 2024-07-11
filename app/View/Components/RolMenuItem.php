<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RolMenuItem extends Component
{
    public $menu;
    public function __construct($menu)
    {
        $this->menu = $menu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.rol-menu-item');
    }
}
