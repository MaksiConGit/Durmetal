<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Proveedor;
use App\Models\RetencionIIBB;
use App\Models\IvaCondition;
use App\Models\CuentaGastos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProveedoresCreate extends Component
{
    public $next_id;

    public $retenciones_IIBB;
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
    public $IdRetencionIIBB = '';
    public $Activo = true;

    public $Nombre = '';
    public $IdCondicionIva = 1;
    public $Saldo = '';
    public $NumeroIIBB = '';
    public $IdCuentaGastos = 1;

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
            'Direccion' => 'nullable|string|max:255',
            'localidad_id' => 'required|exists:localidad,id',
            'Telefono' => 'nullable|string|max:255',
            'NumeroDocumento' => 'required|string|max:255',
            'IdRetencionIIBB' => 'nullable|exists:retencion_iibb,id',
            'Activo' => 'boolean',

            'Nombre' => 'required|string|max:255',
            'IdCondicionIva' => 'required|exists:condicion_iva,id',
            'Saldo' => 'nullable|numeric',
            'NumeroIIBB' => 'required|string|max:255',
            'IdCuentaGastos' => 'required|exists:cuenta_gastos,id',

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
            'NumeroDocumento.required' => 'El CUIT es obligatorio.',

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
        $this->provincia_nombre = $localidad->provincia->Nombre ?? '';

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
            'Direccion' => $this->Direccion,
            'IdLocalidad' => $this->localidad_id,
            'Telefono' => $this->Telefono,
            'NumeroDocumento' => $this->NumeroDocumento,
            'IdRetencionIIBB' => $this->IdRetencionIIBB ?: null,
            'Activo' => $this->Activo,

            'Nombre' => $this->Nombre,
            'IdCondicionIva' => $this->IdCondicionIva,
            'SaldoSistemaAnterior' => $this->Saldo ?: 0,
            'NumeroIIBB' => $this->NumeroIIBB,
            'IdCuentaGastos' => $this->IdCuentaGastos,

            'Localidad' => $localidad->Nombre,
            'Provincia' => $localidad->provincia->Nombre ?? '',

            'FechaCreacion' => now(),
            'CreadoPor' => Auth::id(),

            'FechaActualizacion' => now(),
            'ActualizadoPor' => Auth::id(),

            'Activo' => 1,
        ];

        $proveedor = Proveedor::create($data);

        foreach ($this->emails as $email) {

            if (filled($email)) {
                $proveedor->emails()->create([
                    'IdProveedor' => $proveedor->id,
                    'Email' => $email,

                    'FechaCreacion' => now(),
                    'CreadoPor' => Auth::id(),

                    'FechaActualizacion' => now(),
                    'ActualizadoPor' => Auth::id(),

                    'Activo' => 1,

                    'IdProveedorEmail' => $proveedor->id . ',' . $email,
                ]);
            }
        }

        return redirect()->route(
            'compras.actualizaciones.proveedores.index'
        );
    }

    public function mount()
    {
        $this->retenciones_IIBB = RetencionIIBB::all();
        $this->condiciones_IVA = IvaCondition::all();
        $this->cuentas_de_gastos = CuentaGastos::all();

        $this->next_id = (Proveedor::max('id') ?? 0) + 1;
    }

    public function render()
    {
        return view('livewire.proveedores-create');
    }
}