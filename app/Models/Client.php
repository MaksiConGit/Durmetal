<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $fillable = [
        'name',
        'address',
        'city_id',
        'phone',
        'iva_condition_id',
        'document_type_id',
        'document_number',
        'balance',
        'is_active',
        'qualification_id',
        'created_by',
        'updated_by',
    ];

    public function ivaCondition()
    {
        return $this->belongsTo(IvaCondition::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function clientQualification()
    {
        return $this->belongsTo(ClientQualification::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }


}
