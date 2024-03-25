<?php

namespace App\Livewire;

use Livewire\Component;

class Inicio extends Component
{
    public $tituloPagina;

    public function mount(): void{
        $this->tituloPagina = "Inicio";
    }

    public function render()
    {        
        return view('livewire.inicio');
    }
}
