<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTerminalRequest;
use App\Models\Terminal;
use Illuminate\Http\Request;

class TerminalController extends Controller
{
    public function index()
    {
        $terminales = Terminal::all();

        return view('sistema.configuracion.terminales.index', compact('terminales'));
    }

    public function create()
    {
        return view('sistema.configuracion.terminales.create');
    }

    public function store(StoreTerminalRequest $request)
    {
        $data = $request->all();

        Terminal::create($data);
    
        return redirect()->route('sistema.configuracion.terminales.index');
    }

    public function edit(Terminal $terminal)
    {
        return view('sistema.configuracion.terminales.edit', compact('terminal'));
    }

    public function update(StoreTerminalRequest $request, Terminal $terminal)
    {
        $data = $request->all();

        $terminal->update($data);
    
        return redirect()->route('sistema.configuracion.terminales.index');
    }

    public function destroy(Terminal $terminal)
    {
        $terminal->delete();
    
        return redirect()->route('sistema.configuracion.terminales.index');
    }
}
