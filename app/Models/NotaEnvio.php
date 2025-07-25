<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaEnvio extends Model
{
    protected $table = 'nota_envio';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'IdCliente');
    }

    public function itemsNotaEnvio()
    {
        return $this->hasMany(ItemNotaEnvio::class, 'IdNotaEnvio');
    }
}
