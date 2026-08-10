<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ItemOrdenTrabajo;
use App\Models\Tratamiento;
use Illuminate\Support\Carbon;
use App\Models\Client;
use App\Models\User;
use App\Models\Premio;
use App\Models\FactorPremio;
use App\Models\FactorPremioUsuario;

class ReportesPremiosAprobacion extends Component
{
    public $desde_fecha;
    public $hasta_fecha;
    public $seleccionados = [];
    public $usuarios;

    public $nombre;
    public $fecha_desde;
    public $fecha_hasta;
    public $estado;
    public $premios = [];
    public $premios_otorgados = 0;

    public $fecha_aprobacion;

    protected function rules()
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'fecha_desde' => [
                'required',
                'date',
            ],

            'fecha_hasta' => [
                'required',
                'date',
                'after_or_equal:fecha_desde',
            ],

            'estado' => [
                'required',
                'in:PENDIENTE,COMPLETO',
            ],

            'premios' => [
                'required',
                'array',
                'min:1',
            ],

            'premios.*.base' => [
                'required',
                'numeric',
                'min:0',
            ],

            'premios.*.indice_base' => [
                'required',
                'numeric',
                'min:0',
            ],

            'premios.*.coeficiente' => [
                'required',
                'numeric',
                'min:0',
            ],

