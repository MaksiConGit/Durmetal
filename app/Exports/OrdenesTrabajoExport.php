<?php

namespace App\Exports;

use App\Models\OrdenTrabajo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdenesTrabajoExport implements FromView
{
    protected $orden_trabajo;

    public function __construct(OrdenTrabajo $orden_trabajo)
    {
        $this->orden_trabajo = $orden_trabajo;
    }

    public function view(): View
    {
        $orden = $this->orden_trabajo->load('itemsOrdenTrabajo');

        return view('produccion.orden-trabajo.export', [
            'orden_trabajo' => $orden
        ]);
    }
}
