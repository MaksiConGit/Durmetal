<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CuentaGastos;
use App\Models\Facturacompra;
use App\Models\ImpuestoIva;
use Illuminate\Validation\ValidationException;

class FacturaCompraCreate extends Component
{
    public $selectedId = null;

    public $expandedId = null;

    public $newItems = [];
    public $tempId = -1;

    public $activeTabParametros = 'custom-tabs-1';

    public $punto_venta;
    public $numero;
    public $fecha_emision;
    public $fecha_vencimiento;
    public $fecha_registro;
    public $cae;
    public $fecha_vencimiento_cae;

    public $selectedIdItem = null;

    public $proveedor;
    public $proveedor_codigo;
    public $proveedor_nombre;

    public $impuestos_iva;
    public $cuentas_gastos;

    public $subtotal = 0;
    public $iva = 0;
    public $total_final = 0;
    public $bonificacion;
    public $recargo;
    public $percepciones;
    public $redondeo;

    public $percepcion_iibb = null;
    public $percepcion_iva = null;
    public $percepcion_ganancias = null;
    public $conceptos_no_gravados = null;
    public $impuesto_interno = null;
    public $impuesto_combustible = null;
    public $impuesto_tasa_vial = null;
    public $sellados = null;


    protected function rules()
    {
        return [
            'punto_venta' => [
                'required',
                'integer',
                'min:1',
                'max:9999',
            ],

            'numero' => [
                'required',
                'integer',
                'min:1',
                'max:9999999',
            ],

            'fecha_emision' => [
                'required',
                'date',
            ],

            'fecha_registro' => [
                'required',
                'date',
            ],

            'fecha_vencimiento' => [
                'required',
                'date',
                'after_or_equal:fecha_emision',
            ],

            'cae' => [
                'required',
                'string',
                'max:14',
            ],

            'fecha_vencimiento_cae' => [
                'required',
                'date',
            ],

            'bonificacion' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'recargo' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'percepcion_iibb' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'percepcion_iva' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'percepcion_ganancias' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'conceptos_no_gravados' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'impuesto_interno' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'impuesto_combustible' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'impuesto_tasa_vial' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'sellados' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'redondeo' => [
                'nullable',
                'numeric',
            ],
        ];
    }

    public function validarItems()
    {
        if (empty($this->newItems)) {
            $this->addError(
                'newItems',
                'La factura debe tener al menos un item.'
            );

            $this->dispatch('error-modal');

            return false;
        }

        foreach ($this->newItems as $index => $item) {

            $descripcion = $item['Descripcion'] ?? null;
            $cantidad = $item['Cantidad'] ?? null;
            $precio_unitario = $item['PrecioUnitarioNeto'] ?? null;

            if (empty(trim($descripcion ?? ''))) {
                $this->addError(
                    "newItems.$index.Descripcion",
                    "El item debe tener descripción."
                );

                $this->dispatch('error-modal');

                return false;
            }

            if (
                $cantidad === null ||
                $cantidad === '' ||
                !is_numeric($cantidad) ||
                $cantidad <= 0
            ) {
                $this->addError(
                    "newItems.$index.Cantidad",
                    "El item debe tener una cantidad mayor a 0."
                );

                $this->dispatch('error-modal');

                return false;
            }

            if (
                $precio_unitario === null ||
                $precio_unitario === '' ||
                !is_numeric($precio_unitario) ||
                $precio_unitario <= 0
            ) {
                $this->addError(
                    "newItems.$index.PrecioUnitarioNeto",
                    "El item debe tener un precio unitario mayor a 0."
                );

                $this->dispatch('error-modal');

                return false;
            }

            if (empty($item['CuentaGastos'])) {
                $this->addError(
                    "newItems.$index.CuentaGastos",
                    "El item debe tener una cuenta de gastos."
                );

                $this->dispatch('error-modal');

                return false;
            }

            if (empty($item['IVA'])) {
                $this->addError(
                    "newItems.$index.IVA",
                    "El item debe tener un impuesto IVA."
                );

                $this->dispatch('error-modal');

                return false;
            }
        }

        return true;
    }

