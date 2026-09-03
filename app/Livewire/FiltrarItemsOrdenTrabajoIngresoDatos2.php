<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use App\Models\Client;
use App\Models\User;
use App\Models\Certificado;
use Illuminate\Support\Carbon;
use App\Models\Email;

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
    public $emails = [];

    // 🔹 Datos por item
    public $certificadoSeleccionado = [];
    public $numeroPlano = [];
    public $cantidad = [];
    public $responsableId = [];
    public $observaciones = [];

    public $observacionesCert = [];


    public function mount()
    {
        $this->fecha_fin = now()->format('Y-m-d');
        $this->fecha_inicio = now()->subMonth()->format('Y-m-d');
        $this->users = User::all();

        $this->emails = [];
    }

    public function actualizarCantidadCertificado($itemId, $tipo)
    {
        $item = ItemOrdenTrabajo::find($itemId);

        if (!$item) return;

        if ($tipo === 'impresion') {
            $item->CantidadCertificadosImpresos++;
        }

        if ($tipo === 'correo') {
            $item->CantidadCertificadosEnviadosPorCorreo++;
        }

        $item->ActualizadoPor = auth()->id();
        $item->FechaActualizacion = now();

        $item->save();
    }

    public function incrementarCorreo($itemId)
    {
        $item = ItemOrdenTrabajo::find($itemId);

        if (!$item) return;

        $item->CantidadCertificadosEnviadosPorCorreo =
            ($item->CantidadCertificadosEnviadosPorCorreo ?? 0) + 1;

        $item->save();
    }

    public function imprimirCertificado($itemId)
    {

        $this->validate([
            "numeroPlano.$itemId"   => 'nullable|string|max:255',
            "cantidad.$itemId"      => 'required|numeric|min:1',
            "responsableId.$itemId" => 'required|exists:users,id',
            "observacionesCert.$itemId" => 'nullable|string|max:1000',
        ]);

        if (!empty($this->certificadoSeleccionado[$itemId])) {

            $certificado = Certificado::find($this->certificadoSeleccionado[$itemId]);

            if ($certificado) {
                $certificado->update([
                    'Nombre'        => $this->numeroPlano[$itemId],
                    'NroPlano'      => $this->numeroPlano[$itemId],
                    'Observaciones' => $this->observacionesCert[$itemId],
                    'Cantidad'      => $this->cantidad[$itemId],
                    'IdUsuario' => $this->responsableId[$itemId],
                ]);
            }

            $url = route('ingreso-datos.pdf', $certificado);

            $this->dispatch('abrirPdf', url: $url);

            $this->actualizarCantidadCertificado($itemId, 'impresion');

            return;
        }

        if ($this->numeroPlano[$itemId]) {

            $certificado = Certificado::create([
                'IdItemOrdenTrabajo'       => $itemId,
                'Nombre'                   => $this->numeroPlano[$itemId],
                'NroPlano'                 => $this->numeroPlano[$itemId],
                'Observaciones'            => $this->observacionesCert[$itemId] ?? null,
                'Cantidad'                 => $this->cantidad[$itemId],
                'IdUsuario'                => $this->responsableId[$itemId],
                'CantidadImpresiones'      => 0,
                'CantidadEnviosPorCorreo'  => 0,
                'Predeterminado'           => 1,
            ]);

            $url = route('ingreso-datos.pdf', $certificado->id);

            $this->dispatch('abrirPdf', url: $url);
        }
        else {
            $item = ItemOrdenTrabajo::with('ordenTrabajo')->findOrFail($itemId);

            $url = route('ingreso-datos.pdf-sin-certificado', [
                'item'          => $item->id,
                'Cantidad'      => $this->cantidad[$itemId],
                'Observaciones' => $this->observacionesCert[$itemId] ?? null,
                'Usuario'       => $this->responsableId[$itemId],
            ]);

            $this->dispatch('abrirPdf', url: $url);
        }

    }

    // public function enviarCertificadoPorCorreo($itemId)
    // {
    //     $this->actualizarCantidadCertificado($itemId, 'correo');

    //     // 🔹 Validar emails
    //     if (
    //         !isset($this->emailsSeleccionados[$itemId]) ||
    //         count($this->emailsSeleccionados[$itemId]) === 0
    //     ) {
    //         $this->addError("emails.$itemId", 'Debe seleccionar al menos un email.');
    //         return;
    //     }

    //     // 🔹 Si existe certificado → usarlo
    //     if (!empty($this->certificadoSeleccionado[$itemId])) {

    //         return redirect()->to(
    //             route('ingreso-datos.email', $this->certificadoSeleccionado[$itemId])
    //             . '?Emails=' . implode(',', $this->emailsSeleccionados[$itemId])
    //         );

    //     }

    //     // 🔹 Validaciones SOLO si es nuevo
    //     $this->validate([
    //         "numeroPlano.$itemId"   => 'required|string|max:255',
    //         "cantidad.$itemId"      => 'required|numeric|min:1',
    //         "responsableId.$itemId" => 'required|exists:users,id',
    //     ]);

    //     // 🔹 Crear certificado
    //     $certificado = Certificado::create([
    //         'IdItemOrdenTrabajo'       => $itemId,
    //         'Nombre'                   => $this->numeroPlano[$itemId],
    //         'NroPlano'                 => $this->numeroPlano[$itemId],
    //         'Observaciones'            => $this->observacionesCert[$itemId] ?? null,
    //         'Cantidad'                 => $this->cantidad[$itemId],
    //         'ResponsableId'            => $this->responsableId[$itemId],
    //         'CantidadImpresiones'      => 0,
    //         'CantidadEnviosPorCorreo'  => 0,
    //         'Predeterminado'           => 1,
    //     ]);


    //     return redirect()->to(
    //         route('ingreso-datos.email', $certificado->id)
    //         . '?Emails=' . implode(',', $this->emailsSeleccionados[$itemId])
    //     );
    // }

    public function enviarCertificadoPorCorreo($itemId)
    {
        // 🔹 Validación
        $this->validate([
            "numeroPlano.$itemId" => 'nullable|string|max:255',
            "cantidad.$itemId" => 'required|numeric|min:1',
            "responsableId.$itemId" => 'required|exists:users,id',
            "observacionesCert.$itemId" => 'nullable|string|max:1000',
        ]);

        // 🔹 Obtener el ItemOrdenTrabajo y su OrdenTrabajo
        $item = ItemOrdenTrabajo::with('ordenTrabajo')->findOrFail($itemId);

        // 🔹 Crear o actualizar certificado
        if (!empty($this->certificadoSeleccionado[$itemId])) {

            $certificado = Certificado::find($this->certificadoSeleccionado[$itemId]);

            if ($certificado) {
                $certificado->update([
                    'Nombre' => $this->numeroPlano[$itemId],
                    'NroPlano' => $this->numeroPlano[$itemId],
                    'Observaciones' => $this->observacionesCert[$itemId] ?? null,
                    'Cantidad' => $this->cantidad[$itemId],
                    'IdUsuario' => $this->responsableId[$itemId],
                ]);
            }

        } else {

            if ($this->numeroPlano[$itemId]) {
                $certificado = Certificado::create([
                    'IdItemOrdenTrabajo' => $itemId,
                    'Nombre' => $this->numeroPlano[$itemId],
                    'NroPlano' => $this->numeroPlano[$itemId],
                    'Observaciones' => $this->observacionesCert[$itemId] ?? null,
                    'Cantidad' => $this->cantidad[$itemId],
                    'IdUsuario' => $this->responsableId[$itemId],
                    'CantidadImpresiones' => 0,
                    'CantidadEnviosPorCorreo' => 0,
                    'Predeterminado' => 1,
                ]);
            }
        }

        // 🔹 Obtener SOLO los emails del cliente de la orden
        $emailsSeleccionados = $this->emails[$itemId] ?? [];

        if (empty($emailsSeleccionados)) {
            $this->addError(
                "emails.$itemId",
                'Debe seleccionar al menos un email.'
            );

            return;
        }

        $emails = implode(',', $emailsSeleccionados);

        // 🔹 Actualizar contador
        $this->actualizarCantidadCertificado($itemId, 'correo');

        // 🔥 Redirección
        // return redirect()->to(
        //     url("ingreso-datos/{$certificado->id}/email") . '?Emails=' . $emails
        // );

        if (!empty($certificado)) {
            return redirect()->route('ingreso-datos.email', [
                'certificado' => $certificado->id,
                'Emails' => $emails,
            ]);
        }

        return redirect()->route('ingreso-datos.email-sin-certificado', [
            'item' => $itemId,
            'Cantidad' => $this->cantidad[$itemId],
            'Observaciones' => $this->observacionesCert[$itemId],
            'Usuario' => $this->responsableId[$itemId],
            'Emails' => $emails,
        ]);
    }

    public function inicializarCertificado($itemId)
    {
        $item = ItemOrdenTrabajo::findOrFail($itemId);

        if (!isset($this->cantidad[$itemId])) {
            $this->cantidad[$itemId] = $item->Cantidad;
        }

        if (!isset($this->numeroPlano[$itemId])) {
            $this->numeroPlano[$itemId] = null;
        }

        if (!isset($this->responsableId[$itemId])) {
            $this->responsableId[$itemId] = auth()->id();
        }

        if (!isset($this->observacionesCert[$itemId])) {
            $this->observacionesCert[$itemId] = null;
        }

        if (!isset($this->emails[$itemId])) {
            $this->emails[$itemId] = $item->ordenTrabajo->cliente->emails
                ->pluck('id')
                ->toArray();
        }
    }

    public function updatedCertificadoSeleccionado($value, $itemId)
    {
        $item = ItemOrdenTrabajo::with('ordenTrabajo')->findOrFail($itemId);

        if (!$value) {
            // Nuevo
            $this->numeroPlano[$itemId] = null;
            $this->cantidad[$itemId] = $item->Cantidad;
            $this->responsableId[$itemId] = auth()->id();
            $this->observacionesCert[$itemId] = null;
            return;
        }

        $certificado = Certificado::find($value);

        if ($certificado) {
            $this->numeroPlano[$itemId]   = $certificado->NroPlano;
            $this->cantidad[$itemId]      = $certificado->Cantidad;
            $this->responsableId[$itemId] = $certificado->IdUsuario;
            $this->observacionesCert[$itemId] = $certificado->Observaciones;
        }
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

            ->orderByRaw("CASE 
                WHEN item_orden_trabajo.Estado = 'PENDIENTE' THEN 0
                ELSE 1
            END")

            ->orderByDesc('item_orden_trabajo.FechaCreacion');

        if ($this->fecha_inicio && $this->fecha_fin) {
            $query->whereBetween('item_orden_trabajo.FechaCreacion', [
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
