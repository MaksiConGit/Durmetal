<?php

namespace App\Livewire;

use App\Models\ItemOrdenTrabajo;
use App\Models\ItemNotaEnvio;
use App\Models\NotaEnvio;
use App\Models\PuntoDeVenta;
use App\Models\CodigoComplejidad;
use App\Models\Dureza;
use App\Models\Material;
use App\Models\Tratamiento;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Arr;

class NotaEnvioEdit extends Component
{
    public $items_orden_trabajo;
    public $nota_envio;
    public $next_nota_numero;
    public $cliente;
    public $pto_ventas;
    public $fechaEmision;
    public $descripcion = [];
    public $precio_unitario = [];
    public $total = [];
    public $codigo_complejidad = [];
    public $codigo_invalido = [];
    public $descuento = [];
    public $seleccionados = [];
    public $subtotal = 0;
    public $base_imponible = 0;
    public $porcentaje_descuento = 0;
    public $iva = 0;
    public $total_final = 0;
    public $coeficiente = [];
    public $pendientes;
    public $activeTab = 'custom-tabs-1';
    public array $items_orden_trabajo_edit = [];
    public array $items_nota_envio_edit = [];
    public $items_nota_envio;

    // ---------- MOUNT ----------
    public function mount()
    {
        $this->fechaEmision = $this->nota_envio->FechaEmision;
        $this->pto_ventas = PuntoDeVenta::all();

        // Cargar items NotaEnvio con relación
        $this->items_nota_envio = $this->nota_envio
            ->itemsNotaEnvio()
            ->with('itemOrdenTrabajo')
            ->get();


        // --- MARCAR COMO SELECCIONADOS LOS ITEMS EXISTENTES DE LA NOTA ---
        foreach ($this->items_nota_envio as $itemNota) {
            $key = 'nota_' . $itemNota->id;

            // marcar checkbox como seleccionado
            $this->seleccionados[$key] = true;

            // cargar descripción para que aparezca en los inputs
            $this->descripcion[$key] = $itemNota->Descripcion;

            // si usás descuento global por item, cargarlo
            $this->descuento[$key] = $itemNota->Descuento ?? 0;

            // cargar totales al inicio
            $this->total[$key] = ($this->precio_unitario[$key] ?? 0) * ($itemNota->Peso ?? 0);
        }

        // Obtener ids de items_orden_trabajo ya usados
        $ids_excluidos = $this->items_nota_envio
            ->pluck('IdItemOrdenTrabajo')
            ->toArray();

        // Cargar items_orden_trabajo (según pendientes o aprobados)
        if ($this->pendientes) {
            $this->items_orden_trabajo = ItemOrdenTrabajo::whereHas('ordenTrabajo', function ($q) {
                    $q->where('IdCliente', $this->nota_envio->cliente->id)
                      ->where('Estado', 'PENDIENTE');
                })
                ->whereNotIn('id', $ids_excluidos)
                ->where('ConNotaEnvio', false)
                ->get();
        } else {
            $this->items_orden_trabajo = ItemOrdenTrabajo::whereHas('ordenTrabajo', function ($q) {
                    $q->where('IdCliente', $this->nota_envio->cliente->id)
                      ->where('Estado', 'PENDIENTE');
                })
                ->where('Estado', 'APROBADO')
                ->whereNotIn('id', $ids_excluidos)
                ->where('ConNotaEnvio', false)
                ->get();
        }

        $this->next_nota_numero = $this->nota_envio->Numero;

        // --- CARGAR DATOS PARA ITEMS NOTA (uso clave interna 'nota_{id}') ---
        foreach ($this->items_nota_envio as $itemNota) {
            $itemOT = $itemNota->itemOrdenTrabajo;
            $codigo = CodigoComplejidad::where('IdTratamiento', $itemOT->IdTratamiento)
                ->where('CC', $itemNota->CodigoComplejidad)
                ->first();

            $precio = $codigo->Precio ?? 0;
            $coef   = $codigo->Coeficiente ?? 1;

            // clave interna
            $key = 'nota_' . $itemNota->id; // <<-- nota_ prefix

            $this->codigo_complejidad[$key] = $itemNota->CodigoComplejidad;
            $this->precio_unitario[$key] = $precio;
            $this->coeficiente[$key] = $coef;
            $this->descuento[$key] = $itemNota->PorcentajeDescuento ?? 0;
            $this->total[$key] = $itemNota->Total ?? 0;;
            $this->codigo_invalido[$key] = false;

            $this->items_nota_envio_edit[$key] = [
                'tratamiento_id' => $itemOT->IdTratamiento,
                'dureza_id'      => $itemOT->IdDureza,
                'material_id'    => $itemOT->IdMaterial,
                'Descripcion'   => $itemNota->Descripcion ?? $itemOT->Descripcion,
                'Cantidad'      => $itemNota->Cantidad,
                'Peso'          => $itemNota->Peso,
                'DurezaSolicitadaMinima' => $itemOT->DurezaSolicitadaMinima,
                'DurezaSolicitadaMaxima' => $itemOT->DurezaSolicitadaMaxima,
                'Observaciones' => $itemOT->Observaciones,
            ];
        }

        // --- CARGAR DATOS PARA ITEMS OT (uso clave interna 'ot_{id}') ---
        foreach ($this->items_orden_trabajo as $item) {
            $codigo = CodigoComplejidad::where('IdTratamiento', $item->IdTratamiento)
                ->where('CC', $item->CodigoComplejidad)
                ->first();

            $precio = $codigo->Precio ?? 0;
            $coef = $codigo->Coeficiente ?? 1;

            $key = 'ot_' . $item->id; // <<-- ot_ prefix

            $this->codigo_complejidad[$key] = $item->CodigoComplejidad;
            $this->precio_unitario[$key] = $precio;
            $this->coeficiente[$key] = $coef;
            $this->descuento[$key] = 0;
            $this->total[$key] = $precio * ($item->Peso ?? 0);
            $this->codigo_invalido[$key] = false;

            $this->items_orden_trabajo_edit[$key] = [
                'tratamiento_id' => $item->IdTratamiento,
                'dureza_id' => $item->IdDureza,
                'material_id' => $item->IdMaterial,
                'Descripcion' => $item->Descripcion,
                'Cantidad' => $item->Cantidad,
                'Peso' => $item->Peso,
                'DurezaSolicitadaMinima' => $item->DurezaSolicitadaMinima,
                'DurezaSolicitadaMaxima' => $item->DurezaSolicitadaMaxima,
                'Observaciones' => $item->Observaciones,
            ];
        }

        // --- Restaurar estado de session (compatibilidad básica) ---
        if (session()->has('nota_envio_state')) {
            $state = session('nota_envio_state');

            // Si el estado previo tenía keys numéricas, los convertimos a nuestras claves internas.
            $mapped = [
                'seleccionados' => [],
                'descripcion' => [],
                'codigo_complejidad' => [],
                'descuento' => [],
                'precio_unitario' => [],
                'total' => [],
                'porcentaje_descuento' => null,
            ];

            foreach ($state['seleccionados'] ?? [] as $k => $v) {
                // si key es numérica y corresponde a un OT existente -> ot_{id}
                if (is_numeric($k) && $this->items_orden_trabajo->firstWhere('id', $k)) {
                    $mapped['seleccionados']['ot_' . $k] = $v;
                } elseif (is_numeric($k) && $this->items_nota_envio->firstWhere('id', $k)) {
                    $mapped['seleccionados']['nota_' . $k] = $v;
                } else {
                    // si ya viene con prefix lo dejamos
                    $mapped['seleccionados'][$k] = $v;
                }
            }

            // copiar otros arreglos (codigo_complejidad, descuento, precio_unitario, total)
            foreach (['codigo_complejidad','descuento','precio_unitario','total','descripcion'] as $arrName) {
                foreach ($state[$arrName] ?? [] as $k => $v) {
                    if (is_numeric($k) && $this->items_orden_trabajo->firstWhere('id', $k)) {
                        $mapped[$arrName]['ot_' . $k] = $v;
                    } elseif (is_numeric($k) && $this->items_nota_envio->firstWhere('id', $k)) {
                        $mapped[$arrName]['nota_' . $k] = $v;
                    } else {
                        $mapped[$arrName][$k] = $v;
                    }
                }
            }

            $this->seleccionados = $mapped['seleccionados'] ?? [];
            $this->descripcion = $mapped['descripcion'] ?? [];
            $this->codigo_complejidad = $mapped['codigo_complejidad'] ?? $this->codigo_complejidad;
            $this->descuento = $mapped['descuento'] ?? $this->descuento;
            $this->precio_unitario = $mapped['precio_unitario'] ?? $this->precio_unitario;
            $this->total = $mapped['total'] ?? $this->total;
            $this->porcentaje_descuento = $state['porcentaje_descuento'] ?? null;

            // Re-evaluar codigos para items_orden_trabajo por si hay inconsistencias
            foreach ($this->items_orden_trabajo as $item) {
                $key = 'ot_'.$item->id;
                $codigoActual = $this->codigo_complejidad[$key] ?? $item->CodigoComplejidad;

                $codigo = CodigoComplejidad::where('IdTratamiento', $item->IdTratamiento)
                    ->where('CC', $codigoActual)
                    ->first();

                if ($codigo) {
                    $this->precio_unitario[$key] = $codigo->Precio;
                    $this->coeficiente[$key] = $codigo->Coeficiente;
                    $this->total[$key] = $codigo->Precio * $item->Peso;
                    $this->codigo_invalido[$key] = false;
                } else {
                    $this->precio_unitario[$key] = 0;
                    $this->coeficiente[$key] = 0;
                    $this->total[$key] = 0;
                    $this->codigo_invalido[$key] = true;
                }
            }
        }

        $this->actualizarSubtotal();
    }

