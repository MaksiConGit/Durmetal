<div>

    <x-layout2>
        <x-slot name="title">Reportes Premios por fecha de aprobación</x-slot>
        
        <x-simple-table2>
            <x-slot name="filtros">
                <div class="row">
                    <div class="col-2">
                        <label>DESDE APROBACIÓN</label>
                        <input type="date" class="form-control form-control-sm" wire:model.live="desde_fecha">
                    </div>
                    <div class="col-2">
                        <label>HASTA</label>
                        <input type="date" class="form-control form-control-sm" wire:model.live="hasta_fecha">
                    </div>
                </div>

            </div>
            </x-slot>
            <x-slot name="thead">

                <div class="mb-2">
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="checkAll" wire:click="seleccionarTodo" checked onclick="return false;">
                        <label for="checkAll" title="Seleccionar todos"></label>
                    </div>

                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="uncheckAll" wire:click="deseleccionarTodo" onclick="return false;">
                        <label for="uncheckAll" title="Deseleccionar todos"></label>
                    </div>
                </div>

                <tr>
                    <th></th>
                    <th>Fecha OTI</th>
                    <th>OTI</th>
                    <th>Cli.</th>
                    <th>Trat.</th>
                    <th>Material</th>
                    <th>Fecha Aprobación</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Cant.</th>
                    <th>Peso</th>
                    <th>CC</th>
                    <th>Coeficiente</th>
                    <th>Subtotal</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">

                @php $total_acumulado = 0; @endphp
                @forelse ($items_orden_trabajo as $item)
                    @php

                        $codigo_complejidad = 
                            \App\Models\CodigoComplejidad::where('IdTratamiento', $item->IdTratamiento)
                                ->where('CC', $item->CodigoComplejidad)
                                ->first();

                        $coef = $codigo_complejidad->Coeficiente ?? 0;
                        $subtotal = $coef * $item->Peso;
                        $total_acumulado += $subtotal;

                    @endphp
                    <tr class="border-t">
                        <td>
                            <input
                                type="checkbox"
                                wire:model.live="seleccionados.{{ $item->id }}"
                            >
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->ordenTrabajo->FechaEmision)->format('d/m/Y') }}</td>
                        <td>{{ $item->ordenTrabajo->Numero }}/{{ $item->ItemNumero }}</td>
                        <td>{{ $item->ordenTrabajo->cliente->id }}</td>
                        <td>{{ $item->tratamiento->Nombre }}</td>
                        <td>{{ $item->material->Nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->FechaActualizacionEstado)->format('d/m/Y') }}</td>
                        <td>{{ $item->Estado }}</td>
                        <td>{{ $item->Descripcion }}</td>
                        <td>{{ number_format($item->Cantidad, 2, '.', '') }}</td>
                        <td>{{ number_format($item->Peso, 2, '.', '') }}</td>
                        <td>{{ $item->CodigoComplejidad }}</td>
                        <td>{{ number_format($coef, 2, '.', '') }}</td>
                        <td>{{ number_format($subtotal, 2, '.', '') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-2">No se encontraron resultados.</td>
                    </tr>
                @endforelse

            </x-slot>
        </x-simple-table2>

    
        <div class="w-100 d-flex justify-content-between align-items-end mt-4">

            @if ($this->haySeleccionados())

                <div class="d-flex align-items-end">

                    <div class="mr-2">
                        <label
                            for="fecha_aprobacion"
                            class="font-weight-normal mb-1"
                        >
                            FECHA DE APROBACIÓN
                        </label>

                        <input
                            type="date"
                            id="fecha_aprobacion"
                            class="form-control form-control-sm"
                            wire:model="fecha_aprobacion"
                            style="width: 160px;"
                        >
                    </div>

                    <button
                        type="button"
                        class="btn btn-sidebar btn-sm bg-orange mr-2"
                        wire:click="guardarAprobacion"
                    >
                        <span class="text-white">Guardar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </button>

                    <button
                        type="button"
                        class="btn btn-sidebar btn-sm bg-orange"
                        wire:click="deseleccionarTodo"
                    >
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </button>

                </div>

            @else

                <div></div>

            @endif


            <div class="d-flex flex-column align-items-end">

                <div class="d-flex align-items-center">

                    <span
                        class="font-weight-bold text-dark mr-2"
                        style="font-size: 1.30rem;"
                    >
                        TOTAL
                    </span>

                    <input 
                        type="text"
                        disabled
                        value="{{ number_format($total_acumulado, 2, ',', '.') }}"
                        class="form-control form-control-sm"
                        style="
                            width: 160px;
                            font-size: 1rem;
                            color: #000;
                            text-align: right;
                            background-color: #e9ecef;
                        "
                    />

                    <input
                        type="hidden"
                        name="Total"
                        value="{{ $total_acumulado }}"
                    >

                </div>

                <div class="mt-3">

                    <a
                        class="btn btn-app bg-primary"
                        data-toggle="modal"
                        data-target="#modal-distribuir"
                        wire:click="inicializarPremios"
                    >
                        <i class="fas fa-share"></i> Distribuir
                    </a>

                </div>

            </div>

        </div>
    </x-layout2>

    <div
        class="modal fade"
        id="modal-distribuir"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
        wire:ignore.self
    >
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <form wire:submit.prevent="distribuirPremios">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Distribución de Premios
                        </h5>

                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row mb-3">

                            <div class="col-3">
                                <div class="form-group mb-0">
                                    <label
                                        for="nombre"
                                        class="font-weight-normal"
                                    >
                                        NOMBRE
                                    </label>

                                    <input
                                        type="text"
                                        id="nombre"
                                        class="form-control form-control-sm"
                                        wire:model.live="nombre"
                                    >
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group mb-0">
                                    <label
                                        for="fecha_desde"
                                        class="font-weight-normal"
                                    >
                                        DESDE
                                    </label>

                                    <input
                                        type="date"
                                        id="fecha_desde"
                                        class="form-control form-control-sm"
                                        wire:model.live="fecha_desde"
                                    >
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group mb-0">
                                    <label
                                        for="fecha_hasta"
                                        class="font-weight-normal"
                                    >
                                        HASTA
                                    </label>

                                    <input
                                        type="date"
                                        id="fecha_hasta"
                                        class="form-control form-control-sm"
                                        wire:model.live="fecha_hasta"
                                    >
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group mb-0">
                                    <label
                                        for="estado"
                                        class="font-weight-normal"
                                    >
                                        ESTADO
                                    </label>

                                    <select
                                        id="estado"
                                        class="form-control form-control-sm"
                                        wire:model.live="estado"
                                    >
                                        <option value="PENDIENTE">PENDIENTE</option>
                                        <option value="COMPLETO">COMPLETO</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-hover">

                                <thead>
                                    <tr>
                                        <th>Empleado</th>
                                        <th class="text-right">Base</th>
                                        <th class="text-right">Índice Base</th>
                                        <th class="text-right">Coeficiente</th>
                                        <th class="text-right">Premio</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($usuarios as $usuario)

                                        <tr>

                                            <td>
                                                {{ $usuario->Nombre }}
                                            </td>

                                            <td class="text-right">
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control form-control-sm text-right"
                                                    style="width: 90px; margin-left: auto;"
                                                    wire:model.live="premios.{{ $usuario->id }}.base"
                                                >
                                            </td>

                                            <td class="text-right">
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control form-control-sm text-right"
                                                    style="width: 90px; margin-left: auto;"
                                                    wire:model.live="premios.{{ $usuario->id }}.indice_base"
                                                >
                                            </td>

                                            <td class="text-right">
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control form-control-sm text-right"
                                                    style="width: 90px; margin-left: auto;"
                                                    wire:model.live="premios.{{ $usuario->id }}.coeficiente"
                                                >
                                            </td>

                                            <td class="text-right">
                                                {{ number_format(
                                                    $premios[$usuario->id]['premio'] ?? 0,
                                                    2,
                                                    ',',
                                                    '.'
                                                ) }}
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td
                                                colspan="5"
                                                class="text-center py-2"
                                            >
                                                No se encontraron usuarios.
                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>
                        </div>

                        <div class="w-100 d-flex justify-content-end mt-4">

                            <div class="d-flex align-items-center">

                                <span
                                    class="font-weight-bold text-dark mr-2"
                                    style="font-size: 1.30rem;"
                                >
                                    PREMIOS OTORGADOS
                                </span>

                                <input
                                    type="text"
                                    disabled
                                    value="{{ number_format($premios_otorgados, 2, ',', '.') }}"
                                    class="form-control form-control-sm"
                                    style="
                                        width: 160px;
                                        font-size: 1rem;
                                        color: #000;
                                        text-align: right;
                                        background-color: #e9ecef;
                                    "
                                >

                                <input
                                    type="hidden"
                                    name="PremiosOtorgados"
                                    value="{{ $premios_otorgados }}"
                                >

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer justify-content-end">

                        <button
                            type="submit"
                            class="btn btn-sidebar btn-sm bg-orange"
                        >
                            <span class="text-white">Guardar</span>
                            <i class="fas fa-check fa-fw text-white ml-2"></i>
                        </button>

                        <button
                            type="button"
                            class="btn btn-sidebar btn-sm bg-orange"
                            data-dismiss="modal"
                        >
                            <span class="text-white">Cancelar</span>
                            <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="error-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h4 class="modal-title">Error</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ $errors->first() }}</p>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('cerrar-modal', () => {
                $('#modal-distribuir').modal('hide');
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('error-modal', () => {
                const modal = new bootstrap.Modal(
                    document.getElementById('error-modal')
                );

                modal.show();
            });
        });
    </script>

</div>