    public function guardar()
    {

        $this->resetErrorBag();

            try {

                $this->validate();

            } catch (ValidationException $e) {

                $this->dispatch('error-modal');

                throw $e;
            }

            if (!$this->validarItems()) {
                return;
            }

        $mapa = [
            0 => 'C',
            1 => 'A',
            2 => 'A',
            3 => 'C',
            4 => 'C',
            5 => 'C',
        ];

        $letra = $mapa[$this->proveedor->condicionIVA->id] ?? 'B';

        $numero_completo = sprintf(
            'FC %s %04d-%07d',
            $letra,
            $this->punto_venta,
            $this->numero
        );

        $factura = Facturacompra::create([
            'Letra' => $letra,
            'PuntoVenta' => $this->punto_venta,
            'Numero' => $this->numero,
            'NumeroCompleto' => $numero_completo,

            'FechaEmision' => $this->fecha_emision,
            'FechaRegistro' => $this->fecha_registro,
            'FechaVencimiento' => $this->fecha_vencimiento,

            'TipoOperacion' => 'Cta Cte',

            'IdProveedor' => $this->proveedor_codigo,
            'IdCondicionIva' => $this->proveedor->IdCondicionIva,
            'NumeroDocumentoProveedor' => $this->proveedor->NumeroDocumento,

            'Neto' => $this->subtotal,
            'AjusteNeto' => 0,

            'IVA' => $this->iva,
            'AjusteIVA' => 0,

            'ImpuestoInterno' => $this->impuesto_interno ?? 0,
            'ImpuestoCombustible' => $this->impuesto_combustible ?? 0,
            'ImpuestoTV' => $this->impuesto_tasa_vial ?? 0,
            'ConceptosNoGravados' => $this->conceptos_no_gravados ?? 0,

            'PercepcionIIBB' => $this->percepcion_iibb ?? 0,
            'PercepcionIVA' => $this->percepcion_iva ?? 0,
            'PercepcionGanancias' => $this->percepcion_ganancias ?? 0,

            'Sellados' => $this->sellados ?? 0,

            'Bonificacion' => $this->bonificacion ?? 0,
            'Recargo' => $this->recargo ?? 0,
            'AjustePorRedondeo' => $this->redondeo ?? 0,

            'Total' => $this->total_final,

            'Estado' => 'PENDIENTE',
            'CAE' => $this->cae,
            'FechaVencimientoCAE' => $this->fecha_vencimiento_cae,
            'Observaciones' => null,

            'NumeroTurno' => 0,
            'ReferenciaTurno' => 0,

            'EsNotaDeDebito' => 0,
            'NroFacturaNotaDebito' => null,

            'FechaCreacion' => now(),
            'CreadoPor' => auth()->id(),
            'FechaActualizacion' => now(),
            'ActualizadoPor' => auth()->id(),

            'Activo' => 1,

            'LetraPuntoVentaNumeroIdProveedor' => 0,
        ]);

        foreach ($this->newItems as $newItem) {

            $impuesto_iva_item = ImpuestoIva::find($newItem['IVA']);

            $item_factura_compra = $factura->items()->create([
                'IdFacturaCompra' => $factura->id,
                'IdCuentaGastos' => $newItem['CuentaGastos'],
                'Descripcion' => $newItem['Descripcion'],
                'Cantidad' => $newItem['Cantidad'],
                'PrecioUnitario' => $newItem['PrecioUnitarioNeto'],
                'NroDeposito' => 0,
                'IdImpuestoIva' => $newItem['IVA'],
                'AlicuotaIVA' => $impuesto_iva_item->Tasa,
                'Total' => $newItem['Importe'],
                'AjusteTotal' => 0,
                'AfectarPlanillaTurno' => 0,
                'ControlarStock' => 0,
                'Estado' => 'PENDIENTE',
                'FechaCreacion' => now(),
                'CreadoPor' => auth()->id(),
                'FechaActualizacion' => now(),
                'ActualizadoPor' => auth()->id(),
                'Activo' => 1,
            ]);

        }

        return redirect()->route(
            'compras.ficha-del-proveedor.show',
            $this->proveedor
        );

    }

    public function mount()
    {
        $this->proveedor_codigo = $this->proveedor->id;
        $this->proveedor_nombre = $this->proveedor->Nombre;

        $this->impuestos_iva = ImpuestoIva::all();
        $this->cuentas_gastos = CuentaGastos::all();

        $this->fecha_emision = now()->format('Y-m-d');
        $this->fecha_registro = now()->format('Y-m-d');
        $this->fecha_vencimiento = now()->format('Y-m-d');
    }

    public function addNewItem()
    {
        foreach ($this->newItems as $item) {
            if (!empty($item['is_new'])) {
                return;
            }
        }

        $newItemId = $this->tempId--;

        $this->newItems[] = [
            'id' => $newItemId,
                'is_new' => true,

                'Descripcion' => null,
                'CodigoArticulo' => 4,
                'Cantidad' => 1,
                'IVA' => 1,
                'CuentaGastos' => 9,
                'PrecioUnitarioNeto' => null,
                'Importe' => null,
            ];

        $this->expandedId = $newItemId;
        $this->selectedIdItem = $newItemId;

        $this->dispatch('open-item', id: $newItemId);
    }

    public function updatedNewItems($value, $key)
    {
        $parts = explode('.', $key);

        $index = $parts[0];
        $campo = $parts[1] ?? null;

        if (!isset($this->newItems[$index])) {
            return;
        }

        if (in_array($campo, ['Cantidad', 'PrecioUnitarioNeto'])) {

            $cantidad = (float) ($this->newItems[$index]['Cantidad'] ?? 0);
            $precio = (float) ($this->newItems[$index]['PrecioUnitarioNeto'] ?? 0);

            $this->newItems[$index]['Importe'] = $cantidad * $precio;
        }

        $this->calcularTotales();
    }

