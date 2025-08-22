<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMensajeUsuarioRequest;
use App\Models\MensajeUsuario;
use Illuminate\Http\Request;

class MensajeUsuarioController extends Controller
{
    public function index()
    {
        $mensajes_usuario = MensajeUsuario::all();

        return view('sistema.configuracion.mensajes-de-usuario.index', compact('mensajes_usuario'));
    }

    public function create()
    {
        return view('sistema.configuracion.mensajes-de-usuario.create');
    }

    public function store(StoreMensajeUsuarioRequest $request)
    {
        $data = $request->all();

        MensajeUsuario::create($data);
    
        return redirect()->route('sistema.configuracion.mensajes-de-usuario.index');
    }

    public function edit(MensajeUsuario $mensaje_usuario)
    {
        return view('sistema.configuracion.mensajes-de-usuario.edit', compact('mensaje_usuario'));
    }

    public function update(StoreMensajeUsuarioRequest $request, MensajeUsuario $mensaje_usuario)
    {
        $data = $request->all();

        $mensaje_usuario->update($data);
    
        return redirect()->route('sistema.configuracion.mensajes-de-usuario.index');
    }

    public function destroy(MensajeUsuario $mensaje_usuario)
    {
        $mensaje_usuario->delete();
    
        return redirect()->route('sistema.configuracion.mensajes-de-usuario.index');
    }
}