    public function setActiveTab($tabId)
    {
        $this->activeTab = $tabId;
    }

    // ---------- HELPERS ----------

    /**
     * Resuelve una clave interna ('nota_123' o 'ot_456') y devuelve:
     * ['type' => 'nota'|'ot', 'id' => int, 'item' => ItemOrdenTrabajo|null, 'itemNota' => ItemNotaEnvio|null]
     */
    protected function resolveKey(string $key)
    {
        if (strpos($key, 'nota_') === 0) {
            $id = intval(substr($key, strlen('nota_')));
            $itemNota = $this->items_nota_envio->firstWhere('id', $id);
            $item = $itemNota ? $itemNota->itemOrdenTrabajo : null;
            return ['type' => 'nota', 'id' => $id, 'item' => $item, 'itemNota' => $itemNota];
        }

        if (strpos($key, 'ot_') === 0) {
            $id = intval(substr($key, strlen('ot_')));
            $item = $this->items_orden_trabajo->firstWhere('id', $id);
            return ['type' => 'ot', 'id' => $id, 'item' => $item, 'itemNota' => null];
        }

        // fallback: try numeric as OT
        if (is_numeric($key)) {
            $id = intval($key);
            $item = $this->items_orden_trabajo->firstWhere('id', $id);
            if ($item) return ['type' => 'ot', 'id' => $id, 'item' => $item, 'itemNota' => null];
            $itemNota = $this->items_nota_envio->firstWhere('id', $id);
            return ['type' => 'nota', 'id' => $id, 'item' => $itemNota?->itemOrdenTrabajo ?? null, 'itemNota' => $itemNota];
        }

        return ['type' => null, 'id' => null, 'item' => null, 'itemNota' => null];
    }