            'premios.*.premio' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }

    public function mount()
    {
        $this->usuarios = User::where('CobraPremio', 1)->get();

        $this->hasta_fecha = Carbon::today()->format('Y-m-d');
        $this->desde_fecha = Carbon::now()->subMonths(1)->format('Y-m-d');

        $this->fecha_hasta = Carbon::today()->format('Y-m-d');
        $this->fecha_desde = Carbon::now()->subMonth()->format('Y-m-d');

        $this->estado = 'PENDIENTE';

        $this->fecha_aprobacion = Carbon::today()->format('Y-m-d');
    }

    public function obtenerCoeficienteUsuario($usuario)
    {
        $factoresPremio = FactorPremio::all();

        $factoresPremioUsuario = FactorPremioUsuario::where(
            'IdUsuario',
            $usuario->id
        )->get();

        $total = 0;
        $cantidad = 0;

        foreach ($factoresPremio as $factor) {

            $factorUsuario = $factoresPremioUsuario->firstWhere(
                'IdFactorPremio',
                $factor->id
            );

            $activo = $factoresPremioUsuario->contains(
                'IdFactorPremio',
                $factor->id
            );

            if ($activo) {
                $valor = $factorUsuario->Valor ?? $factor->ValorPredeterminado;

                $total += (float) $valor;
                $cantidad++;
            }
        }

        return $cantidad > 0
            ? round($total / $cantidad, 2)
            : 0;
    }

    public function haySeleccionados()
    {
        return collect($this->seleccionados)
            ->filter(fn ($seleccionado) => $seleccionado)
            ->isNotEmpty();
    }

    public function guardarAprobacion()
    {
        $this->validate([
            'fecha_aprobacion' => [
                'required',
                'date',
            ],
        ]);

        foreach ($this->seleccionados as $itemId => $seleccionado) {

            if ($seleccionado) {
                ItemOrdenTrabajo::where('id', $itemId)
                    ->update([
                        'FechaActualizacionEstado' => $this->fecha_aprobacion,
                    ]);
            }
        }

        $this->seleccionados = [];

        session()->flash(
            'success',
            'La fecha de aprobación fue actualizada correctamente.'
        );
    }

    public function distribuirPremios()
    {
        try {

            $this->validate();

            Premio::create([
                'Nombre' => $this->nombre,
                'FechaDesde' => $this->fecha_desde,
                'FechaHasta' => $this->fecha_hasta,
                'Premio' => $this->premios_otorgados,
                'Estado' => $this->estado,
                'FechaCreacion' => now(),
                'CreadoPor' => auth()->id(),
                'FechaActualizacion' => now(),
                'ActualizadoPor' => auth()->id(),
            ]);

            $this->nombre = '';

            $this->fecha_desde = Carbon::today()
                ->subMonth()
                ->format('Y-m-d');

            $this->fecha_hasta = Carbon::today()
                ->format('Y-m-d');

            $this->estado = 'PENDIENTE';

            $this->premios = [];
            $this->premios_otorgados = 0;

            session()->flash(
                'success',
                'Los premios fueron guardados correctamente.'
            );

            $this->dispatch('cerrar-modal');

        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->dispatch('error-modal');

            throw $e;
        }
    }

    public function calcularPremios($total_acumulado)
    {
        $this->premios_otorgados = 0;

        foreach ($this->usuarios as $usuario) {

            $base = $total_acumulado;
            $indice_base = $usuario->IndiceBasePremio ?? 0;
            $coeficiente = 1;

            $premio = $base * $indice_base * $coeficiente;

            $this->premios[$usuario->id] = [
                'base' => $base,
                'indice_base' => $indice_base,
                'coeficiente' => $coeficiente,
                'premio' => $premio,
            ];

            $this->premios_otorgados += $premio;
        }
    }

    public function inicializarPremios()
    {
        $total_acumulado = $this->obtenerTotalAcumulado();

        $this->premios = [];
        $this->premios_otorgados = 0;

        foreach ($this->usuarios as $usuario) {

            $base = $total_acumulado;
            $indice_base = $usuario->IndiceBasePremio ?? 0;
            $coeficiente = $this->obtenerCoeficienteUsuario($usuario);

            $premio = $base * $indice_base * $coeficiente;

            $this->premios[$usuario->id] = [
                'base' => $base,
                'indice_base' => $indice_base,
                'coeficiente' => $coeficiente,
                'premio' => $premio,
            ];

            $this->premios_otorgados += $premio;
        }
    }

    public function updatedPremios()
    {
        $this->premios_otorgados = 0;

        foreach ($this->premios as $id => &$datos) {

            $base = (float) ($datos['base'] ?? 0);
            $indice_base = (float) ($datos['indice_base'] ?? 0);
            $coeficiente = (float) ($datos['coeficiente'] ?? 0);

            $datos['premio'] = $base * $indice_base * $coeficiente;

            $this->premios_otorgados += $datos['premio'];
        }
    }

    public function obtenerTotalAcumulado()
    {
        $total = 0;

        foreach ($this->obtenerItems() as $item) {

            $codigo_complejidad = \App\Models\CodigoComplejidad::where(
                'IdTratamiento',
                $item->IdTratamiento
            )
            ->where('CC', $item->CodigoComplejidad)
            ->first();

            $coef = $codigo_complejidad->Coeficiente ?? 0;

            $total += $coef * $item->Peso;
        }

        return $total;
    }

    public function seleccionarTodo()
    {
        $items = $this->obtenerItems();

        foreach ($items as $item) {
            $this->seleccionados[$item->id] = true;
        }
    }

    public function deseleccionarTodo()
    {
        $items = $this->obtenerItems();

        foreach ($items as $item) {
            $this->seleccionados[$item->id] = false;
        }
    }

    private function obtenerItems()
    {
        $query = ItemOrdenTrabajo::with([
            'ordenTrabajo.cliente',
            'tratamiento',
            'material',
            'codigoComplejidad',
        ]);

        if ($this->desde_fecha && $this->hasta_fecha) {
            $query->whereBetween('FechaActualizacionEstado', [
                Carbon::parse($this->desde_fecha)->startOfDay(),
                Carbon::parse($this->hasta_fecha)->endOfDay(),
            ]);
        }

        $query->where('Estado', 'APROBADO');

        return $query->get();
    }

    public function render()
    {
        $items = $this->obtenerItems();

        $total_acumulado = 0;

        foreach ($items as $item) {

            $codigo_complejidad = \App\Models\CodigoComplejidad::where(
                'IdTratamiento',
                $item->IdTratamiento
            )
            ->where('CC', $item->CodigoComplejidad)
            ->first();

            $coef = $codigo_complejidad->Coeficiente ?? 0;

            $total_acumulado += $coef * $item->Peso;
        }

        return view('livewire.reportes-premios-aprobacion', [
            'items_orden_trabajo' => $items,
            'total_acumulado' => $total_acumulado,
        ]);
    }

}