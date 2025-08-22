<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();

        return view('sistema.configuracion.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('sistema.configuracion.usuarios.create');
    }

    public function store(StoreUsuarioRequest $request)
    {
        $data = $request->all();

        User::create($data);
    
        return redirect()->route('sistema.configuracion.usuarios.index');
    }

    public function edit(User $usuario)
    {
        return view('sistema.configuracion.usuarios.edit', compact('usuario'));
    }

    public function update(StoreUsuarioRequest $request, User $usuario)
    {
        $data = $request->all();

        $usuario->update($data);
    
        return redirect()->route('sistema.configuracion.usuarios.index');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
    
        return redirect()->route('sistema.configuracion.usuarios.index');
    }
}
