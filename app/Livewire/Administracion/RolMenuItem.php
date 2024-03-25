<?php

namespace App\Livewire\Administracion;

use Livewire\Component;

class RolMenuItem extends Component
{
    public $item, $nivel;

    function mount($item, $nivel) : void {
        $this->item = $item;
        $this->nivel = $nivel;
    }
    public function render()
    {
        return view('livewire.administracion.rol-menu-item');
    }
}
