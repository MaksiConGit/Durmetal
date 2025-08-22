<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoMensajeUsuarioRequest;
use App\Models\TipoMensajeUsuario;
use Illuminate\Http\Request;

class TipoMensajeController extends Controller
{
    public function index()
    {
        $tipos_mensajes_usuario = TipoMensajeUsuario::all();

        return view('sistema.configuracion.tipos-de-mensajes.index', compact('tipos_mensajes_usuario'));
    }

    public function create()
    {
        return view('sistema.configuracion.tipos-de-mensajes.create');
    }

    public function store(StoreTipoMensajeUsuarioRequest $request)
    {
        $data = $request->all();

        TipoMensajeUsuario::create($data);
    
        return redirect()->route('sistema.configuracion.tipos-de-mensajes.index');
    }

    public function edit(TipoMensajeUsuario $tipo_mensaje_usuario)
    {
        return view('sistema.configuracion.tipos-de-mensajes.edit', compact('tipo_mensaje_usuario'));
    }

    public function update(StoreTipoMensajeUsuarioRequest $request, TipoMensajeUsuario $tipo_mensaje_usuario)
    {
        $data = $request->all();

        $tipo_mensaje_usuario->update($data);
    
        return redirect()->route('sistema.configuracion.tipos-de-mensajes.index');
    }

    public function destroy(TipoMensajeUsuario $tipo_mensaje_usuario)
    {
        $tipo_mensaje_usuario->delete();
    
        return redirect()->route('sistema.configuracion.tipos-de-mensajes.index');
    }
}
