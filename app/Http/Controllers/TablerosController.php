<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TablerosController extends Controller
{
    public function hornos()
    {
        return view('tableros.hornos.index');
    }
}
