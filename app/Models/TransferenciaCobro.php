<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferenciaCobro extends Model
{
    protected $table = 'transferencia_cobro';
    public $timestamps = false;

    protected $fillable = [
        'IdCobro',
        'IdBanco',
    ];

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'IdBanco');
    }

}
