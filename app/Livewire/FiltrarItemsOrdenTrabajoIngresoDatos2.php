<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use App\Models\Client;
use App\Models\User;
use App\Models\Certificado;
use Illuminate\Support\Carbon;

class FiltrarItemsOrdenTrabajoIngresoDatos2 extends Component
{
    public $fecha_inicio;
    public $fecha_fin;

    public $oti_item_numero;
    public $oti_orden_numero;

    public $cliente_id = null;
    public $cliente_nombre = null;

    public array $expanded = [];
    public array $expandedInner = [];

    public $users;

    // 🔹 Datos por item
    public $certificadoSeleccionado = [];
    public $numeroPlano = [];
    public $cantidad = [];
    public $responsableId = [];
    public $observaciones = [];

    public function mount()
    {
        $this->fecha_fin = now()->format('Y-m-d');
        $this->fecha_inicio = now()->subMonth()->format('Y-m-d');
        $this->users = User::all();
    }

    public function imprimirCertificado($itemId)
    {
        // Si eligió uno existente
        if (!empty($this->certificadoSeleccionado[$itemId])) {

            return redirect()->route(
                'ingreso-datos.pdf',
                $this->certificadoSeleccionado[$itemId]
            );
        }

        // 🔹 Validaciones SOLO si es nuevo
        $this->validate([
            "numeroPlano.$itemId"   => 'required|string|max:255',
            "cantidad.$itemId"      => 'required|numeric|min:1',
            "responsableId.$itemId" => 'required|exists:users,id',
            "observaciones.$itemId" => 'nullable|string|max:1000',
        ], [
            "numeroPlano.$itemId.required"   => 'Debe ingresar el número de plano.',
            "cantidad.$itemId.required"      => 'Debe ingresar la cantidad.',
            "cantidad.$itemId.numeric"       => 'La cantidad debe ser numérica.',
            "cantidad.$itemId.min"           => 'La cantidad debe ser mayor a 0.',
            "responsableId.$itemId.required" => 'Debe seleccionar un responsable técnico.',
            "responsableId.$itemId.exists"   => 'El responsable seleccionado no es válido.',
        ]);

        // 🔹 Crear certificado
        $certificado = Certificado::create([
            'IdItemOrdenTrabajo'       => $itemId,
            'Nombre'                   => $this->numeroPlano[$itemId],
            'NroPlano'                 => $this->numeroPlano[$itemId],
            'Observaciones'            => $this->observaciones[$itemId] ?? null,
            'Cantidad'                 => $this->cantidad[$itemId],
            'ResponsableId'            => $this->responsableId[$itemId],
            'CantidadImpresiones'      => 0,
            'CantidadEnviosPorCorreo'  => 0,
            'Predeterminado'           => 1,
        ]);

        // Abrir PDF
        return redirect()->route('ingreso-datos.pdf', $certificado->id);
    }

public function enviarCertificadoPorCorreo($itemId)
{
    // 🔹 Validar emails
    if (
        !isset($this->emailsSeleccionados[$itemId]) ||
        count($this->emailsSeleccionados[$itemId]) === 0
    ) {
        $this->addError("emails.$itemId", 'Debe seleccionar al menos un email.');
        return;
    }

    // 🔹 Si existe certificado → usarlo
    if (!empty($this->certificadoSeleccionado[$itemId])) {

        return redirect()->to(
            route('ingreso-datos.email', $this->certificadoSeleccionado[$itemId])
            . '?Emails=' . implode(',', $this->emailsSeleccionados[$itemId])
        );
    }

    // 🔹 Validaciones SOLO si es nuevo
    $this->validate([
        "numeroPlano.$itemId"   => 'required|string|max:255',
        "cantidad.$itemId"      => 'required|numeric|min:1',
        "responsableId.$itemId" => 'required|exists:users,id',
    ]);

    // 🔹 Crear certificado
    $certificado = Certificado::create([
        'IdItemOrdenTrabajo'       => $itemId,
        'Nombre'                   => $this->numeroPlano[$itemId],
        'NroPlano'                 => $this->numeroPlano[$itemId],
        'Observaciones'            => $this->observaciones[$itemId] ?? null,
        'Cantidad'                 => $this->cantidad[$itemId],
        'ResponsableId'            => $this->responsableId[$itemId],
        'CantidadImpresiones'      => 0,
        'CantidadEnviosPorCorreo'  => 0,
        'Predeterminado'           => 1,
    ]);

    return redirect()->to(
        route('ingreso-datos.email', $certificado->id)
        . '?Emails=' . implode(',', $this->emailsSeleccionados[$itemId])
    );
}


