<?php

namespace App\Exports;

use App\Models\ItemOrdenTrabajo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ProgramacionExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() :View
    {
        return view('produccion.programacion.export', [
            'items_orden_trabajo' => ItemOrdenTrabajo::all()
        ]);
    }
}
