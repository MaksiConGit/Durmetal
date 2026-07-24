<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'Nombre',
        'Usuario',
        'Contraseña',
        'CobraPremio',
        'IndiceBasePremio',
        'Activo',
        'Firma',
        'FechaCreacion',
        'CreadoPor',
        'FechaActualizacion',
        'ActualizadoPor',
    ];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function factoresPremioUsuario()
    {
        return $this->hasMany(FactorPremioUsuario::class, 'IdUsuario');
    }

    public function getAuthPassword()
    {
        return $this->Contraseña;
    }
}
