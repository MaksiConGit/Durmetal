<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTerminalRequest;
use App\Models\ImpresoraFiscal;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerminalController extends Controller
{
    public function index()
    {
        $terminales = Terminal::all();

        return view('sistema.configuracion.terminales.index', compact('terminales'));
    }

    public function create()
    {
        $impresoras_fiscales = ImpresoraFiscal::all();

        return view('sistema.configuracion.terminales.create', compact('impresoras_fiscales'));
    }

    public function store(StoreTerminalRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;

        Terminal::create($data);
    
        return redirect()->route('sistema.configuracion.terminales.index');
    }

    public function edit(Terminal $terminal)
    {
        $impresoras_fiscales = ImpresoraFiscal::all();

        return view('sistema.configuracion.terminales.edit', compact('terminal', 'impresoras_fiscales'));
    }

    public function update(StoreTerminalRequest $request, Terminal $terminal)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $terminal->update($data);
    
        return redirect()->route('sistema.configuracion.terminales.index');
    }

    public function destroy(Terminal $terminal)
    {
        $terminal->delete();
    
        return redirect()->route('sistema.configuracion.terminales.index');
    }
}
