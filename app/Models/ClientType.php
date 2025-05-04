<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    protected $table = 'tipo_cliente';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
