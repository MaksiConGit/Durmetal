<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImpresoraFiscalRequest;
use App\Models\ImpresoraFiscal;
use Illuminate\Http\Request;

class ImpresoraFiscalController extends Controller
{
    public function index()
    {
        $impresoras_fiscales = ImpresoraFiscal::all();

        return view('sistema.configuracion.impresoras-fiscales.index', compact('impresoras_fiscales'));
    }

    public function create()
    {
        return view('sistema.configuracion.impresoras-fiscales.create');
    }

    public function store(StoreImpresoraFiscalRequest $request)
    {
        $data = $request->all();

        ImpresoraFiscal::create($data);
    
        return redirect()->route('sistema.configuracion.impresoras-fiscales.index');
    }

    public function edit(ImpresoraFiscal $impresora_fiscal)
    {
        return view('sistema.configuracion.impresoras-fiscales.edit', compact('impresora_fiscal'));
    }

    public function update(StoreImpresoraFiscalRequest $request, ImpresoraFiscal $impresora_fiscal)
    {
        $data = $request->all();

        $impresora_fiscal->update($data);
    
        return redirect()->route('sistema.configuracion.impresoras-fiscales.index');
    }

    public function destroy(ImpresoraFiscal $impresora_fiscal)
    {
        $impresora_fiscal->delete();
    
        return redirect()->route('sistema.configuracion.impresoras-fiscales.index');
    }
}
