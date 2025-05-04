<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'email_cliente';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'text',
        'client_id',
    ];
}
