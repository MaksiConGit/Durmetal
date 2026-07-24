<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Component
{
    public $Nombre;
    public $Usuario;
    public $Contraseña;
    public $Rol;
    public $CobraPremio = false;
    public $IndiceBasePremio;

    public $editNombre;
    public $editUsuario;
    public $editContraseña;
    public $editRol;
    public $editCobraPremio = false;
    public $editIndiceBasePremio;

    public $roles = [];

    public $usuarios;

    public $usuarioSeleccionadoId;


    public function mount()
    {
        $this->roles = Role::all();

        $this->usuarios = User::all();
    }

    protected function rules()
    {
        return [
            'Nombre' => 'required|string|max:255|unique:users,Nombre',
            'Usuario' => 'required|string|max:255|unique:users,Usuario',
            'Contraseña' => 'required|min:8',
            'CobraPremio' => 'required|bool',
            'IndiceBasePremio' => 'nullable',
            'Rol' => 'required|exists:roles,id',
        ];
    }

    public function seleccionarUsuario($id)
    {
        $this->usuarioSeleccionadoId = $id;

        $usuario = User::find($id);

        if (!$usuario) return;

        $this->editNombre = $usuario->Nombre;
        $this->editUsuario = $usuario->Usuario;

        $this->editContraseña = '';

        $this->editRol = $usuario->roles->first()->id;

        $this->editCobraPremio = (bool) $usuario->CobraPremio;
        $this->editIndiceBasePremio = $usuario->IndiceBasePremio;
    }


    public function guardarUsuario()
    {
        $this->validate();

        $usuario_ = User::create([
            'Nombre' => $this->Nombre,
            'Usuario' => $this->Usuario,
            'CobraPremio' => $this->CobraPremio,
            'IndiceBasePremio' => $this->IndiceBasePremio ?? 0,
            'Contraseña' => Hash::make($this->Contraseña),

            'Activo' => 1,
            'Firma' => null,
            'FechaCreacion' => now(),
            'FechaActualizacion' => now(),
            'CreadoPor' => auth()->id(),
            'ActualizadoPor' => auth()->id(),
        ]);

        $usuario_->Firma = 'firmas/firma'.$usuario_->id.'.jpg';
        $usuario_->save();

        $Rol = Role::find($this->Rol);

        $usuario_->assignRole($Rol);

        $this->usuarios = User::all();

        $this->reset([
            'Nombre',
            'Usuario',
            'Contraseña',
            'Rol',
            'CobraPremio',
            'IndiceBasePremio'
        ]);

        $this->dispatch('usuarioCreado');
    }

    public function editarUsuario()
    {
        $this->validate([
            'editNombre' => 'required|string|max:255|unique:users,Nombre,' . $this->usuarioSeleccionadoId,
            'editUsuario' => 'required|string|max:255|unique:users,Usuario,' . $this->usuarioSeleccionadoId,
            'editRol' => 'required|exists:roles,id',
            'editCobraPremio' => 'required|bool',
            'editIndiceBasePremio' => 'nullable',
        ]);

        $usuario = User::find($this->usuarioSeleccionadoId);

        if (!$usuario) {
            return;
        }

        $usuario->Nombre = $this->editNombre;
        $usuario->Usuario = $this->editUsuario;
        $usuario->CobraPremio = $this->editCobraPremio;
        $usuario->IndiceBasePremio = $this->editIndiceBasePremio ?? 0;
 
        $usuario->FechaActualizacion = now();
        $usuario->ActualizadoPor = auth()->id();

        $usuario->save();

        $rol = Role::find($this->editRol);

        if ($rol) {
            $usuario->syncRoles([$rol]);
        }

        $this->usuarios = User::all();

        $this->resetValidation();

        $this->dispatch('usuarioEditado');
    }

    public function eliminarUsuario($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return;
        }

        if ($usuario->id == auth()->id()) {
            session()->flash('mensaje', 'No podés eliminar tu propio usuario.');
            return;
        }

        $usuario->syncRoles([]);

        $usuario->delete();

        $this->usuarios = User::all();

        $this->usuarioSeleccionadoId = null;

        session()->flash('mensaje', 'Usuario eliminado correctamente');
    }

    public function render()
    {
        return view('livewire.usuarios');
    }
}
