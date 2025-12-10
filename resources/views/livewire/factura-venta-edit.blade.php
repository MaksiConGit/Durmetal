<div>
    <x-layout2>
        <x-slot name="title">Factura de venta {{ $factura_venta->NumeroCompleto }}</x-slot>

        <form action="{{ route('ventas.ficha-del-cliente-factura-venta.update', $factura_venta)}}" method="POST">
            @csrf
            @method('PUT')

            <x-simple-table2-limited>

                <x-slot name="filtros">

                    <div class="row mb-2 align-items-end">

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="PuntoVenta" class="form-label mb-1" style="font-size: 0.8rem;">PUNTO DE VENTA</label>
                                <select name="PuntoVenta" id="PuntoVenta" class="form-control form-control-sm py-0">
                                    @foreach ($pto_ventas as $pto_venta)
                                        <option value="{{ $pto_venta->id }}" {{$pto_venta->id == session('PuntoVenta') ? 'selected' : ''}}>
                                            {{ $pto_venta->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="Numero" class="form-label mb-1" style="font-size: 0.8rem;">NUMERO</label>
                                <input type="text" id="Numero"
                                    value="{{old('Numero', $next_factura_numero)}}"
                                    class="form-control form-control-sm py-0" disabled>
                                <input type="hidden" name="Numero" value="{{old('Numero', $next_factura_numero)}}">
                            </div>
                        </div>

                        <div class="col-2 d-flex flex-column justify-content-end">
                            <div class="bg-info text-white d-flex justify-content-center align-items-center mx-auto" 
                                style="width: 3rem; height: 3rem; font-weight: bold;">
                                A
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="FechaEmision" class="form-label mb-1" style="font-size: 0.8rem;">FECHA DE EMISION</label>
                                <input type="date" id="FechaEmision" name="FechaEmision" disabled
                                    wire:model.live="fechaEmision"
                                    class="form-control form-control-sm py-0">
                            </div>
                        </div>

                        <div class="col-2">

                            <div class="form-group mb-1">
                                <label for="FechaVencimiento" class="form-label mb-1" style="font-size: 0.8rem;">FECHA DE VENCIMIENTO</label>
                            </div>
                            <div class="input-group mb-1">
                                <input type="date" id="FechaVencimiento" name="FechaVencimiento" disabled
                                    wire:model.live="fechaVencimiento"
                                    class="form-control form-control-sm py-0">
                                <div class="input-group-append">
                                    <button type="button" 
                                            class="btn btn-sidebar btn-sm bg-orange">
                                        <i class="fas fa-pencil fa-fw text-white"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row mb-2 align-items-end">

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="filtro1" class="form-label mb-1" style="font-size: 0.8rem;">CODIGO CLIENTE</label>
                                <input value="{{ $cliente->id }}" class="form-control form-control-sm py-0" disabled>
                                <input type="hidden" name="IdCliente" value="{{ $cliente->id }}">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="Numero" class="form-label mb-1" style="font-size: 0.8rem;">NOMBRE</label>
                                <input type="text" id="Numero" name="Numero"
                                    value="{{ $cliente->Nombre }}"
                                    class="form-control form-control-sm py-0" disabled>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-2 align-items-end">
                        <div class="col-10">

                            <div class="form-group mb-1">
                                <label for="CondicionVenta" class="form-label mb-1" style="font-size: 0.8rem;">CONDICION DE VENTA</label>
                            </div>
                            <div class="input-group mb-1">

                            <input 
                                value="{{ implode(' / ', $condicionesSeleccionadas ?? []) }}"
                                class="form-control form-control-sm py-0"
                                disabled
                            >

                            <input 
                                type="hidden"
                                name="CondicionVenta"
                                value="{{ implode(' / ', $condicionesSeleccionadas ?? []) }}"
                            >
                                
                                <div class="input-group-append">
                                    <button type="button"
                                            data-toggle="modal"
                                            data-target="#modal-condicion"
                                            class="btn btn-sidebar btn-sm bg-orange"
                                            wire:click="setFechaVencimiento">
                                        <i class="fas fa-pencil fa-fw text-white"></i>
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>
                        
                    </div>

                </x-slot>


                <x-slot name="thead">
                    <tr>
                        <th>CODIGO</th>
                        <th>DESCRIPCION</th>
                        <th>CANTIDAD</th>
                        <th>PRECIO UNITARIO</th>
                        <th>% IVA</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($notas_envio as $index => $nota_envio)
                        @php $id = $nota_envio->id; @endphp

                        <tr>
                            <td>{{ $nota_envio->IdArticulo ?? '¡¡REVISAR!!' }}</td>
                            <td style="min-width: 300px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $nota_envio->Descripcion }}
                            </td>
                            <td>{{ number_format($nota_envio->Cantidad, 2, ',', '.') }}</td>
                            <td>{{ number_format($nota_envio->PrecioUnitario, 2, ',', '.') }}</td>
                            <td>{{ number_format($nota_envio->AlicuotaIVA, 2, ',', '.') }}</td>
                            <td>{{ number_format($nota_envio->Neto, 2, ',', '.') }}</td>
                        </tr>

                        @if (!empty($seleccionados[$id]) && $seleccionados[$id])
                            <input type="hidden" name="items[{{ $id }}][IdNotaEnvio]" value="{{ $id }}">
                            <input type="hidden" name="items[{{ $id }}][Descripcion]" value="{{ $descripcion[$id] ?? '' }}">
                            <input type="hidden" name="items[{{ $id }}][Neto]" value="{{ $total[$id] ?? 0 }}">
                            <input type="hidden" name="items[{{ $id }}][IVA]" value="{{ $IVA[$id] ?? 0 }}">
                        @endif
                    @endforeach

                    @php
                        $cantidadItems = count($notas_envio);
                        $filasFaltantes = max(0, 3 - $cantidadItems);
                    @endphp

                    @for ($i = 0; $i < $filasFaltantes; $i++)
                        <tr>
                            @for ($j = 0; $j < 6; $j++)
                                <td>&nbsp;</td>
                            @endfor
                        </tr>
                    @endfor

                </x-slot>

            </x-simple-table2-limited>

            <div class="container-fluid px-4 py-3">

                <div class="row">

                    <div class="col-md-8">

                        <div class="mb-5 w-100">
                            <label class="form-label fw-normal text-muted" style="font-size: 0.8rem;">OBSERVACIONES</label>
                            <textarea 
                                class="form-control form-control-sm border border-primary-subtle" 
                                rows="5" 
                                name="Observaciones"
                                style="font-size: 0.8rem; line-height: 1.2; width: 100%; min-height: 110px;"
                            >{{ $factura_venta->Observaciones }}</textarea>
                        </div>

                        <div class="d-flex" style="column-gap: 20px;">
                            <div class="d-flex flex-column">
                                <label class="form-label fw-normal small mb-1">ESTADO</label>
                                <input type="text" class="form-control form-control-sm text-dark" value="{{ $factura_venta->Estado }}" disabled>
                            </div>

                            <div class="d-flex flex-column">
                                <label class="form-label fw-normal small mb-1">CAE</label>
                                <input type="text" class="form-control form-control-sm text-dark" value="{{ $factura_venta->CAE }}" disabled>
                            </div>

                            @if ($factura_venta->Estado == 'COMPLETO')
                                <div class="d-flex flex-column">
                                    <label class="form-label fw-normal small mb-1">&nbsp;</label>
                                    <a href="{{ route('ventas.ficha-del-cliente-factura-venta.destroy-completo', $factura_venta) }}"
                                    class="btn btn-danger btn-sm w-100"
                                    style="height: calc(1.8125rem + 2px); display: flex; align-items: center; justify-content: center;">
                                        ---> PENDIENTE
                                    </a>
                                </div>
                            @elseif ($factura_venta->Estado == 'PENDIENTE')
                                <div class="d-flex flex-column">
                                    <label class="form-label fw-normal small mb-1">&nbsp;</label>
                                    <a href="{{ route('ventas.ficha-del-cliente-factura-venta.destroy-pendiente', $factura_venta) }}"
                                    class="btn btn-danger btn-sm w-100"
                                    style="height: calc(1.8125rem + 2px); display: flex; align-items: center; justify-content: center;">
                                        ---> COMPLETO
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                    </div>

                    <div class="col-md-4">

                        <div class="d-flex flex-column align-items-end fs-6">

                            <div class="w-100 mb-1 d-flex justify-content-between">
                                <span class="fw-semibold" style="font-size: 1.3rem;">SUBTOTAL</span>

                                <input 
                                    type="text"
                                    readonly
                                    value="{{ number_format($factura_venta->Neto, 2, ',', '.') }}"

                                    style="
                                        width: 160px;
                                        text-align: right;
                                        border: none;
                                        border-bottom: 1px solid black;
                                        background: transparent;
                                        padding: 2px 0;
                                        outline: none;
                                        font-size: 0.9rem;
                                        color: #6c757d;
                                    "
                                />
                            </div>

                            <div class="w-100 mb-2 d-flex justify-content-between">
                                <span class="fw-semibold" style="font-size: 1.3rem;">IVA (21%)</span>

                                <input 
                                    type="text"
                                    readonly
                                    value="{{ number_format($factura_venta->IVA, 2, ',', '.') }}"

                                    style="
                                        width: 160px;
                                        text-align: right;
                                        border: none;
                                        border-bottom: 1px solid black;
                                        background: transparent;
                                        padding: 2px 0;
                                        outline: none;
                                        font-size: 0.9rem;
                                        color: #6c757d;
                                    "
                                />
                            </div>

                            <div class="w-100 mb-2 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark" style="font-size: 1.3rem;">TOTAL</span>

                                <input 
                                    type="text"
                                    disabled
                                    value="{{ number_format($factura_venta->Total, 2, ',', '.') }}"

                                    class="form-control form-control-sm"
                                    style="
                                        width: 160px;
                                        font-size: 1rem;
                                        color: #000;
                                        text-align: right;      /* <-- Centrado a la derecha */
                                        background-color: #e9ecef;
                                    "
                                />

                            </div>

                        </div>

                        <div class="d-flex justify-content-end mt-3">

                            <a class="btn btn-app bg-primary" href="{{ route('ventas.ficha-del-cliente-factura-venta.show', $factura_venta) }}">
                                <i class="fas fa-share"></i> Enviar
                            </a>

                            <button class="btn btn-app bg-primary">
                                <i class="fas fa-floppy-disk"></i> Guardar
                            </button>

                            <a class="btn btn-app bg-primary" href="{{ route('ventas.ficha-del-cliente.show', $cliente) }}">
                                <i class="fas fa-ban"></i> Cancelar
                            </a>

                        </div>

                    </div>
            
                </div>
        
            </div>

            <!-- .modal -->
            <div class="modal fade" id="modal-condicion" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-bold">
                            EDITAR CONDICION VENTA
                        </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        <div class="row">

                            <x-simple-table2>

                                <x-slot name="thead">
                                    <tr>
                                        <th></th>
                                        <th>NOMBRE</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @forelse ($condiciones_venta as $condicion_venta)
                                        <tr>
                                            <td>
                                                <input 
                                                    type="checkbox"
                                                    wire:model.live="condicionesSeleccionadas"
                                                    value="{{ $condicion_venta->Nombre }}"
                                                    @if($condicion_venta->Seleccionado == 1) checked @endif
                                                >
                                            </td>
                                            <td>{{ $condicion_venta->Nombre }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8">No se encontraron resultados.</td></tr>
                                    @endforelse

                                </x-slot>
                            </x-simple-table2>
                            </div>
                            </div>

                        </div>

                        </div>

                        <div class="modal-footer justify-content-end">

                            <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                <span class="text-white">Cerrar</span>
                                <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                            </button>

                        </div>
                        </div>
                        </div>

            </div>
            <!-- /.modal -->
    
        </form>

    </x-layout2>
    
</div>