    public function validar()
    {
        try {

            $this->resetErrorBag();

            foreach ($this->newItems as $index => $item) {

                $descripcion = $item['Descripcion'] ?? null;
                $cantidad = $item['Cantidad'] ?? null;
                $precio_unitario = $item['PrecioUnitarioNeto'] ?? null;

                if (empty(trim($descripcion ?? ''))) {
                    $this->addError(
                        "newItems.$index.Descripcion",
                        "El item debe tener descripción."
                    );

                    $this->dispatch('error-modal');
                    return;
                }

                if ($cantidad === null || $cantidad === '' || !is_numeric($cantidad) || $cantidad <= 0) {
                    $this->addError(
                        "newItems.$index.Cantidad",
                        "El item debe tener una cantidad mayor a 0."
                    );

                    $this->dispatch('error-modal');
                    return;
                }

                if ($precio_unitario === null || $precio_unitario === '' || !is_numeric($precio_unitario) || $precio_unitario <= 0) {
                    $this->addError(
                        "newItems.$index.PrecioUnitarioNeto",
                        "El item debe tener un precio unitario mayor a 0."
                    );

                    $this->dispatch('error-modal');
                    return;
                }

                $this->newItems[$index]['is_new'] = false;
            }

            $this->dispatch('close-all');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('error-modal');
            throw $e;
        }
    }

    public function calcularTotales()
    {
        $subtotalOriginal = 0;
        $ivaOriginal = 0;

        foreach ($this->newItems as $item) {

            $importe = (float) ($item['Importe'] ?? 0);

            $subtotalOriginal += $importe;

            $impuesto = $this->impuestos_iva->firstWhere(
                'id',
                $item['IVA'] ?? null
            );

            $tasa = (float) ($impuesto->Tasa ?? 0);

            $ivaOriginal += $importe * ($tasa / 100);
        }

        $bonificacion = (float) ($this->bonificacion ?? 0);
        $recargo = (float) ($this->recargo ?? 0);

        $factor = 1
            - ($bonificacion / 100)
            + ($recargo / 100);

        $this->subtotal = $subtotalOriginal * $factor;

        $this->iva = $ivaOriginal * $factor;

        $this->total_final =
            $this->subtotal
            + $this->iva
            + (float) ($this->percepciones ?? 0)
            + (float) ($this->redondeo ?? 0);
    }

    public function updatedBonificacion()
    {
        $this->calcularTotales();
    }

    public function updatedRecargo()
    {
        $this->calcularTotales();
    }

    public function updatedPercepciones()
    {
        $this->calcularTotales();
    }

    public function updatedRedondeo()
    {
        $this->calcularTotales();
    }

    public function calcularPercepciones()
    {
        $this->percepciones =
            (float) ($this->percepcion_iibb ?? 0)
            + (float) ($this->percepcion_iva ?? 0)
            + (float) ($this->percepcion_ganancias ?? 0)
            + (float) ($this->conceptos_no_gravados ?? 0)
            + (float) ($this->impuesto_interno ?? 0)
            + (float) ($this->impuesto_combustible ?? 0)
            + (float) ($this->impuesto_tasa_vial ?? 0)
            + (float) ($this->sellados ?? 0);

        $this->calcularTotales();
    }

    public function deleteItem($id)
    {
        foreach ($this->newItems as $index => $item) {
            if ($item['id'] == $id) {
                unset($this->newItems[$index]);
                break;
            }
        }

        $this->newItems = array_values($this->newItems);

        $this->selectedIdItem = null;

        $this->dispatch('close-all');
    }

    public function confirmarEliminarItem()
    {
        if (!$this->selectedIdItem) {
            return;
        }

        $this->dispatch('modal-confirmar-eliminar');
    }

    public function eliminarItem()
    {
        if (!$this->selectedIdItem) {
            return;
        }

        $id = $this->selectedIdItem;

        $this->newItems = array_values(
            array_filter($this->newItems, function ($item) use ($id) {
                return $item['id'] != $id;
            })
        );

        $this->selectedIdItem = null;

        $this->dispatch('close-all');
    }

    public function setActiveTabParametros($tabId)
    {
        $this->activeTabParametros = $tabId;
    }

    public function cancelarItem($itemId)
    {
        foreach ($this->newItems as $index => $item) {

            if ($item['id'] == $itemId) {

                if ($item['id'] < 0) {
                    unset($this->newItems[$index]);
                    $this->newItems = array_values($this->newItems);
                }

                break;
            }
        }

        if ($this->selectedIdItem === $itemId) {
            $this->selectedIdItem = null;
        }
    }



    public function render()
    {
        return view('livewire.factura-compra-create', [
            'expandedId' => $this->expandedId,
        ]);
    }
}
