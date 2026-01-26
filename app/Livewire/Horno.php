<?php

namespace App\Livewire;

use App\Models\Programacion;
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

        $programaciones = Programacion::whereDate('FechaCarga', '>=', Carbon::today())
            ->orderBy('FechaCarga')
            ->get()
            ->groupBy('NumeroHorno');

        foreach ($programaciones as $horno => $items) {
            $this->programacionesIdsPorHorno[$horno] = $items->pluck('id')->values()->toArray();
            $this->indiceActivo[$horno] = 0;
        }
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
            $programacionesPorHorno[$horno] = Programacion::with([
                'medioEnfriamiento',
                'tipoProgramacion',
                'itemOrdenTrabajo.ordenTrabajo.cliente',
                'itemOrdenTrabajo.material',
            ])->whereIn('id', $ids)->get();
        }

        return view('livewire.horno', [
            'programacionesPorHorno' => $programacionesPorHorno,
        ]);
    }
}
