<div>

    <x-layout2-sidebar>

        <x-slot name="title">Reportes Peso por tratamientos entre fechas</x-slot>

        <x-slot name="filtros">

            <div class="form-inline mt-3">

                <div class="form-group w-100 mb-3">

                <div class="form-group w-100 mb-3">
                    
                    <label class="form-label text-muted small">
                        Desde - Hasta
                    </label>
                    
                    <div class="input-group d-flex align-items-center" style="height: 26px;">

                        <input 
                            type="date"
                            class="form-control bg-white text-dark py-0"
                            wire:model.live="fecha_inicio"

                            style="max-width: 49%; height: 26px; font-size: 12px;"
                        >

                        <div style="width: 6px;"></div>

                        <input 
                            type="date"
                            class="form-control bg-white text-dark py-0"
                            wire:model.live="fecha_fin"
                            style="max-width: 49%; height: 26px; font-size: 12px;"
                        >

                    </div>
                    
                </div>

                <div class="form-group w-100 mb-3">
                    
                    <label class="form-label text-muted small">
                        CC Desde - Hasta
                    </label>
                    
                    <div class="input-group d-flex align-items-center" style="height: 26px;">

                        <input 
                            type="number"
                            class="form-control bg-white text-dark py-0"
                            wire:model.live="cc_min"
                            style="max-width: 49%; height: 26px; font-size: 12px;"
                        >

                        <div style="width: 6px;"></div>

                        <input 
                            type="number"
                            class="form-control bg-white text-dark py-0"
                            wire:model.live="cc_max"
                            style="max-width: 49%; height: 26px; font-size: 12px;"
                        >

                    </div>

                </div>

                <x-simple-table2-small>

                    <x-slot name="filtros">

                        <div class="row">
                        <div class="col-2">
                            <div class="form-group mb-0">
                                <label for="filtro1" class="font-weight-normal">TRATAMIENTOS</label>
                                <input type="text" id="filtro1" name="filtro1" class="form-control form-control-sm" placeholder="Buscar..." wire:model.live="search">
                            </div>
                        </div>
                        </div>

                    </x-slot>

                    <x-slot name="thead">
                    </x-slot>
                    <x-slot name="tbody">
                    @forelse ($tratamientos as $tratamiento)
                        <tr wire:key="fila-tratamiento-{{ $tratamiento->id }}">
                            <td>
                                <input 
                                    type="checkbox"
                                    wire:key="checkbox-tratamiento-{{ $tratamiento->id }}"
                                    wire:model.live="tratamientos_seleccionados"
                                    value="{{ $tratamiento->id }}">
                            </td>

                            <td>{{ $tratamiento->Nombre }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">No se encontraron resultados.</td>
                        </tr>
                    @endforelse
                    </x-slot>
                </x-simple-table2-small>

                </div>

            </div>

        </x-slot>

        <div class="d-flex align-items-center">

            <button 
                class="btn btn-sidebar btn-sm bg-orange"
                wire:click="exportarExcel">

                <span class="text-white">
                    Exportar Excel
                </span>

                <i class="fas fa-file-excel text-white ml-2"></i>

            </button>

            <div class="ml-auto d-flex align-items-center">

                <label class="mb-0 mr-2 text-muted small">
                    Total acumulado
                </label>

                <input 
                    type="text"
                    class="form-control form-control-sm bg-white text-dark"
                    style="width: 120px; height: 26px; font-size: 12px;"
                    value="{{ number_format($items_orden_trabajo->sum('Peso'), 2, '.', '') }}"
                    disabled
                >

            </div>

        </div>
        
        <br>

    <x-simple-table2>
        <x-slot name="thead">
            <tr>
                <th>Fecha</th>
                <th>Trat.</th>
                <th>Material</th>
                <th>Descripcion</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>CC</th>
                <th>Total Acumulado</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            
            @php $total_acumulado = 0; @endphp
            @forelse ($items_orden_trabajo as $item_orden_trabajo)
                @php $total_acumulado += $item_orden_trabajo->Peso; @endphp
                <tr class="border-t">
                    <td>{{ \Carbon\Carbon::parse($item_orden_trabajo->FechaCreacion)->format('j/n/Y') }}</td>
                    <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->Descripcion }}</td>
                    <td>{{ number_format($item_orden_trabajo->Cantidad, 2, '.', '') }}</td>
                    <td>{{ number_format($item_orden_trabajo->Peso, 2, '.', '') }}</td>
                    <td>{{ $item_orden_trabajo->CodigoComplejidad }}</td>
                    <td>{{ number_format($total_acumulado, 2, '.', '') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="15" class="text-center py-2">No se encontraron resultados.</td>
                </tr>
            @endforelse

        </x-slot>

    </x-simple-table2>

    </x-layout2-sidebar>

    <form id="delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- .modal -->
    <div class="modal fade" id="modal-cliente" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">
                    BUSCAR CLIENTE
                </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <div class="row">

                    <x-simple-table2>

                        <x-slot name="filtros">

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group mb-0">
                                        <label for="filtro1" class="font-weight-normal">NOMBRE</label>
                                        <input type="text" id="filtro1" name="filtro1" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group mb-0">
                                        <label for="filtro2" class="font-weight-normal">NUMERO DE DOCUMENTO</label>
                                        <input type="text" id="filtro2" name="filtro1" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>

                        </x-slot>

                        <x-slot name="thead">
                            <tr>
                                <th>CODIGO</th>
                                <th>NOMBRE</th>
                                <th>TIPO DE DOCUMENTO</th>
                                <th>NUMERO</th>
                                <th>DOMICILIO</th>
                                <th>LOCALIDAD</th>
                                <th>PROVINCIA</th>
                                <th>ACTIVO</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            
                            @forelse ($clientes as $cliente)
                                <tr wire:click.prevent="seleccionarCliente({{ $cliente->id }})"
                                    style="cursor:pointer;"
                                    class="{{ $cliente_id == $cliente->id ? 'table-primary' : '' }}">
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->Nombre }}</td>
                                    <td>{{ $cliente->TipoDocumento }}</td>
                                    <td>{{ $cliente->NroDocumento }}</td>
                                    <td>{{ $cliente->Domicilio }}</td>
                                    <td>{{ $cliente->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                                    <td>{{ $cliente->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                                    <td><input type="checkbox" name="" id="" disabled {{ $cliente->Activo == 1 ? 'checked' : '' }}></td>
                                </tr>
                            @empty
                                <tr><td colspan="8">No se encontraron resultados.</td></tr>
                            @endforelse
                        </x-slot>
                    </x-simple-table2>

                </div>

                </div>

                <div class="modal-footer justify-content-end">

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </button>

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal" wire:click="cancelarCliente">
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- /.modal -->

    <script>
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta programación?')) {
                const form = document.getElementById('delete-form');
                form.action = "{{ route('programacion.destroy', ':id') }}".replace(':id', id);
                form.submit();
            }
        }
    </script>

</div>