    protected function allKeys(): array
    {
        $keys = [];
        foreach ($this->items_nota_envio as $i) $keys[] = 'nota_'.$i->id;
        foreach ($this->items_orden_trabajo as $i) $keys[] = 'ot_'.$i->id;
        return $keys;
    }

    // ---------- EVENTOS / MÉTODOS ----------

    public function onCodigoComplejidadChange($key, $nuevoCodigo)
    {
        // key: 'nota_123' | 'ot_456'
        $this->codigo_complejidad[$key] = $nuevoCodigo;

        $resolved = $this->resolveKey($key);
        $item = $resolved['item'];

        if (!$item) {
            $this->codigo_invalido[$key] = true;
            $this->precio_unitario[$key] = 0;
            $this->total[$key] = 0;
            $this->coeficiente[$key] = 0;
            $this->actualizarSubtotal();
            return;
        }

        $codigo = CodigoComplejidad::where('IdTratamiento', $item->IdTratamiento)
            ->where('CC', $nuevoCodigo)
            ->first();

        if ($codigo) {
            $this->codigo_invalido[$key] = false;
            $this->precio_unitario[$key] = $codigo->Precio;
            $this->total[$key] = $codigo->Precio * ($item->Peso ?? 0);
            $this->coeficiente[$key] = $codigo->Coeficiente;
        } else {
            $this->codigo_invalido[$key] = true;
            $this->precio_unitario[$key] = 0;
            $this->total[$key] = 0;
            $this->coeficiente[$key] = 0;
        }

        $this->actualizarSubtotal();
    }

