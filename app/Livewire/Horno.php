<?php

namespace App\Livewire;

use App\Models\Programacion;
use App\Models\OrdenTrabajo;
use Carbon\Carbon;
use Livewire\Component;

class Horno extends Component
{
    public $horaActual;
    public $programacionesIdsPorHorno = [];
    public $indiceActivo = [];

    public function mount()
    {
        $this->horaActual = now();

        $programaciones = Programacion::where('FechaDescarga', '>', now())
            ->orderBy('FechaCarga')
            ->get()
            ->groupBy('NumeroHorno');

        foreach ($programaciones as $horno => $items) {
            $this->programacionesIdsPorHorno[$horno] = $items->pluck('id')->values()->toArray();
            $this->indiceActivo[$horno] = 0;
        }
    }

    public function abrirOrden($numero)
    {
        $orden = OrdenTrabajo::where('Numero', $numero)->first();

        if (!$orden) {
            session()->flash('error', 'No se encontró la orden de trabajo.');
            return;
        }

        return redirect()->route('orden-trabajo.edit', $orden->id);
    }

    public function cambiarProgramacion($horno)
    {
        if (!isset($this->programacionesIdsPorHorno[$horno])) return;

        $total = count($this->programacionesIdsPorHorno[$horno]);
        if ($total <= 1) return;

        $this->indiceActivo[$horno] =
            ($this->indiceActivo[$horno] + 1) % $total;
    }

    public function progreso($prog)
    {
        $inicio = Carbon::parse($prog->FechaCarga)->timestamp;
        $fin    = Carbon::parse($prog->FechaDescarga)->timestamp;
        $ahora  = now()->timestamp;

        if ($ahora <= $inicio) return 0;
        if ($ahora >= $fin) return 100;

        return round((($ahora - $inicio) / ($fin - $inicio)) * 100);
    }

    public function render()
    {
        $programacionesPorHorno = [];

        foreach ($this->programacionesIdsPorHorno as $horno => $ids) {

            $programaciones = Programacion::with([
                'medioEnfriamiento',
                'tipoProgramacion',
                'itemOrdenTrabajo.ordenTrabajo.cliente',
                'itemOrdenTrabajo.material',
            ])
            ->whereIn('id', $ids)
            ->where('FechaDescarga', '>', now())
            ->orderBy('FechaCarga')
            ->get();

            if ($programaciones->isEmpty()) {
                unset($this->programacionesIdsPorHorno[$horno]);
                unset($this->indiceActivo[$horno]);
                continue;
            }

            if ($this->indiceActivo[$horno] >= $programaciones->count()) {
                $this->indiceActivo[$horno] = 0;
            }

            $programacionesPorHorno[$horno] = $programaciones;
        }

        return view('livewire.horno', [
            'programacionesPorHorno' => $programacionesPorHorno,
        ]);
    }

}
