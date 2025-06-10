<?php

namespace App\Livewire;

use App\Models\Programacion;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FiltroPorDate extends Component
{

    public function render()
    {
        $programaciones = Programacion::select(
            'programacion.FechaCarga',
            'programacion.FechaDescarga',
            'programacion.Temperatura',
            'programacion.IdMedioEnfriamiento',
            'medio_enfriamiento.Nombre as NombreMedioEnfriamiento',
            'programacion.NumeroHorno',
            'programacion.EjecutadoPorOperador',
            'users.name as NombreEjecutadoPorOperador',
            DB::raw('GROUP_CONCAT(programacion.id) as programacion_ids')
        )
        ->join('medio_enfriamiento', 'medio_enfriamiento.id', '=', 'programacion.IdMedioEnfriamiento')
        ->join('users', 'users.id', '=', 'programacion.EjecutadoPorOperador')
        ->where('programacion.NumeroHorno', '>', 0)
        ->groupBy(
            'programacion.FechaCarga',
            'programacion.FechaDescarga',
            'programacion.Temperatura',
            'programacion.IdMedioEnfriamiento',
            'medio_enfriamiento.Nombre',
            'programacion.NumeroHorno',
            'programacion.EjecutadoPorOperador',
            'users.name'
        )
        ->orderByDesc('programacion.FechaCarga')
        ->orderBy('programacion.EjecutadoPorOperador')
        ->get();

        return view('livewire.filtro-por-date', [
            'programaciones' => $programaciones,
        ]);
    }
}