<?php

namespace App\Http\Controllers;

use App\Exports\OrdenesTrabajoExport;
use App\Models\OrdenTrabajo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrdenTrabajoExportController extends Controller
{

    public function export($id)
    {
        $orden = OrdenTrabajo::findOrFail($id);
        return Excel::download(new OrdenesTrabajoExport($orden), 'orden_trabajo_' . $orden->id . '.xlsx');
    }

}
