<?php

namespace App\Http\Controllers;

use App\Exports\ProgramacionExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProgramacionExportController extends Controller
{
    public function index(){
        return view('produccion.programacion.export');
    }

    public function export(){
        return Excel::download(new ProgramacionExport, 'programacion.xlsx');
    }
}
