<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBancosRequest;
use App\Models\Banco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BancosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bancos = Banco::all();

        return view('sistema.actualizaciones.bancos.index', compact('bancos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sistema.actualizaciones.bancos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBancosRequest $request)
    {
        $data = $request->all();

        $data['FechaCreacion'] = now();
        $data['CreadoPor'] = Auth::id();
        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();
        $data['Activo'] = 1;
        $data['Archivado'] = 0;

        Banco::create($data);
    
        return redirect()->route('sistema.bancos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banco $banco)
    {
        return view('sistema.actualizaciones.bancos.edit', compact('banco'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBancosRequest $request, Banco $banco)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $banco->update($data);
    
        return redirect()->route('sistema.bancos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banco $banco)
    {
        foreach ($banco->chequesCobro as $cheque_cobro) {
            $cheque_cobro->update([
                'IdBanco' => null
            ]);
        }

        foreach ($banco->chequesPago as $cheque_pago) {
            $cheque_pago->update([
                'IdBanco' => null
            ]);
        }

        $banco->delete();
    
        return redirect()->route('sistema.bancos.index');
    }
}
