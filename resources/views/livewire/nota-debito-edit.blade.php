<div>
    <x-layout2-sidebar>
        <x-slot name="title">Crear Nota de Débito Venta</x-slot>
        <x-slot name="filtros">

            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                    <button type="button" wire:click="addNewItem" class="btn btn-app bg-primary">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>

                <div class="form-group mb-3">
                    <button
                        type="button"
                        class="btn btn-app bg-primary {{ !$item_id ? 'disabled' : '' }}"
                        wire:click="borrarItem"
                        wire:loading.attr="disabled"
                        onclick="return confirm('¿Estás seguro que deseas eliminar este item?')"
                        data-bs-toggle="tooltip"
                        title="Eliminar item"
                    >
                        <i class="fas fa-trash-can"></i> Eliminar
                    </button>
                </div>

            </div>

        </x-slot>

        <form action="{{ route('ventas.ficha-del-cliente-nota-debito.update', $nota_debito)}}" method="POST">
            @csrf
            @method('PUT')
            <x-simple-table2>

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
                                    value="{{old('Numero', $next_nota_credito_numero)}}"
                                    class="form-control form-control-sm py-0" disabled>
                                <input type="hidden" name="Numero" value="{{old('Numero', $next_nota_credito_numero)}}">
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
                                <input type="date" id="FechaEmision" name="FechaEmision"
                                    wire:model.live="fechaEmision"
                                    class="form-control form-control-sm py-0">
                            </div>
                        </div>

                        <div class="col-2">

                            <div class="form-group mb-1">
                                <label for="CondicionVenta" class="form-label mb-1" style="font-size: 0.8rem;">FACTURA</label>
                            </div>
                            <div class="input-group mb-1">

                                <input 
                                    value="{{ $nota_debito->NroFacturaNotaDebito }}"
                                    class="form-control form-control-sm py-0"
                                    disabled
                                >

                            </div>

                        </div>

                    </div>

                    <div class="row mb-2 align-items-end">

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="filtro1" class="form-label mb-1" style="font-size: 0.8rem;">CODIGO CLIENTE</label>
                                <input value="{{ $nota_debito->IdCliente }}" class="form-control form-control-sm py-0" disabled>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="Numero" class="form-label mb-1" style="font-size: 0.8rem;">NOMBRE</label>
                                <input type="text" id="Numero" name="Numero"
                                    value="{{ $nota_debito->RazonSocial }}"
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
                                            class="btn btn-sidebar btn-sm bg-orange">
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

                    {{-- @foreach ($newItems as $id => $newItem)
                        <tr wire:click.prevent="seleccionarItem({{ $id }})"
                            style="cursor:pointer;"
                            class="{{ $item_id == $id ? 'table-primary' : '' }}">

                            <td>
                                <input type="text"
                                    wire:model.live="newItems.{{ $id }}.Descripcion"
                                    name="items[{{ $id }}][Descripcion]">
                            </td>

                            <td>
                                <select wire:model.live="newItems.{{ $id }}.iva_tipo" name="items[{{ $id }}][IvaTipo]">
                                    @foreach ($this->impuestos_iva as $impuesto_iva)
                                        @if ($impuesto_iva->id == 6)
                                            <option value="nogravado">{{ $impuesto_iva->Nombre }}</option>
                                        @elseif ($impuesto_iva->id == 3)
                                            <option value="exento">{{ $impuesto_iva->Nombre }}</option>
                                        @else
                                            <option value="{{ $impuesto_iva->Tasa }}">{{ $impuesto_iva->Nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="number"
                                    wire:model.live="newItems.{{ $id }}.Subtotal"
                                    name="items[{{ $id }}][Neto]">
                            </td>

                        </tr>
                    @endforeach --}}

                    @foreach ($nota_debito->itemsFacturaVenta as $items_nota_debito)
                        <tr>
                            <td>{{ $items_nota_debito->IdArticulo }}</td>
                            <td>{{ $items_nota_debito->Descripcion }}</td>
                            <td>{{ number_format($items_nota_debito->Cantidad, 2, ',', '.') }}</td>
                            <td>{{ number_format($items_nota_debito->PrecioUnitario, 2, ',', '.') }}</td>
                            <td>{{ number_format($items_nota_debito->AlicuotaIVA, 2, ',', '.') }}</td>
                            <td>{{ number_format($items_nota_debito->Neto, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach

                </x-slot>

            </x-simple-table2>

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
                            >{{ $nota_debito->Observaciones }}</textarea>
                        </div>

                        {{-- <div class="mb-3 d-flex align-items-center">
                            <label class="form-label fw-normal small me-2 mb-0 mr-3">ESTADO</label>
                            <input type="text" class="form-control form-control-sm text-dark w-auto" value="PENDIENTE" disabled>
                        </div> --}}


                        <div class="d-flex" style="column-gap: 20px;">
                            <div class="d-flex flex-column">
                                <label class="form-label fw-normal small mb-1">ESTADO</label>
                                <input type="text" class="form-control form-control-sm text-dark" value="{{ $nota_debito->Estado }}" disabled>
                            </div>

                            @if ($nota_debito->Estado == 'COMPLETO')
                                <div class="d-flex flex-column">
                                    <label class="form-label fw-normal small mb-1">&nbsp;</label>
                                    <a href="{{ route('ventas.ficha-del-cliente-factura-venta.destroy-completo', $nota_debito) }}"
                                    class="btn btn-danger btn-sm w-100"
                                    style="height: calc(1.8125rem + 2px); display: flex; align-items: center; justify-content: center;">
                                        ---> PENDIENTE
                                    </a>
                                </div>
                            @elseif ($nota_debito->Estado == 'PENDIENTE')
                                <div class="d-flex flex-column">
                                    <label class="form-label fw-normal small mb-1">&nbsp;</label>
                                    <a href="{{ route('ventas.ficha-del-cliente-factura-venta.destroy-pendiente', $nota_debito) }}"
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
                                <span class="fw-semibold" style="font-size: 1.1rem;">SUBTOTAL</span>

                                <input 
                                    type="text"
                                    readonly
                                    value="{{ number_format($nota_debito->Neto, 2, ',', '.') }}"

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
                                <span class="fw-semibold" style="font-size: 1.1rem;">IVA</span>

                                <input 
                                    type="text"
                                    readonly
                                    value="{{ number_format($nota_debito->IVA, 2, ',', '.') }}"

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
                                    value="{{ number_format($nota_debito->Total, 2, ',', '.') }}"

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

                            <a class="btn btn-app bg-primary" href="{{ route('ventas.ficha-del-cliente-nota-debito.show', $nota_debito) }}">
                                <i class="fas fa-share"></i> Enviar
                            </a>

                            <button class="btn btn-app bg-primary">
                                <i class="fas fa-floppy-disk"></i> Guardar
                            </button>

                            <a class="btn btn-app bg-primary" href="{{ route('ventas.ficha-del-cliente.show', $nota_debito->cliente) }}">
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

    </x-layout2-sidebar>
    
</div>