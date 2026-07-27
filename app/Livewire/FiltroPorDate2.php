<?php

namespace App\Livewire;

use App\Models\Programacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FiltroPorDate2 extends Component
{

    public $FechaCarga;
    public $FechaDescarga;
    public $expanded = [];
    public $selectedId = null;

    public function mount()
    {
        $hoy = Carbon::today()->toDateString();
        $this->FechaCarga = $hoy;
        $this->FechaDescarga = $hoy;
    }

    public function toggleExpand($id)
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$id]);
        } else {
            $this->expanded[] = $id;
        }
        
        $this->selectedId = $id;

    }


    public function render()
    {
        $query = Programacion::select(
                'programacion.FechaCarga',
                'programacion.FechaDescarga',
                'programacion.Temperatura',
                'programacion.IdMedioEnfriamiento',
                'medio_enfriamiento.Nombre as NombreMedioEnfriamiento',
                'programacion.NumeroHorno',
                'programacion.EjecutadoPorOperador',
                'users.Nombre as NombreEjecutadoPorOperador',
                DB::raw('GROUP_CONCAT(programacion.id) as programacion_ids')
            )
            ->join('medio_enfriamiento', 'medio_enfriamiento.id', '=', 'programacion.IdMedioEnfriamiento')
            ->join('users', 'users.id', '=', 'programacion.EjecutadoPorOperador')
            ->where('programacion.NumeroHorno', '>', 0);

        if ($this->FechaCarga) {
            $query->whereDate('programacion.FechaCarga', '>=', $this->FechaCarga);
        }

        if ($this->FechaDescarga) {
            $query->whereDate('programacion.FechaDescarga', '<=', $this->FechaDescarga);
        }


        $programaciones = $query->groupBy(
                'programacion.FechaCarga',
                'programacion.FechaDescarga',
                'programacion.Temperatura',
                'programacion.IdMedioEnfriamiento',
                'medio_enfriamiento.Nombre',
                'programacion.NumeroHorno',
                'programacion.EjecutadoPorOperador',
                'users.Nombre'
            )
            ->orderByDesc('programacion.FechaCarga')
            ->orderBy('programacion.EjecutadoPorOperador')
            ->get();

        return view('livewire.filtro-por-date2', [
            'programaciones' => $programaciones,
            'expanded' => $this->expanded,
        ]);
    }

}