<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function index(){
        return view('export');
    }

    public function export(){
        return Excel::download(new ClientsExport, 'clientes.xlsx');
    }
}
