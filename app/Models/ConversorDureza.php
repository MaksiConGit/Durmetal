<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversorDureza extends Model
{
    protected $table = 'conversor_dureza';
    public $timestamps = false;

    protected $fillable = [
        'ValorHB',
        'ValorHRC',
        'ValorKMM2',
        'ValorMPA',
        'ValorKSI',
    ];
}
