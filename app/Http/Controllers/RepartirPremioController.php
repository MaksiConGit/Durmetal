<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePremioRequest;
use App\Http\Requests\UpdatePremioRequest;
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

    public function create(Request $request)
    {
        $empleados = User::where('CobraPremio', 1)->get();

        $total = $request->query('total');

        return view('produccion.actualizaciones.repartir-premios.create', compact('empleados', 'total'));
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
            'FechaActualizacion' => now(),
            'ActualizadoPor' => $user_id,
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
                'FechaActualizacion' => now(),
                'ActualizadoPor' => $user_id,
            ]);
        }
    
        return redirect()->route('repartir-premios.index');
    }

    public function edit(Premio $premio)
    {
        return view('produccion.actualizaciones.repartir-premios.edit', compact('premio'));
    }

    public function update(UpdatePremioRequest $request, Premio $premio)
    {
        $data = $request->all();

        $user_id = Auth::id();

        $premio->update([
            'Nombre' => $data['Nombre'],
            'FechaDesde' => $data['FechaDesde'],
            'FechaHasta' => $data['FechaHasta'],
            'Premio' => $data['PremioTotal'],
            'Estado' => $data['Estado'],
            'FechaActualizacion' => now(),
            'ActualizadoPor' => $user_id,
        ]);

        foreach ($data['IdUsuario'] as $index => $IdUsuario) {

            $item_premio = ItemPremio::where('IdPremio', $premio->id)->where('IdUsuario', $IdUsuario);

            $item_premio->update([
                'IdPremio' => $premio->id,
                'IdUsuario' => $data['IdUsuario'][$index],
                'PremioBase' => $data['PremioBase'][$index] ?? 0,
                'IndiceBase' => $data['IndiceBase'][$index],
                'Coeficiente' => $data['Coeficiente'][$index],
                'Premio' => $data['Premio'][$index],
                'FechaActualizacion' => now(),
                'ActualizadoPor' => $user_id,
            ]);
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
