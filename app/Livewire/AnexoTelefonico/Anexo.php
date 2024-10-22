<?php

namespace App\Livewire\AnexoTelefonico;

use Livewire\Component;
use App\Models\AnexoTelefonico;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Anexo extends Component
{
    use WithPagination;

    public $tituloPagina;
    public $search;

    public function mount()
    {
        $this->tituloPagina = 'Anexo Telefónico';
        $this->search = '';
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $anexos = AnexoTelefonico
            ::with('servicio')
            ->withCount('servicio')
            ->where('descripcionLugar', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'asc')
            ->paginate(30);
        //dd($anexos->descripcion);
    
        return view('livewire.anexo-telefonico.anexo', compact('anexos'));
    }
}
