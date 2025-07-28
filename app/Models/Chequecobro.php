<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chequecobro extends Model
{
    protected $table = 'chequecobro';
    public $timestamps = false;

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'IdBanco');
    }

    public function cobro()
    {
        return $this->belongsTo(Cobro::class, 'IdCobro');
    }
}
