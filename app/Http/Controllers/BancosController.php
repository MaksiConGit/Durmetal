<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBancosRequest;
use App\Models\Banco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BancosController extends Controller
{
    public function index()
    {
        $bancos = Banco::all();

        return view('sistema.actualizaciones.bancos.index', compact('bancos'));
    }

    public function create()
    {
        return view('sistema.actualizaciones.bancos.create');
    }

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

    public function edit(Banco $banco)
    {
        return view('sistema.actualizaciones.bancos.edit', compact('banco'));
    }

    public function update(StoreBancosRequest $request, Banco $banco)
    {
        $data = $request->all();

        $data['FechaActualizacion'] = now();
        $data['ActualizadoPor'] = Auth::id();

        $banco->update($data);
    
        return redirect()->route('sistema.bancos.index');
    }

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