    public function cancelarCliente()
    {
        $this->cliente_id = null;
        $this->cliente_nombre = null;
    }

    public function updatedClienteId($value)
    {
        $cliente = Client::find($value);
        $this->cliente_nombre = $cliente?->Nombre;
    }

    public function seleccionarCliente($id)
    {
        $cliente = Client::find($id);
        if ($cliente) {
            $this->cliente_id = $cliente->id;
            $this->cliente_nombre = $cliente->Nombre;
        }
    }

    public function toggleExpand($id)
    {
        in_array($id, $this->expanded)
            ? $this->expanded = array_diff($this->expanded, [$id])
            : $this->expanded[] = $id;
    }

    public function toggleExpandInner($id)
    {
        in_array($id, $this->expandedInner)
            ? $this->expandedInner = array_diff($this->expandedInner, [$id])
            : $this->expandedInner[] = $id;
    }

    /**
     * 🔥 Cuando cambia el certificado
     */
    public function updatedCertificadoSeleccionado($value, $itemId)
    {
        if (!$value) {
            // Nuevo
            $this->numeroPlano[$itemId] = null;
            $this->cantidad[$itemId] = null;
            $this->responsableId[$itemId] = null;
            $this->observaciones[$itemId] = null;
            return;
        }

        $certificado = Certificado::find($value);

        if ($certificado) {
            $this->numeroPlano[$itemId]   = $certificado->NroPlano;
            $this->cantidad[$itemId]      = $certificado->Cantidad;
            $this->responsableId[$itemId] = $certificado->IdUsuario;
            $this->observaciones[$itemId] = $certificado->Observaciones;
        }
    }

    public function render()
    {
        $query = ItemOrdenTrabajo::with([
            'ordenTrabajo.cliente',
            'tratamiento',
            'material',
            'dureza',
            'programacion.tipoProgramacion',
            'programacion.medioEnfriamiento',
            'programacion.ejecutadoPorOperador',
            'certificados'
        ])
        ->whereIn('Estado', ['PENDIENTE', 'APROBADO'])
        ->whereHas('programacion');

        if ($this->fecha_inicio && $this->fecha_fin) {
            $query->whereBetween('FechaCreacion', [
                Carbon::parse($this->fecha_inicio)->startOfDay(),
                Carbon::parse($this->fecha_fin)->endOfDay(),
            ]);
        }

        if ($this->oti_item_numero) {
            $query->where('ItemNumero', 'like', "%{$this->oti_item_numero}%");
        }

        if ($this->oti_orden_numero) {
            $query->whereHas('ordenTrabajo', fn ($q) =>
                $q->where('Numero', 'like', "%{$this->oti_orden_numero}%")
            );
        }

        if ($this->cliente_id) {
            $query->whereHas('ordenTrabajo', fn ($q) =>
                $q->where('IdCliente', $this->cliente_id)
            );
        }

        return view('livewire.filtrar-items-orden-trabajo-ingreso-datos2', [
            'items_orden_trabajo' => $query->get(),
            'tratamientos' => Tratamiento::all(),
            'clientes' => Client::all(),
            'expanded' => $this->expanded,
        ]);
    }
}
