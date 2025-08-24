<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpresoraFiscal extends Model
{
    protected $table = 'impresora_fiscal';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Modelo',
        'PuertoCOM',
        'VelocidadPrEpson',
        'TipoProtocoloPrEpson',
        'FechaUltimoCierreZ',
        'PuertoComOcxIFEpson',
        'VelocidadOcxIFEpson',
    ];
}
