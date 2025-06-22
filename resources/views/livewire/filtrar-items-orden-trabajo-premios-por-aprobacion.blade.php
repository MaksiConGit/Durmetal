<div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-wrap gap-2">
                    <div class="col-md-3">

                        <x-form-input-date-livewire>
                            <x-slot name="label">Desde</x-slot>
                            <x-slot name="livewire">wire:model.live="fecha_inicio"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-date-livewire>

                    </div>
                    <div class="col-md-3">

                        <x-form-input-date-livewire>
                            <x-slot name="label">Hasta</x-slot>
                            <x-slot name="livewire">wire:model.live="fecha_fin"</x-slot>
                            <x-slot name="name"></x-slot>
                            <x-slot name="value">{{now()}}</x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-date-livewire>

                    </div>
                    
                </div>
            </div>
        </div>

    </div>

    @php $total_acumulado = 0; @endphp
        <form action="{{ route('reportes.premios-por-aprobacion.update') }}" method="POST">
            @csrf
            @method('PUT')
            <x-data-table-no-plus-buttons>
            
                <x-slot name="table_title">Items Órden Trabajo</x-slot>
                <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th></th>
                        <th>Fecha</th>
                        <th>OTI</th>
                        <th>Cli.</th>
                        <th>Trat.</th>
                        <th>Material</th>
                        <th>Descripción</th>
                        <th>Cant.</th>
                        <th>Peso</th>
                        <th>CC</th>
                        <th>Coeficiente</th>
                        <th>Subtotal</th>
                    </tr>
                </x-slot>
                <x-slot name="body_tr">
                    @php $total_acumulado = 0; @endphp
                    @forelse ($items_orden_trabajo as $item)
                        @php
                            $coef = $item->codigoComplejidad->Coeficiente ?? 0;
                            $subtotal = $coef * $item->Peso;
                            $total_acumulado += $subtotal;
                        @endphp
                        <tr class="border-t">
                            <td><input type="checkbox" name="ItemOrdenTrabajo_ids[]" value="{{ $item->id }}"></td>
                            <td>{{ $item->ordenTrabajo->FechaEmision }}</td>
                            <td>{{ $item->ItemNumero }} / {{ $item->ordenTrabajo->Numero }}</td>
                            <td>[{{ $item->ordenTrabajo->cliente->id }}] {{ $item->ordenTrabajo->cliente->Nombre }}</td>
                            <td>{{ $item->tratamiento->Nombre }}</td>
                            <td>{{ $item->material->Nombre }}</td>
                            <td>{{ $item->FechaActualizacionEstado }}</td>
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
                            <td colspan="13" class="text-center py-2">No se encontraron resultados.</td>
                        </tr>
                    @endforelse
                </x-slot>
                <x-slot name="foot_tr">
                    <tr>
                        <th></th>
                        <th>Fecha</th>
                        <th>OTI</th>
                        <th>Cli.</th>
                        <th>Trat.</th>
                        <th>Material</th>
                        <th>Descripción</th>
                        <th>Cant.</th>
                        <th>Peso</th>
                        <th>CC</th>
                        <th>Coeficiente</th>
                        <th>Subtotal</th>
                    </tr>
                </x-slot>

                <x-slot name="buttons">
                    <div class="row mb-3">
                        <div class="col-md-3">


                            <x-form-input-date>
                                <x-slot name="label">Fecha de Aprobación</x-slot>
                                <x-slot name="name">FechaActualizacionEstado</x-slot>
                                <x-slot name="value">{{ now()->format('Y-m-d') }}</x-slot>
                                <x-slot name="message"></x-slot>
                                <x-slot name="error"></x-slot>
                            </x-form-input-date>

                            <div class="text-center">
                                <x-form-button>
                                    <x-slot name="text">Guardar</x-slot>
                                    <x-slot name="color">success</x-slot>
                                </x-form-button>
                                <x-button>
                                    <x-slot name="text">Cancelar</x-slot>
                                    <x-slot name="color">danger</x-slot>
                                    <x-slot name="href">{{ route('index') }}</x-slot>
                                </x-button>
                                @if(session('success'))
                                    <div class="success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </div>



                        </div>

                        <div class="col-md-6"></div>

                        <div class="col-md-3 text-end">
                            <x-form-input-disabled>
                                <x-slot name="label">Total</x-slot>
                                <x-slot name="name"></x-slot>
                                <x-slot name="placeholder"></x-slot>
                                <x-slot name="value">{{ number_format($total_acumulado, 2, '.', '') }}</x-slot>
                                <x-slot name="message"></x-slot>
                                <x-slot name="error"></x-slot>
                            </x-form-input-disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col text-end">
                            <x-button>
                                <x-slot name="text">Distribuir</x-slot>
                                <x-slot name="color">success</x-slot>
                                <x-slot name="href">{{ route('repartir-premios.create', ['total' => $total_acumulado]) }}</x-slot>
                            </x-button>
                            <x-button>
                                <x-slot name="text">Cancelar</x-slot>
                                <x-slot name="color">danger</x-slot>
                                <x-slot name="href">{{ route('index') }}</x-slot>
                            </x-button>
                        </div>
                    </div>
                </x-slot>

            </x-data-table-no-plus-buttons>
        </form>

</div>
{{-- 
<div>
    <div class="mb-4 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <label>Desde aprobación:</label>
            <input type="date" wire:model.live="fecha_inicio" class="border p-1 w-full">
        </div>

        <div>
            <label>Hasta:</label>
            <input type="date" wire:model.live="fecha_fin" class="border p-1 w-full">
        </div>
    </div>
    
    <div class="overflow-x-auto">
        @php $total_acumulado = 0; @endphp
        <form action="{{ route('reportes.premios-por-aprobacion.update') }}" method="POST">
            @csrf
            @method('PUT')
            <table class="table-auto w-full border">
                <thead>
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
                </thead>
                <tbody>
                    @php $total_acumulado = 0; @endphp
                    @forelse ($items_orden_trabajo as $item)
                        @php
                            $coef = $item->codigoComplejidad->Coeficiente ?? 0;
                            $subtotal = $coef * $item->Peso;
                            $total_acumulado += $subtotal;
                        @endphp
                        <tr class="border-t">
                            <td><input type="checkbox" name="ItemOrdenTrabajo_ids[]" value="{{ $item->id }}"></td>
                            <td>{{ $item->ordenTrabajo->FechaEmision }}</td>
                            <td>{{ $item->ItemNumero }} / {{ $item->ordenTrabajo->Numero }}</td>
                            <td>[{{ $item->ordenTrabajo->cliente->id }}] {{ $item->ordenTrabajo->cliente->Nombre }}</td>
                            <td>{{ $item->tratamiento->Nombre }}</td>
                            <td>{{ $item->material->Nombre }}</td>
                            <td>{{ $item->FechaActualizacionEstado }}</td>
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
                            <td colspan="13" class="text-center py-2">No se encontraron resultados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="{{ route('repartir-premios.create', ['total' => $total_acumulado]) }}">Distribuir</a>
            <div>
                <label>Fecha aprobación</label>
                <input type="date" class="border p-1 w-full" name="FechaActualizacionEstado" value="{{ now()->format('Y-m-d') }}">
            </div>
            <input type="submit" value="Guardar">
            @if(session('success'))
                <div class="">
                    {{ session('success') }}
                </div>
            @endif
        </form>
    </div>

    <label for="">
        Total
        <input type="text" name="" id="" value="{{ number_format($total_acumulado, 2, '.', '') }}" disabled>
    </label>
</div> --}}