    // updatedDescuento is a Livewire watcher that receives ($value, $key)
    public function updatedDescuento($value, $key)
    {
        $resolved = $this->resolveKey($key);
        $item = $resolved['item'];

        $peso = $item->Peso ?? 0;
        $precio = $this->precio_unitario[$key] ?? 0;
        $descuento = max(0, min((float)$value, 100));

        $this->total[$key] = ($precio * $peso) * (1 - $descuento / 100);
        $this->actualizarSubtotal();
    }

    // Seleccionado cambió (checkbox) -> key puede ser 'nota_..' o 'ot_..'
    public function updatedSeleccionados($value, $key)
    {
        $resolved = $this->resolveKey($key);
        $item = $resolved['item'];
        $type = $resolved['type'];
        $id = $resolved['id'];

        if (!$item) return;

        // si se selecciona, prellenar descripcion si no hay una personalizada
        if (!empty($this->seleccionados[$key]) && $this->seleccionados[$key]) {
            $tratamiento = $item->tratamiento->Nombre ?? '';
            $material = $item->material->Nombre ?? '';
            $descripcionOriginal = $item->Descripcion ?? '';
            $remito = $item->ordenTrabajo->NumeroRemitoCliente ?? '';

            $this->descripcion[$key] = "{$tratamiento}-{$material}-{$descripcionOriginal}-???? {$remito}";
        } else {
            // deseleccionado: restaurar descripcion original
            if ($type === 'nota') {
                $itemNota = $resolved['itemNota'];
                $this->descripcion[$key] = $itemNota->Descripcion ?? $item->Descripcion ?? '';
            } else {
                $this->descripcion[$key] = $item->Descripcion ?? '';
            }
        }

        $this->actualizarSubtotal();
    }

    public function updatedTotal()
    {
        $this->actualizarSubtotal();
    }

    public function actualizarSubtotal()
    {
        $this->subtotal = 0;

        // sumar solo keys existentes en colecciones actuales
        foreach ($this->allKeys() as $key) {
            if (!empty($this->seleccionados[$key]) && $this->seleccionados[$key]) {
                $this->subtotal += floatval($this->total[$key] ?? 0);
            }
        }

        $this->onPorcentajeDescuentoChange($this->porcentaje_descuento);
    }

    // onPrecioChange ahora recibe la clave interna (ej: 'nota_5' o 'ot_10')
    public function onPrecioChange($key, $value)
    {
        $resolved = $this->resolveKey($key);
        $item = $resolved['item'];

        $peso = $item->Peso ?? 0;
        $this->precio_unitario[$key] = floatval($value);
        $this->total[$key] = floatval($value) * floatval($peso);

        $this->actualizarSubtotal();
    }

    public function onPorcentajeDescuentoChange($value)
    {
        $porcentaje = floatval($value);

        $this->base_imponible = $this->subtotal - ($this->subtotal * ($porcentaje / 100));

        $this->iva = $this->base_imponible * 0.21;

        $this->total_final = $this->base_imponible + $this->iva;
    }

    public function seleccionarTodo()
    {
        foreach ($this->allKeys() as $key) {
            $this->seleccionados[$key] = true;
            $this->updatedSeleccionados(true, $key);
        }

        $this->actualizarSubtotal();
    }

    public function deseleccionarTodo()
    {
        foreach ($this->allKeys() as $key) {
            $this->seleccionados[$key] = false;
            $this->updatedSeleccionados(false, $key);
        }

        $this->actualizarSubtotal();
    }

    public function guardarEstado()
    {
        // Guardamos el state tal cual (con keys internas)
        session()->put('nota_envio_state', [
            'seleccionados' => $this->seleccionados,
            'descripcion' => $this->descripcion,
            'codigo_complejidad' => $this->codigo_complejidad,
            'descuento' => $this->descuento,
            'precio_unitario' => $this->precio_unitario,
            'total' => $this->total,
            'porcentaje_descuento' => $this->porcentaje_descuento,
        ]);
    }

    public function render()
    {
        return view('livewire.nota-envio-edit', [
            'tratamientos' => Tratamiento::all(),
            'durezas' => Dureza::all(),
            'materiales' => Material::all(),
        ]);
    }
}
