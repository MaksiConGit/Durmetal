<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Client;
use App\Models\ClientQualification;
use App\Models\Proveedor;
use App\Models\IvaCondition;
use App\Models\CuentaGastos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClientesCreate extends Component
{
    public $next_id;

    public $calificaciones_cliente;
    public $condiciones_IVA;
    public $cuentas_de_gastos;

    // Localidad
    public $localidad_id = null;
    public $localidad_nombre = '';
    public $codigo_postal = '';
    public $provincia_nombre = '';

    // Filtros
    public $searchLocalidad = '';
    public $searchCP = '';
    public $searchProvincia = '';

    // Datos del proveedor
    public $Direccion = '';
    public $Telefono = '';
    public $NumeroDocumento = '';
    public $IdCalificacionCliente = 1;
    public $Activo = true;

    public $Nombre = '';
    public $IdCondicionIva = 1;
    public $Saldo = '';
    public $TipoDocumento = 'CUIT';

    // Emails
    public $emails = [
        '',
        '',
        '',
        '',
        '',
    ];
    
    protected function rules()
    {
        return [
            'Direccion' => 'required|string|max:255',
            'localidad_id' => 'required|exists:localidad,id',
            'Telefono' => 'nullable|string|max:255',
            'NumeroDocumento' => 'required|string|max:255',
            'Activo' => 'boolean',

            'Nombre' => 'required|string|max:255',
            'IdCondicionIva' => 'required|exists:condicion_iva,id',
            'Saldo' => 'nullable|numeric',
            'IdCalificacionCliente' => 'required|exists:calificacion_cliente,id',
            'TipoDocumento' => 'required|string|max:255',

            'emails' => 'array|max:6',
            'emails.*' => 'nullable|email|max:255',
        ];
    }

    protected function messages()
    {
        return [
            'localidad_id.required' => 'Debe seleccionar una localidad.',
            'localidad_id.exists' => 'La localidad seleccionada no existe.',

            'Nombre.required' => 'El nombre es obligatorio.',
            'NumeroDocumento.required' => 'El número de documento es obligatorio.',

            'IdCondicionIva.required' => 'Debe seleccionar una condición de IVA.',
            'IdCondicionIva.exists' => 'La condición de IVA seleccionada no existe.',

            'IdCuentaGastos.required' => 'Debe seleccionar una cuenta de gastos.',
            'IdCuentaGastos.exists' => 'La cuenta de gastos seleccionada no existe.',

            'NumeroDocumento.max' => 'El CUIT es demasiado largo.',

            'Saldo.numeric' => 'El saldo debe ser numérico.',

            'emails.*.email' => 'Uno de los emails no tiene un formato válido.',
        ];
    }

    public function getLocalidadesFiltradasProperty()
    {
        return City::query()

            ->when($this->searchLocalidad, function ($query) {
                $query->where(
                    'Nombre',
                    'like',
                    '%' . $this->searchLocalidad . '%'
                );
            })

            ->when($this->searchCP, function ($query) {
                $query->where(
                    'CP',
                    'like',
                    '%' . $this->searchCP . '%'
                );
            })

            ->when($this->searchProvincia, function ($query) {
                $query->whereHas('provincia', function ($query) {
                    $query->where(
                        'Nombre',
                        'like',
                        '%' . $this->searchProvincia . '%'
                    );
                });
            })

            ->with('provincia')
            ->orderBy('Nombre')
            ->limit(20)
            ->get();
    }

    public function seleccionarLocalidad($id)
    {
        $localidad = City::with('provincia')->find($id);

        if (!$localidad) {
            return;
        }

        $this->localidad_id = $localidad->id;
        $this->localidad_nombre = $localidad->Nombre;
        $this->codigo_postal = $localidad->CP;
        $this->provincia_nombre = $localidad->Provincia->Nombre ?? '';

        $this->searchLocalidad = '';
        $this->searchCP = '';
        $this->searchProvincia = '';
    }

    public function cancelarCliente()
    {
        $this->localidad_id = null;
        $this->localidad_nombre = '';
        $this->codigo_postal = '';
        $this->provincia_nombre = '';

        $this->searchLocalidad = '';
        $this->searchCP = '';
        $this->searchProvincia = '';
    }

    public function guardar()
    {
        $this->validate();

        $localidad = City::with('provincia')->find($this->localidad_id);

        if (!$localidad) {
            $this->addError('localidad_id', 'La localidad seleccionada no existe.');
            return;
        }

        $data = [
            'Domicilio' => $this->Direccion,
            'IdLocalidad' => $this->localidad_id,
            'Telefono' => $this->Telefono,
            'NroDocumento' => $this->NumeroDocumento,
            'TipoDocumento' => $this->TipoDocumento,
            'IdCalificacionCliente' => $this->IdCalificacionCliente ?: null,
            'Activo' => $this->Activo,

            'Nombre' => $this->Nombre,
            'IdCondicionIVA' => $this->IdCondicionIva,
            'Saldo' => $this->Saldo ?: 0,

            'Localidad' => $localidad->Nombre,
            'Provincia' => $localidad->provincia->Nombre ?? '',

            'SaldoSistemaAnterior' => 0,

            'FechaCreacion' => now(),
            'CreadoPor' => Auth::id(),

            'FechaActualizacion' => now(),
            'ActualizadoPor' => Auth::id(),

            'Activo' => 1,
        ];

        $cliente = Client::create($data);

        foreach ($this->emails as $email) {

            if (filled($email)) {
                $cliente->emails()->create([
                    'IdCliente' => $cliente->id,
                    'Email' => $email,

                    'FechaCreacion' => now(),
                    'CreadoPor' => Auth::id(),

                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => Auth::id(),

                    'Activo' => 1,

                    'IdClienteEmail' => $cliente->id . ',' . $email,
                ]);
            }
        }

        return redirect()->route(
            'clients.index'
        );
    }

    public function mount()
    {
        $this->calificaciones_cliente = ClientQualification::all();
        $this->condiciones_IVA = IvaCondition::all();

        $this->next_id = (Client::max('id') ?? 0) + 1;
    }

    public function render()
    {
        return view('livewire.clientes-create');
    }
}