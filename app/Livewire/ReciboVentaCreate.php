<?php

namespace App\Livewire;

use App\Models\Banco;
use App\Models\Chequecobro;
use App\Models\Client;
use App\Models\Cobro;
use App\Models\PuntoDeVenta;
use App\Models\FacturaVenta;
use App\Models\ItemReciboVenta;
use App\Models\ReciboVenta;
use App\Models\TransferenciaCobro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReciboVentaCreate extends Component
{
    public $facturas_venta;
    public $pto_ventas;
    public $activeTab = 'custom-tabs-1';
    public $a_cobrar = [];
    public $total_imputado = 0;

    public $fechaEmisionCheque;
    public $fechaVencimientoCheque;

    public $cantidad_efectivo = 0;
    public $cantidad_transferencias = 0;
    public $cantidad_cheques = 0;
    public $cantidad_tarjetas = 0;
    public $cantidad_retenciones = 0;

    public $cliente;
    public $punto_venta, $numero, $fecha_emision, $id_cliente, $nombre_cliente;
    public $retenciones = [
        'drei' => 0,
        'ganancias' => 0,
        'iibb' => 0,
        'iva' => 0,
        'suss' => 0,
    ];
    public $facturas_seleccionadas = [];
    public $efectivo = '';
    public $transferencias = [];
    public $bancos = [];
    public $cheques = [];
    public $tarjetas = [];

    public $total_final = 0;

    protected $rules = [
        // ITEMS
        'facturas_seleccionadas' => 'required|array|min:1',
        'facturas_seleccionadas.*.IdFacturaVenta' => 'required|exists:factura_venta,id',
        'facturas_seleccionadas.*.Total' => 'required|numeric|min:0.01',

        // EFECTIVO
        'efectivo.*' => 'nullable|numeric|min:0.01',

        // TRANSFERENCIAS
        'transferencias' => 'nullable|array',
        'transferencias.*.IdBanco' => 'nullable|exists:banco,id',
        'transferencias.*.Total' => 'nullable|numeric|min:0.01',

        // CHEQUES
        'cheques' => 'nullable|array',
        'cheques.*.IdBanco' => 'nullable|exists:banco,id',
        'cheques.*.Numero' => 'nullable',
        'cheques.*.FechaEmision' => 'nullable|date',
        'cheques.*.FechaAcreditacion' => 'nullable|date',
        'cheques.*.Plaza' => 'nullable',
        'cheques.*.eCheck' => 'nullable|bool',
        'cheques.*.Total' => 'nullable|numeric|min:0.01',

        // TARJETAS
        'tarjetas' => 'nullable|array',
        'tarjetas.*.Descripcion' => 'nullable|string|max:255',
        'tarjetas.*.Total' => 'nullable|numeric|min:0.01',

        // RETENCIONES
        'retenciones.drei' => 'nullable|numeric|min:0',
        'retenciones.ganancias' => 'nullable|numeric|min:0',
        'retenciones.iibb' => 'nullable|numeric|min:0',
        'retenciones.iva' => 'nullable|numeric|min:0',
        'retenciones.suss' => 'nullable|numeric|min:0',

        // GENERALES
        'total_final' => 'required|numeric',
        'fecha_emision' => 'required|date',
        'punto_venta' => 'required',
        'numero' => 'required',
    ];

    protected $messages = [
        'facturas_seleccionadas.required' => 'Debe seleccionar al menos un ítem.',
        'facturas_seleccionadas.min' => 'Debe haber al menos un ítem.',

        'facturas_seleccionadas.*.Total.required' => 'El total del ítem es obligatorio.',
        'facturas_seleccionadas.*.Total.numeric' => 'El total debe ser numérico.',
    ];

    public function validar()
    {
        try {
            $this->validate();

            foreach ($this->transferencias as $index => $transferencia) {

                $banco = $transferencia['IdBanco'] ?? null;
                $total = $transferencia['Total'] ?? null;

                if (
                    (!empty($banco) && ($total === null || $total === '')) ||
                    (empty($banco) && !empty($total))
                ) {
                    $this->activeTab = 'custom-tabs-2';
                    $this->addError(
                        "transferencias.$index",
                        "Transferencia #" . ($index + 1) . ": debe completar todos los campos."
                    );
                    $this->dispatch('error-modal');
                    return;
                }
            }

            foreach ($this->cheques as $index => $cheque) {

                $banco = $cheque['IdBanco'] ?? null;
                $numero = $cheque['Numero'] ?? null;
                $fechaEmision = $cheque['FechaEmision'] ?? null;
                $plaza = $cheque['Plaza'] ?? null;
                $total = $cheque['Total'] ?? null;

                $campos = [$banco, $numero, $fechaEmision, $plaza, $total];

                $hayAlgo = collect($campos)->filter(fn($v) => $v !== null && $v !== '')->isNotEmpty();
                $faltanCampos = collect($campos)->contains(fn($v) => $v === null || $v === '');

                if ($hayAlgo && $faltanCampos) {
                    $this->activeTab = 'custom-tabs-3';
                    $this->addError(
                        "cheques.$index",
                        "Cheque #" . ($index + 1) . ": debe completar todos los campos."
                    );
                    $this->dispatch('error-modal');
                    return;
                }

                if (!empty($total) && floatval($total) <= 0) {
                    $this->activeTab = 'custom-tabs-3';
                    $this->addError(
                        "cheques.$index.Total",
                        "Cheque #" . ($index + 1) . ": el importe debe ser mayor a 0."
                    );
                    $this->dispatch('error-modal');
                    return;
                }
            }

            foreach ($this->tarjetas as $index => $tarjeta) {

                $descripcion = $tarjeta['Descripcion'] ?? null;
                $total = $tarjeta['Total'] ?? null;

                if (
                    (!empty($descripcion) && ($total === null || $total === '')) ||
                    (empty($descripcion) && !empty($total))
                ) {
                    $this->activeTab = 'custom-tabs-4';
                    $this->addError(
                        "tarjetas.$index",
                        "Tarjeta #" . ($index + 1) . ": debe completar todos los campos."
                    );
                    $this->dispatch('error-modal');
                    return;
                }

                if (!empty($total) && floatval($total) < 0.01) {
                    $this->activeTab = 'custom-tabs-4';
                    $this->addError(
                        "tarjetas.$index.Total",
                        "Tarjeta #" . ($index + 1) . ": el importe debe ser mayor a 0."
                    );
                    $this->dispatch('error-modal');
                    return;
                }
            }

            if ($this->total_final < $this->total_imputado) {
                $this->addError(
                    'total_final',
                    "El importe cobrado es mayor que el importe del recibo"
                );

                $this->dispatch('error-modal');
                return;
            }

            $this->dispatch('modal-confirmacion');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('error-modal');
            throw $e;
        }
    }

    public function guardar()
    {
        $user_id = Auth::id();
        $now = now();

        $recibo_venta = ReciboVenta::create([
            'Letra' => 'X',
            'PuntoVenta' => $this->punto_venta,
            'Numero' => $this->numero,
            'NumeroCompleto' => "RC X 0001-0000{$this->numero}",
            'LetraNumeroCompleto' => 'X,RC X 0001-0000' . $this->numero,
            'FechaEmision' => $this->fecha_emision,

            'IdCliente' => $this->cliente->id,
            'RazonSocial' => $this->cliente->Nombre,
            'IdCondicionIva' => $this->cliente->IdCondicionIVA,
            'TipoDocumentoCliente' => $this->cliente->TipoDocumento,
            'NumeroDocumentoCliente' => $this->cliente->NroDocumento,
            'Direccion' => $this->cliente->Domicilio,
            'Localidad' => $this->cliente->localidad->Nombre,

            'RetencionDREI' => $this->retenciones['drei'],
            'RetencionIIBB' => $this->retenciones['iibb'],
            'RetencionIVA' => $this->retenciones['iva'],
            'RetencionGanancias' => $this->retenciones['ganancias'],
            'RetencionSUSS' => $this->retenciones['suss'],

            'Estado' => 'PENDIENTE',
            'Total' => $this->total_final,

            'Observaciones' => null,
            'NumeroTurno' => 0,
            'ReferenciaTurno' => 0,
            'AfectarPlanillaTurno' => 0,
            'FechaCreacion' => $now->toDateString(),
            'FechaActualizacion' => $now->toDateString(),
            'CreadoPor' => $user_id,
            'ActualizadoPor' => $user_id,
            'Activo' => 1,

            'CantidadImpresiones' => 0,
            'CantidadEnviosPorCorreo' => 0,
            'DescripcionSaldoTransportado' => null,
            'ImporteSaldoTransportado' => 0,
        ]);

        $crearCobro = function ($forma, $descripcion, $total) use ($recibo_venta, $user_id, $now) {
            return Cobro::create([
                'IdReciboVenta' => $recibo_venta->id,
                'FormaPago' => $forma,
                'Descripcion' => $descripcion,
                'Total' => $total,
                'FechaCreacion' => $now,
                'CreadoPor' => $user_id,
                'FechaActualizacion' => $now,
                'ActualizadoPor' => $user_id,
                'Activo' => 1,
            ]);
        };

        if ($this->efectivo > 0) {
            $crearCobro('EFECTIVO', 'EFECTIVO', $this->efectivo);
        }

        foreach ($this->transferencias as $transferencia) {

            if (!empty($transferencia['IdBanco']) && !empty($transferencia['Total'])) {

                $banco = Banco::find($transferencia['IdBanco']);

                $cobro = $crearCobro(
                    'TRANSFERENCIA',
                    $banco->Nombre ?? 'REVISAR!!',
                    $transferencia['Total']
                );

                TransferenciaCobro::create([
                    'IdCobro' => $cobro->id,
                    'IdBanco' => $banco->id,
                ]);
            }
        }

        foreach ($this->cheques as $cheque) {

            if (
                !empty($cheque['IdBanco']) &&
                !empty($cheque['Numero']) &&
                !empty($cheque['FechaEmision']) &&
                !empty($cheque['Plaza']) &&
                !empty($cheque['Total'])
            ) {

                $banco = Banco::find($cheque['IdBanco']);

                $cobro = $crearCobro(
                    'CHEQUE',
                    $banco->Nombre ?? 'REVISAR!!',
                    $cheque['Total']
                );

                Chequecobro::create([
                    'IdCobro' => $cobro->id,
                    'FechaEmision' => $cheque['FechaEmision'],
                    'FechaAcreditacion' => $cheque['FechaAcreditacion'],
                    'IdBanco' => $cheque['IdBanco'],
                    'Numero' => $cheque['Numero'],
                    'IdDestinoCheque' => $cheque['IdDestinoCheque'] ?? null,
                    'Plaza' => $cheque['Plaza'],
                    'eCheck' => $cheque['eCheck'],
                    'FechaCreacion' => $now,
                    'CreadoPor' => $user_id,
                    'FechaActualizacion' => $now,
                    'ActualizadoPor' => $user_id,
                    'Activo' => 1,
                ]);
            }
        }

        foreach ($this->tarjetas as $tarjeta) {

            if (!empty($tarjeta['Descripcion']) && !empty($tarjeta['Total'])) {

                $crearCobro(
                    'TARJETA',
                    $tarjeta['Descripcion'],
                    $tarjeta['Total']
                );
            }
        }

        foreach ($this->facturas_seleccionadas as $item) {

            $factura = FacturaVenta::find($item['IdFacturaVenta']);

            ItemReciboVenta::create([
                'IdReciboVenta' => $recibo_venta->id,
                'IdFacturaVenta' => $item['IdFacturaVenta'],
                'IdSubiva' => 0,
                'Descripcion' => $factura->NumeroCompleto,
                'Total' => $item['Total'] ?? 0,
                'FechaCreacion' => $now,
                'CreadoPor' => $user_id,
                'FechaActualizacion' => $now,
                'ActualizadoPor' => $user_id,
                'Activo' => 1,
            ]);

            $factura->update(['Estado' => 'COMPLETO']);
        }

        $totalImputado = $recibo_venta->itemsReciboVenta()->sum('Total');

        $remanente = round($recibo_venta->Total - $totalImputado, 2);

        if (abs($remanente) < 0.01) {
            $remanente = 0;
        }

        $recibo_venta->update([
            'Estado' => $remanente == 0 ? 'COMPLETO' : 'PENDIENTE'
        ]);

        return redirect()->route('ventas.ficha-del-cliente-recibo-venta.show', $recibo_venta);
    }


    public function mount()
    {
        $this->pto_ventas = PuntoDeVenta::all();
        $this->punto_venta = $this->pto_ventas->first()->id ?? null;
        $this->fecha_emision = Carbon::today()->format('Y-m-d');
        $this->numero = ReciboVenta::max('Numero') + 1;
        $this->id_cliente = $this->cliente->id;
        $this->nombre_cliente = $this->cliente->Nombre;

        $this->bancos = Banco::all();

        for ($i = 0; $i < 4; $i++) {
            $this->transferencias[$i] = [
                'IdBanco' => '',
                'Total' => '',
            ];
        }

        for ($i = 0; $i < 4; $i++) {
            $this->cheques[$i] = [
                'IdBanco' => '',
                'Numero' => '',
                'FechaEmision' => '',
                'FechaAcreditacion' => Carbon::today()->format('Y-m-d'),
                'Plaza' => '',
                'eCheck' => false,
                'Total' => '',
            ];
        }

        for ($i = 0; $i < 4; $i++) {
            $this->tarjetas[$i] = [
                'Descripcion' => '',
                'Total' => '',
            ];
        }

        $this->fechaEmisionCheque = Carbon::today()->format('Y-m-d');
        $this->fechaVencimientoCheque = Carbon::today()->format('Y-m-d');

        $this->facturas_venta = FacturaVenta::where('IdCliente', $this->cliente->id)->where('Estado', 'PENDIENTE')->get();

        foreach ($this->facturas_venta as $factura_venta) {
            $this->a_cobrar[$factura_venta->id] = 0;
        }
    }

    public function updatedRetenciones()
    {
        $this->recalcularTotalFinal();
    }


    public function limpiarTarjeta($index)
    {
        $this->tarjetas[$index] = [
            'Descripcion' => '',
            'Total' => '',
        ];

        $this->recalcularTotalFinal();
    }

    public function updatedTarjetas($value)
    {
        if ($value > 0) {
            $this->cantidad_tarjetas = $this->cantidad_tarjetas + 1;
        }
        else{
            $this->cantidad_tarjetas = $this->cantidad_tarjetas - 1;
        }

        $this->recalcularTotalFinal();
    }

    public function limpiarCheque($index)
    {
        $this->cheques[$index] = [
            'IdBanco' => '',
            'Numero' => '',
            'FechaEmision' => '',
            'FechaAcreditacion' => Carbon::today()->format('Y-m-d'),
            'Plaza' => '',
            'eCheck' => false,
            'Total' => '',
        ];

        $this->recalcularTotalFinal();
    }

    public function updatedCheques($value)
    {
        if ($value > 0) {
            $this->cantidad_cheques = $this->cantidad_cheques + 1;
        }
        else{
            $this->cantidad_cheques = $this->cantidad_cheques - 1;
        }

        $this->recalcularTotalFinal();
    }

    public function limpiarFila($index)
    {
        $this->transferencias[$index] = [
            'IdBanco' => '',
            'Total' => '',
        ];

        $this->recalcularTotalFinal();
    }

    public function updatedTransferencias($value)
    {
        if ($value > 0) {
            $this->cantidad_transferencias = $this->cantidad_transferencias + 1;
        }
        else{
            $this->cantidad_transferencias = $this->cantidad_tarjetas - 1;
        }

        $this->total_final = 0;

        foreach ($this->transferencias as $transferencia) {
            $this->total_final += floatval($transferencia['Total'] ?? 0);
        }

        $this->recalcularTotalFinal();
    }

    protected function recalcularTotalFinal()
    {
        $total = 0;

        $total += floatval($this->efectivo ?? 0);

        $this->cantidad_transferencias = 0;
        foreach ($this->transferencias as $transferencia) {
            $monto = floatval($transferencia['Total'] ?? 0);
            if ($monto > 0) $this->cantidad_transferencias++;
            $total += $monto;
        }

        $this->cantidad_cheques = 0;
        foreach ($this->cheques as $cheque) {
            $monto = floatval($cheque['Total'] ?? 0);
            if ($monto > 0) $this->cantidad_cheques++;
            $total += $monto;
        }

        $this->cantidad_tarjetas = 0;
        foreach ($this->tarjetas as $tarjeta) {
            $monto = floatval($tarjeta['Total'] ?? 0);
            if ($monto > 0) $this->cantidad_tarjetas++;
            $total += $monto;
        }

        $this->cantidad_retenciones = 0;
        foreach ($this->retenciones as $retencion) {
            $monto = floatval($retencion ?? 0);
            if ($monto > 0) $this->cantidad_retenciones++;
            $total += $monto;
        }

        $this->total_final = $total;
    }

    public function updatedEfectivo($value)
    {
        if ($value > 0) {
            $this->cantidad_efectivo = 1;
        }
        else{
            $this->cantidad_efectivo = 0;
        }

        $this->recalcularTotalFinal();
    }

    public function setActiveTab($tabId)
    {
        $this->activeTab = $tabId;
    }

    public function updatedSeleccionados($value, $key)
    {
        $id = $key;

        $factura = $this->facturas_venta->firstWhere('id', $id);

        if ($value) {
            $this->a_cobrar[$id] = $factura->Total;
        } else {
            $this->a_cobrar[$id] = null;
        }

        $this->actualizarTotalImputado();
    }

    public function actualizarTotalImputado()
    {
        $this->total_imputado = 0;

        foreach ($this->facturas_venta as $factura) {
            $id = $factura->id;

            if (!empty($this->facturas_seleccionadas[$id]) && $this->facturas_seleccionadas[$id]) {
                $this->total_imputado += floatval($this->a_cobrar[$id] ?? 0);
            }
        }
    }

    public function onACobrarChange($id, $value)
    {
        $factura = FacturaVenta::find($id);

        if ($factura->Total < $value) {
            $value = $factura->Total;
        }

        $this->a_cobrar[$id] = $value;

        if (isset($this->facturas_seleccionadas[$id])) {
            $this->facturas_seleccionadas[$id]['Total'] = floatval($value);
        }

        $this->actualizarTotalImputado();
    }

    public function onSeleccionChange($id, $value)
    {
        if ($value) {
            $factura = $this->facturas_venta->firstWhere('id', $id);

            $this->facturas_seleccionadas[$id] = [
                'IdFacturaVenta' => $id,
                'Total' => floatval($factura->Total),
            ];

            $this->a_cobrar[$id] = floatval($factura->Total);
        } else {
            unset($this->facturas_seleccionadas[$id]);
            $this->a_cobrar[$id] = 0;
        }

        $this->actualizarTotalImputado();
    }

    public function render()
    {
        return view('livewire.recibo-venta-create');
    }
}
