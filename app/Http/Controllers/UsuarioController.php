<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __invoke()
    {
        return view('sistema.configuracion.usuarios');
    }
}
