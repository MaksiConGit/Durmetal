<?php

namespace App\Http\Controllers;

use App\Models\FactorPremio;
use App\Models\FactorPremioUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsignarFactorController extends Controller
{
    public function index()
    {
        $empleados = User::where('CobraPremio', 1)->get();
        $factores_premio = FactorPremio::all();

        return view('produccion.actualizaciones.asignar-factores.index', compact('empleados', 'factores_premio'));
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
    
        return redirect()->route('asignar-factores.index');
    }

}
