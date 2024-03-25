<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Perfil extends Component
{
    public $tituloPagina;
    public $empleado, $user;
    public $password, $password1, $password2;

    function mount() : void {
        $this->tituloPagina = "Mi Perfil";
        $this->user = auth()->user();
        $this->empleado = $this->user->empleado;
    }
    function validationAttributes() : array {
        return [
            'password' => 'contraseña',
            'password1' => 'nueva contraseña',
            'password2' => 'confirma nueva contraseña',
        ];
    }
    function guardarContra() : void {

        if(!empty($this->password)){
            $this->validate([
                'password' => 'required',
                'password1' => 'required|same:password2',
                'password2' => 'required'
            ]);
            if(Hash::check($this->password, $this->user->password)){
                $this->user->password = Hash::make('password1');
                $this->user->save();

                $this->password = "";
                $this->password1 = "";
                $this->password2 = "";

                $resp['type'] = 'success';
                $resp['message'] = 'Actualizado con exito';
            }else{
                $resp['type'] = 'error';
                $resp['message'] = 'La contraseña actual es incorrecta';
            }
            $this->dispatch('alert', $resp);
        }
    }
    public function render()
    {
        return view('livewire.perfil');
    }
}
