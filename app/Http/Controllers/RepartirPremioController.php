<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePremioRequest;
use App\Models\ItemPremio;
use App\Models\Premio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepartirPremioController extends Controller
{
    public function index()
    {
        $premios = Premio::all();

        return view('produccion.actualizaciones.repartir-premios.index', compact('premios'));
    }

    public function create()
    {
        $empleados = User::where('CobraPremio', 1)->get();

        return view('produccion.actualizaciones.repartir-premios.create', compact('empleados'));
    }

    public function store(StorePremioRequest $request)
    {
        $data = $request->all();

        $user_id = Auth::id();

        $premio = Premio::create([
            'Nombre' => $data['Nombre'],
            'FechaDesde' => $data['FechaDesde'],
            'FechaHasta' => $data['FechaHasta'],
            'Premio' => $data['PremioTotal'],
            'Estado' => $data['Estado'],
            'FechaCreacion' => now(),
            'CreadoPor' => $user_id,
            'FechaModificacion' => now(),
            'ModificadoPor' => $user_id,
        ]);

        foreach ($data['IdUsuario'] as $index => $IdUsuario) {
            $item_premio = ItemPremio::create([
                'IdPremio' => $premio->id,
                'IdUsuario' => $data['IdUsuario'][$index],
                'PremioBase' => $data['PremioBase'][$index] ?? 0,
                'IndiceBase' => $data['IndiceBase'][$index],
                'Coeficiente' => $data['Coeficiente'][$index],
                'Premio' => $data['Premio'][$index],
                'FechaCreacion' => now(),
                'CreadoPor' => $user_id,
                'FechaModificacion' => now(),
                'ModificadoPor' => $user_id,
            ]);
        }
    
        return redirect()->route('repartir-premios.index');
    }

    public function edit(Dureza $dureza)
    {
        return view('produccion.actualizaciones.repartir-premios.edit', compact('dureza'));
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->all();

        $user_id = Auth::id();
        
        $usuario->update([
            'IndiceBasePremio' => $data['IndiceBasePremio'][$usuario->id],
            'FechaActualizacion' => now(),
            'ActualizadoPor' => $user_id,
        ]);

        foreach ($data['IdFactores'] as $index => $IdFactor) {

            $factor_premio_usuario = FactorPremioUsuario::where('IdUsuario', $usuario->id)->where('IdFactorPremio', $IdFactor)->first();

            if ($data['FactorActivo'][$index]) {

                if ($factor_premio_usuario) {

                    $factor_premio_usuario->update([
                        'Valor' => $data['ValorFactor'][$index],
                        'FechaActualizacion' => now(),
                        'ActualizadoPor' => $user_id,
                    ]);

                }
                else{

                    $factor_premio_usuario = FactorPremioUsuario::create([
                        'IdUsuario' => $usuario->id,
                        'IdFactorPremio' => $IdFactor,
                        'Valor' => $data['ValorFactor'][$index],
                        'FechaCreacion' => now(),
                        'CreadoPor' => $user_id,
                        'FechaActualizacion' => now(),
                        'ActualizadoPor' => $user_id,
                        'Activo' => 1,
                    ]);
                    
                }

            }
            else{

                if ($factor_premio_usuario) {
                    $factor_premio_usuario->delete();
                }

            }

        }
    
        return redirect()->route('repartir-premios.index');
    }

    public function destroy(Premio $premio)
    {
        $items_premio = $premio->itemsPremio;

        foreach ($items_premio as $item_premio) {
            $item_premio->delete();
        }

        $premio->delete();
    
        return redirect()->route('repartir-premios.index');
    }
}
