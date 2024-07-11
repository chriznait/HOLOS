<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $modalId;
    public $modalTitulo;
    public $tipo;
    public $guardar;

    public function __construct($modalTitulo, $modalId = "modal-1", $tipo = "", $guardar="guardar")
    {
        $this->modalTitulo   = $modalTitulo;
        $this->modalId      = $modalId;
        $this->tipo         = $tipo;
        $this->guardar         = $guardar;
        
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
