<?php

namespace App\Livewire\Cie10;

use Livewire\Component;
use App\Models\Cie10hai;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Cie10 extends Component
{
    use WithPagination;
    
    public $tituloPagina;
    public $search;

    public function mount()
    {
        $this->tituloPagina = 'CIE-10';
        $this->search = '';
    }

    #[Layout('layouts.guest')] 
    public function render()
    {
        //$cie10x = Cie10hai::orderBy('codigo', 'asc')->paginate(30);
        $cie10x = Cie10hai::where('codigo', 'like', '%'.$this->search.'%')
            ->orWhere('descripcion', 'like', '%'.$this->search.'%')
            ->orWhere('descrip_grupo', 'like', '%'.$this->search.'%')
            ->orWhere('tipo', 'like', '%'.$this->search.'%')
            ->orWhere('descrip_tipo', 'like', '%'.$this->search.'%')
            ->orWhere('flag', 'like', '%'.$this->search.'%')
            ->orderBy('codigo', 'asc')
            ->paginate(30);
        //dd($cie10x);
        return view('livewire.cie10.cie10', compact('cie10x'));
    }
}
