<div>
    <x-layout2>
        <x-slot name="title">Editar Nota de Envío {{ $nota_envio->NumeroCompleto }}</x-slot>

        <form action="{{ route('ventas.ficha-del-cliente-nota-envio.update', $nota_envio)}}" method="POST">
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
                                    value="{{old('Numero', $nota_envio->Numero)}}"
                                    class="form-control form-control-sm py-0" disabled>
                                <input type="hidden" name="Numero" value="{{old('Numero', $nota_envio->Numero)}}">
                            </div>
                        </div>

                        <div class="col-2 d-flex flex-column justify-content-end">
                            <div class="bg-info text-white d-flex justify-content-center align-items-center mx-auto" 
                                style="width: 3rem; height: 3rem; font-weight: bold;">
                                NE
                            </div>
                        </div>


                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="FechaEmision" class="form-label mb-1" style="font-size: 0.8rem;">FECHA DE EMISION</label>
                                <input type="date"
                                    value="{{old('FechaEmision', $nota_envio->FechaEmision)}}"
                                    class="form-control form-control-sm py-0"
                                    disabled>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-2 align-items-end">

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="filtro1" class="form-label mb-1" style="font-size: 0.8rem;">CODIGO CLIENTE</label>
                                <input value="{{ $nota_envio->IdCliente }}" class="form-control form-control-sm py-0" disabled>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="Numero" class="form-label mb-1" style="font-size: 0.8rem;">NOMBRE</label>
                                <input type="text" id="Numero" name="Numero"
                                    value="{{ $nota_envio->RazonSocial }}"
                                    class="form-control form-control-sm py-0" disabled>
                            </div>
                        </div>
                        
                    </div>
                    </div>

                </x-slot>


                <x-slot name="thead">
                    @if ($nota_envio->Estado == 'PENDIENTE')
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
                    @endif

                    <tr>
                        @if ($nota_envio->Estado == 'PENDIENTE')
                            <th></th>
                            <th>N°</th>
                            <th>CC</th>
                            <th>% DESC.</th>
                            <th>FECHA</th>
                            <th>OTI</th>
                            <th></th>
                            <th>MATERIAL</th>
                            <th>DESCRIPCION</th>
                            <th>ESTADO</th>
                            <th>CANT.</th>
                            <th>PESO</th>
                            <th>TRAT.</th>
                            <th>PRECIO U.</th>
                            <th></th>
                            <th>TOTAL</th>
                        @else
                            <th>N°</th>
                            <th>OTI</th>
                            <th>DESCRIPCION</th>
                            <th>CANT.</th>
                            <th>PESO</th>
                            <th>CC</th>
                            <th>COEFIC.</th>
                            <th>PRECIO U.</th>
                            <th>% DESC</th>
                            <th>TOTAL</th>
                        @endif

                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @if ($nota_envio->Estado == 'PENDIENTE')
                        @foreach ($items_nota_envio as $item_nota)
                            @php
                                $item = $item_nota->itemOrdenTrabajo;
                                $id = $item_nota->id;
                                $key = 'nota_' . $id;
                            @endphp

                            <tr class="table-warning">
                                <td>
                                    <input
                                        type="checkbox"
                                        wire:model.live="seleccionados.{{ $key }}"
                                    >
                                </td>

                                <td></td>

                                <td class="text-center align-middle">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm p-1 text-center mx-auto
                                            {{ $codigo_invalido[$key] ?? false ? 'text-danger border-danger' : '' }}"
                                        style="width: 30px;"
                                        wire:model.live="codigo_complejidad.{{ $key }}"
                                        wire:input="onCodigoComplejidadChange('{{ $key }}', $event.target.value)"
                                    />
                                </td>

                                <td>
                                    <input
                                        class="form-control form-control-sm p-1 text-center mx-auto"
                                        style="width: 40px;"
                                        wire:model.live="descuento.{{ $key }}"
                                    />
                                </td>

                                <td>{{ \Carbon\Carbon::parse($item->ordenTrabajo->FechaEmision)->format('d/m/Y') }}</td>
                                <td>{{ $item->ordenTrabajo->NumeroCompleto }} {{ $item->ItemNumero }}</td>

                                <td class="text-center align-middle">
                                    <button
                                        class="btn btn-sm toggle-row"
                                        type="button"
                                        style="background-color: #fd7e14; color: white;"
                                        data-toggle="modal"
                                        data-target="#modal-ne-{{ $item_nota->id }}"
                                    >
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </td>

                                <td>{{ $item->material->Nombre }}</td>

                                <td style="min-width: 300px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $descripcion[$key] ?? $item_nota->Descripcion }}
                                </td>

                                <td>{{ $item->Estado }}</td>
                                <td>{{ $item_nota->Cantidad }}</td>
                                <td>{{ $item_nota->Peso }}</td>
                                <td>{{ $item->tratamiento->Nombre }}</td>

                                <td class="text-center align-middle">
                                    <input
                                        step="0.01"
                                        class="form-control form-control-sm p-1 text-center mx-auto"
                                        style="width: 70px;"
                                        wire:model.live="precio_unitario.{{ $key }}"
                                        wire:input="onPrecioChange('{{ $key }}', $event.target.value)"
                                    />
                                </td>

                                <td class="text-center align-middle">
                                    <button
                                        class="btn btn-sm toggle-row"
                                        type="button"
                                        style="background-color: #fd7e14; color: white;"
                                        data-toggle="modal"
                                        data-target="#modal-cliente-ne-{{ $item_nota->id }}"
                                    >
                                        <i class="fa-solid fa-list"></i>
                                    </button>
                                </td>

                                <td class="text-center align-middle">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm p-1 text-center mx-auto bg-light"
                                        style="width: 90px;"
                                        value="{{ number_format($total[$key] ?? 0, 2) }}"
                                        readonly
                                    />
                                </td>
                            </tr>

                            @if (!empty($seleccionados[$key]))
                                <input type="hidden" name="items[{{ $id }}][IdItemNotaEnvio]" value="{{ $item_nota->id }}">
                                <input type="hidden" name="items[{{ $id }}][IdItemOrdenTrabajo]" value="{{ $id }}">
                                <input type="hidden" name="items[{{ $id }}][Descripcion]" value="{{ $descripcion[$key] ?? $item_nota->Descripcion }}">
                                <input type="hidden" name="items[{{ $id }}][CodigoComplejidad]" value="{{ $codigo_complejidad[$key] ?? '' }}">
                                <input type="hidden" name="items[{{ $id }}][Coeficiente]" value="{{ $coeficiente[$key] ?? 1 }}">
                                <input type="hidden" name="items[{{ $id }}][PorcentajeDescuento]" value="{{ $descuento[$key] ?? 0 }}">
                                <input type="hidden" name="items[{{ $id }}][PrecioUnitario]" value="{{ $precio_unitario[$key] ?? 0 }}">
                                <input type="hidden" name="items[{{ $id }}][Total]" value="{{ $total[$key] ?? 0 }}">
                            @endif
                        @endforeach

                        @foreach ($items_orden_trabajo as $item)
                            @php
                                $id = $item->id;
                                $key = 'ot_' . $id;
                            @endphp

                            <tr>
                                <td>
                                    <input
                                        type="checkbox"
                                        wire:model.live="seleccionados.{{ $key }}"
                                    >
                                </td>

                                <td></td>

                                <td class="text-center align-middle">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm p-1 text-center mx-auto
                                            {{ $codigo_invalido[$key] ?? false ? 'text-danger border-danger' : '' }}"
                                        style="width: 30px;"
                                        wire:model.live="codigo_complejidad.{{ $key }}"
                                        wire:input="onCodigoComplejidadChange('{{ $key }}', $event.target.value)"
                                    />
                                </td>

                                <td>
                                    <input
                                        class="form-control form-control-sm p-1 text-center mx-auto"
                                        style="width: 40px;"
                                        wire:model.live="descuento.{{ $key }}"
                                    />
                                </td>

                                <td>{{ \Carbon\Carbon::parse($item->ordenTrabajo->FechaEmision)->format('d/m/Y') }}</td>
                                <td>{{ $item->ordenTrabajo->NumeroCompleto }} {{ $item->ItemNumero }}</td>

                                <td class="text-center align-middle">
                                    <button
                                        class="btn btn-sm toggle-row"
                                        type="button"
                                        style="background-color: #fd7e14; color: white;"
                                        data-toggle="modal"
                                        data-target="#modal-ot-{{ $item->id }}"
                                    >
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </td>

                                <td>{{ $item->material->Nombre }}</td>

                                <td style="min-width: 300px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $descripcion[$key] ?? $item->Descripcion }}
                                </td>

                                <td>{{ $item->Estado }}</td>
                                <td>{{ $item->Cantidad }}</td>
                                <td>{{ $item->Peso }}</td>
                                <td>{{ $item->tratamiento->Nombre }}</td>

                                <td class="text-center align-middle">
                                    <input
                                        step="0.01"
                                        class="form-control form-control-sm p-1 text-center mx-auto"
                                        style="width: 70px;"
                                        wire:model.live="precio_unitario.{{ $key }}"
                                        wire:input="onPrecioChange('{{ $key }}', $event.target.value)"
                                    />
                                </td>

                                <td class="text-center align-middle">
                                    <button
                                        class="btn btn-sm toggle-row"
                                        type="button"
                                        style="background-color: #fd7e14; color: white;"
                                        data-toggle="modal"
                                        data-target="#modal-cliente-{{ $item->id }}"
                                    >
                                        <i class="fa-solid fa-list"></i>
                                    </button>
                                </td>

                                <td class="text-center align-middle">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm p-1 text-center mx-auto bg-light"
                                        style="width: 90px;"
                                        value="{{ number_format($total[$key] ?? 0, 2) }}"
                                        readonly
                                    />
                                </td>
                            </tr>

                            @if (!empty($seleccionados[$key]))
                                <input type="hidden" name="items[{{ $id }}][IdItemOrdenTrabajo]" value="{{ $id }}">
                                <input type="hidden" name="items[{{ $id }}][Descripcion]" value="{{ $descripcion[$key] ?? $item->Descripcion }}">
                                <input type="hidden" name="items[{{ $id }}][CodigoComplejidad]" value="{{ $codigo_complejidad[$key] ?? '' }}">
                                <input type="hidden" name="items[{{ $id }}][Coeficiente]" value="{{ $coeficiente[$key] ?? 1 }}">
                                <input type="hidden" name="items[{{ $id }}][PorcentajeDescuento]" value="{{ $descuento[$key] ?? 0 }}">
                                <input type="hidden" name="items[{{ $id }}][PrecioUnitario]" value="{{ $precio_unitario[$key] ?? 0 }}">
                                <input type="hidden" name="items[{{ $id }}][Total]" value="{{ $total[$key] ?? 0 }}">
                            @endif
                        @endforeach

                        @php
                            $totalFilas = count($items_nota_envio) + count($items_orden_trabajo);
                            $filasFaltantes = max(0, 3 - $totalFilas);
                        @endphp
                        @for ($i = 0; $i < $filasFaltantes; $i++)
                            <tr>
                                @for ($j = 0; $j < 16; $j++)
                                    <td>&nbsp;</td>
                                @endfor
                            </tr>
                        @endfor

                    @else
                        @foreach ($items_nota_envio as $item_nota)
                            @php
                                $item = $item_nota->itemOrdenTrabajo;
                                $id = $item_nota->id;
                                $key = 'nota_' . $id;
                            @endphp

                            <tr>
                                <td>{{ $item_nota->ItemNumero }}</td>
                                <td>{{ $item->ordenTrabajo->NumeroCompleto }} {{ $item->ItemNumero }}</td>
                                <td>{{ $item_nota->Descripcion }}</td>
                                <td>{{ number_format($item_nota->Cantidad, 2, '.', '') }}</td>
                                <td>{{ number_format($item_nota->Peso, 2, '.', '') }}</td>
                                <td>{{ $item_nota->CodigoComplejidad }}</td>
                                <td>{{ $item_nota->Coeficiente }}</td>
                                <td>{{ number_format($item_nota->PrecioUnitario, 2, '.', '') }}</td>
                                <td>{{ number_format($item_nota->PorcentajeDescuento, 2, '.', '') }}</td>
                                <td>{{ number_format($item_nota->Total, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        @php
                            $cantidadItems = count($items_nota_envio);
                            $filasFaltantes = max(0, 3 - $cantidadItems);
                        @endphp

                        @for ($i = 0; $i < $filasFaltantes; $i++)
                            <tr>
                                @for ($j = 0; $j < 16; $j++)
                                    <td>&nbsp;</td>
                                @endfor
                            </tr>
                        @endfor
                    @endif

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
                            >{{ $nota_envio->Observaciones }}</textarea>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label class="form-label fw-normal small me-2 mb-0 mr-3">ESTADO</label>

                            <input type="text" class="form-control form-control-sm text-dark w-auto"
                                value="{{ $nota_envio->Estado }}" disabled>

                            @if ($nota_envio->Estado != 'COMPLETO')
                                <span class="mx-2"></span>
                                <a data-toggle="modal" data-target="#nota-envio" class="btn btn-danger btn-sm">
                                    ANULAR
                                </a>
                            @endif
                        </div>


                        <div class="modal fade" id="nota-envio" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-white">
                                        <h4 class="modal-title">Nota de Envío {{ $nota_envio->NumeroCompleto }}</h4>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Confirme que desea anular el documento</p>
                                        <p>Esta acción no se puede deshacer</p>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <a href="{{ route('ventas.ficha-del-cliente-nota-envio.destroy', $nota_envio) }}" class="btn btn-danger">Sí, anular</a>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="d-flex flex-column align-items-end fs-6">

                            <div class="w-100 mb-1 d-flex justify-content-between">
                                <span class="fw-semibold" style="font-size: 0.9rem;">SUBTOTAL</span>

                                <input 
                                    type="text"
                                    readonly
                                    value="{{ number_format($subtotal, 2, ',', '.') }}"

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


                            <div class="w-100 mb-1 d-flex justify-content-between align-items-center">
                                <span class="fw-semibold" style="font-size: 1rem;">% DESCUENTO</span>

                                <input 
                                    name="PorcentajeDescuento"
                                    wire:model.live="porcentaje_descuento"
                                    wire:input="onPorcentajeDescuentoChange($event.target.value)"

                                    style="
                                        width: 160px;
                                        text-align: right;
                                        border: none;
                                        border-bottom: 1px solid black;
                                        background: transparent;
                                        padding: 2px 0;
                                        outline: none;
                                        font-size: 1rem;
                                    "
                                />
                            </div>


                            <div class="w-100 mb-1 d-flex justify-content-between">
                                <span class="fw-semibold" style="font-size: 1rem;">BASE IMPONIBLE</span>

                                <input 
                                    type="text"
                                    readonly
                                    value="{{ number_format($base_imponible, 2, ',', '.') }}"

                                    style="
                                        width: 160px;
                                        text-align: right;
                                        border: none;
                                        border-bottom: 1px solid black;
                                        background: transparent;
                                        padding: 2px 0;
                                        outline: none;
                                        font-size: 1rem;
                                        color: #6c757d;
                                    "
                                />

                                <input type="hidden" name="Neto" value="{{ $base_imponible }}">
                            </div>


                            <div class="w-100 mb-2 d-flex justify-content-between">
                                <span class="fw-semibold" style="font-size: 1rem;">IVA (21%)</span>

                                <input 
                                    type="text"
                                    readonly
                                    value="{{ number_format($iva, 2, ',', '.') }}"

                                    style="
                                        width: 160px;
                                        text-align: right;
                                        border: none;
                                        border-bottom: 1px solid black;
                                        background: transparent;
                                        padding: 2px 0;
                                        outline: none;
                                        font-size: 1rem;
                                        color: #6c757d;
                                    "
                                />

                                <input type="hidden" name="IVA" value="{{ $iva }}">
                            </div>


                            <div class="w-100 mb-2 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark" style="font-size: 1.30rem;">TOTAL</span>

                                <input 
                                    type="text"
                                    disabled
                                    value="{{ number_format($total_final, 2, ',', '.') }}"

                                    class="form-control form-control-sm"
                                    style="
                                        width: 160px;
                                        font-size: 1rem;
                                        color: #000;
                                        text-align: right;      /* <-- Centrado a la derecha */
                                        background-color: #e9ecef;
                                    "
                                />

                                <input type="hidden" name="Total" value="{{ $total_final }}">
                            </div>

                        </div>

                        <div class="d-flex justify-content-end mt-3">

                            <a class="btn btn-app bg-primary" href="{{ route('ventas.ficha-del-cliente-nota-envio.show', $nota_envio) }}">
                                <i class="fas fa-share"></i> Enviar
                            </a>

                            <button class="btn btn-app bg-primary">
                                <i class="fas fa-floppy-disk"></i> Guardar
                            </button>

                            <a class="btn btn-app bg-primary" href="{{ route('ventas.ficha-del-cliente.show', $nota_envio->cliente) }}">
                                <i class="fas fa-ban"></i> Cancelar
                            </a>

                        </div>

                    </div>
            
                </div>
        
            </div>

        </form>

        @foreach ($items_orden_trabajo as $item_orden_trabajo)

            <!-- .modal -->
            <div class="modal fade" id="modal-ot-{{ $item_orden_trabajo->id }}" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-bold">
                            TRABAJO OT {{ $item_orden_trabajo->ordenTrabajo->NumeroCompleto }}
                        </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        <div class="row">

                            <form action="{{ route('ventas.ficha-del-cliente-nota-envio.orden-trabajo', $item_orden_trabajo) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <x-panel-horizontal2>
                                <x-slot name="pestañas">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'custom-tabs-1' ? 'active' : '' }}"
                                        wire:click.prevent="setActiveTab('custom-tabs-1')"
                                        id="custom-tabs-1-tab" data-toggle="pill"
                                        href="#custom-tabs-1" role="tab"
                                        aria-controls="custom-tabs-1" aria-selected="true"
                                        style="padding: 3px 8px; font-size: 0.75rem;">
                                        ITEM
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'custom-tabs-2' ? 'active' : '' }}"
                                        wire:click.prevent="setActiveTab('custom-tabs-2')"
                                        id="custom-tabs-2-tab" data-toggle="pill"
                                        href="#custom-tabs-2" role="tab"
                                        aria-controls="custom-tabs-2" aria-selected="true"
                                        style="padding: 3px 8px; font-size: 0.75rem;">
                                        OBSERVACIONES
                                        </a>
                                    </li>
                                </x-slot>

                                <x-slot name="ventanas">
                                    <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-1' ? 'active' : '' }}"
                                        id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab"
                                        style="height: 18rem; padding: 0.5rem;">
                                        <div class="row justify-content-center m-0">
                                            <div class="col-10 card p-1">
                                                <div class="card-body p-2">
                                                    <div class="row justify-content-center m-0">
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">ITEM NRO</label>
                                                            <input type="hidden" name="items[{{ $item_orden_trabajo->id }}][ItemNumero]" value="{{ old('ItemNumero', $item_orden_trabajo->ItemNumero) }}">
                                                            <input type="text" value="{{ old('ItemNumero', $item_orden_trabajo->ItemNumero) }}" disabled class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DESCRIPCIÓN</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][Descripcion]" value="{{ old('items[$item_orden_trabajo->id][Descripcion]', $item_orden_trabajo->Descripcion) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">NRO PLANO PREDETERMINADO</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][NroPlano]" value="{{ old('items[$item_orden_trabajo->id][NroPlano]', $item_orden_trabajo->certificado->NroPlano ?? '') }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                    </div>

                                                    <div class="row justify-content-center m-0">
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">CANTIDAD</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][Cantidad]" value="{{ old('items[$item_orden_trabajo->id][Cantidad]', $item_orden_trabajo->Cantidad) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">PESO</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][Peso]" value="{{ old('items[$item_orden_trabajo->id][Peso]', $item_orden_trabajo->Peso) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">TRATAMIENTO</label>
                                                            <div class="input-group input-group-sm">
                                                                <select 
                                                                    class="form-control form-control-sm p-1" 
                                                                    name="items[{{ $item_orden_trabajo->id }}][IdTratamiento]" 
                                                                    style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;"
                                                                >
                                                                    @foreach ($tratamientos as $tratamiento)
                                                                        <option 
                                                                            value="{{ $tratamiento->id }}" 
                                                                            {{ $item_orden_trabajo->IdTratamiento == $tratamiento->id ? 'selected' : '' }}
                                                                            style="font-size: 0.7rem; white-space: nowrap;"
                                                                        >
                                                                            {{ $tratamiento->Nombre }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button 
                                                                        type="button"
                                                                        disabled
                                                                        class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                        data-toggle="modal" 
                                                                        data-target="#modal-items-{{ $item_orden_trabajo->id }}-tratamiento"
                                                                        style="height: 22px;"
                                                                    >
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row m-0">
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">DUREZA</label>
                                                            <div class="input-group input-group-sm">
                                                                <select
                                                                    class="form-control form-control-sm p-1"
                                                                    name="items[{{ $item_orden_trabajo->id }}][IdDureza]"
                                                                    style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;">
                                                                    @foreach ($durezas as $dureza)
                                                                        <option value="{{ $dureza->id }}"
                                                                            {{ $item_orden_trabajo->IdDureza == $dureza->id ? 'selected' : '' }}
                                                                            style="font-size: 0.7rem; white-space: nowrap;">
                                                                            {{ $dureza->Nombre }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button type="button"
                                                                            disabled
                                                                            class="btn btn-sidebar btn-xs bg-orange p-1"
                                                                            data-toggle="modal"
                                                                            data-target="#modal-items-{{ $item_orden_trabajo->id }}-dureza">
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DSMIN</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][DurezaSolicitadaMinima]" value="{{ old('items[$item_orden_trabajo->id][DurezaSolicitadaMinima]', $item_orden_trabajo->DurezaSolicitadaMinima) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>

                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DSMAX</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][DurezaSolicitadaMaxima]" value="{{ old('items[$item_orden_trabajo->id][DurezaSolicitadaMaxima]', $item_orden_trabajo->DurezaSolicitadaMaxima) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>

                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">MATERIAL</label>
                                                            <div class="input-group input-group-sm">
                                                                <select 
                                                                    class="form-control form-control-sm p-1" 
                                                                    name="items[{{ $item_orden_trabajo->id }}][IdMaterial]" 
                                                                    style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;"
                                                                >
                                                                    @foreach ($materiales as $material)
                                                                        <option 
                                                                            value="{{ $material->id }}" 
                                                                            style="font-size: 0.7rem; white-space: nowrap;"
                                                                            {{ $item_orden_trabajo->IdMaterial == $material->id ? 'selected' : '' }}
                                                                        >
                                                                            {{ $material->Nombre }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button 
                                                                        type="button"
                                                                        disabled
                                                                        class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                        data-toggle="modal" 
                                                                        data-target="#modal-items-{{ $item_orden_trabajo->id }}-material"
                                                                        style="height: 22px;"
                                                                    >
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    

                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">CC</label>
                                                            <div class="input-group input-group-sm">
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][CodigoComplejidad]" value="{{ old('items[$item_orden_trabajo->id][CodigoComplejidad]', $item_orden_trabajo->CodigoComplejidad) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                <div class="input-group-append">
                                                                    <button 
                                                                        type="button" 
                                                                        disabled
                                                                        class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                        data-toggle="modal" 
                                                                        data-target="#modal-items-{{ $item_orden_trabajo->id }}-tratamiento"
                                                                        style="height: 22px;"
                                                                    >
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">ESTADO</label>
                                                            <div class="input-group input-group-sm">
                                                                <select 
                                                                    class="form-control form-control-sm p-1" 
                                                                    name="items[{{ $item_orden_trabajo->id }}][Estado]" 
                                                                    style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;"
                                                                >
                                                                    <option 
                                                                        value="PENDIENTE" 
                                                                        {{ $item_orden_trabajo->Estado == 'PENDIENTE' ? 'selected' : '' }}
                                                                        style="font-size: 0.7rem; white-space: nowrap;"
                                                                    >
                                                                    PENDIENTE
                                                                    </option>
                                                                    <option 
                                                                        value="APROBADO" 
                                                                        {{ $item_orden_trabajo->Estado == 'APROBADO' ? 'selected' : '' }}
                                                                        style="font-size: 0.7rem; white-space: nowrap;"
                                                                    >
                                                                    APROBADO
                                                                    </option>
                                                                    <option 
                                                                        value="NO APTO" 
                                                                        {{ $item_orden_trabajo->Estado == 'NO APTO' ? 'selected' : '' }}
                                                                        style="font-size: 0.7rem; white-space: nowrap;"
                                                                    >
                                                                    NO APTO
                                                                    </option>
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button 
                                                                        type="button"
                                                                        disabled
                                                                        class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                        data-toggle="modal" 
                                                                        data-target="#modal-items-{{ $item_orden_trabajo->id }}-tratamiento"
                                                                        style="height: 22px;"
                                                                    >
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="d-flex justify-content-end mt-2">
                                                        <button class="btn btn-sidebar btn-xs bg-orange px-2 py-1">
                                                            <span class="text-white">Aceptar</span>
                                                            <i class="fas fa-check fa-xs text-white ml-1"></i>
                                                        </button>
                                                        <button class="btn btn-sidebar btn-xs bg-orange px-2 py-1 ml-2" data-dismiss="modal" >
                                                            <span class="text-white">Cancelar</span>
                                                            <i class="fas fa-xmark fa-xs text-white ml-1"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-2' ? 'active' : '' }}"
                                        id="custom-tabs-2" role="tabpanel"
                                        aria-labelledby="custom-tabs-2-tab"
                                        style="height: 18rem; padding: 0.5rem;">
                                        <textarea class="form-control w-100 p-1"
                                                rows="10"
                                                placeholder="Escriba aquí..."
                                                style="resize: none; font-size: 0.8rem;"
                                                name="items[{{ $item_orden_trabajo->id }}][Observaciones]">{{ old('items[$item_orden_trabajo->id][Observaciones]', $item_orden_trabajo->Observaciones) }}</textarea>
                                    </div>
                                </x-slot>
                            </x-panel-horizontal2>
                            </form>

                        
                            </div>

                        </div>

                        </div>

                        </div>
                        </div>

            <!-- /.modal -->

            <!-- .modal -->
            <div class="modal fade" id="modal-cliente-{{ $item_orden_trabajo->id }}" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-bold">
                            TRATAMIENTO: "{{ $item_orden_trabajo->tratamiento->Nombre }}"
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
                                        <th>CC</th>
                                        <th>DESCRIPCION</th>
                                        <th>PRECIO</th>
                                        <th>DIVISA</th>
                                        <th style="max-width: 80px;">% COEF.</th>
                                        <th>COEFICIENTE</th>
                                        <th></th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @forelse ($item_orden_trabajo->tratamiento->precios->sortBy('CC') as $precio)
                                        <tr>
                                            <td>{{ $precio->CC }}</td>
                                            <td style="min-width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $precio->Descripcion }}">
                                                {{ $precio->Descripcion }}
                                            </td>
                                            <td>{{ number_format($precio->Precio, 2, ',', '.') }}</td>
                                            <td>{{ $precio->Divisa }}</td>
                                            <td style="max-width: 80px; white-space: nowrap;">{{ number_format($precio->PorcentajeCoeficiente, 2, ',', '.') }}</td>
                                            <td>{{ number_format($precio->Coeficiente, 3, ',', '.') }}</td>

                                            @php $key = 'ot_' . $item_orden_trabajo->id; @endphp

                                            @if (($codigo_complejidad[$key] ?? null) == $precio->CC)
                                                <td class="text-center align-middle">
                                                    <button class="btn btn-sm toggle-row" type="button"
                                                        style="background-color: #fd7e14; color: white;"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit-{{ $precio->id }}"
                                                        wire:click="guardarEstado">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif

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

            @foreach ($item_orden_trabajo->tratamiento->precios->sortBy('CC') as $precio)

                @php $key = 'ot_' . $item_orden_trabajo->id; @endphp

                @if (($codigo_complejidad[$key] ?? null) == $precio->CC)

                    <!-- .modal -->
                    <form action="{{ route('ventas.ficha-del-cliente-nota-envio.cc', $precio)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- ID único por cada precio -->
                        <div class="modal fade" 
                            id="modal-edit-{{ $precio->id }}" 
                            wire:ignore.self>

                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            MODIFICANDO CODIGO DE COMPLEJIDAD: "{{ old('CC', $precio->CC) }}"
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="row">
                                            <div class="col-1"></div>

                                            <input type="hidden" name="IdCodigoComplejidad" value="{{ old('IdCodigoComplejidad', $precio->id) }}">
                                            <input type="hidden" name="IdTratamiento" value="{{ $item_orden_trabajo->tratamiento->id }}">

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="CC" class="font-weight-normal">CC</label>
                                                    <input type="number" id="CC" 
                                                        value="{{ old('CC', $precio->CC) }}" 
                                                        readonly 
                                                        class="form-control form-control-sm">
                                                    <input type="hidden" name="CC" value="{{ old('CC', $precio->CC) }}">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="Precio" class="font-weight-normal">PRECIO</label>
                                                    <input type="text" id="Precio" name="Precio" 
                                                        value="{{ number_format(old('Precio', $precio->Precio), 2, '.', '') }}" 
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="Divisa" class="font-weight-normal">DIVISA</label>
                                                    <select name="Divisa" id="Divisa" 
                                                            class="form-control form-control-sm">
                                                        <option value="ARS" {{ old('Divisa', $precio->Divisa) == 'ARS' ? 'selected' : '' }}>ARS</option>
                                                        <option value="USD" {{ old('Divisa', $precio->Divisa) == 'USD' ? 'selected' : '' }}>USD</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="PorcentajeCoeficiente" class="font-weight-normal">% COEFICIENTE</label>
                                                    <input type="number" id="PorcentajeCoeficiente" name="PorcentajeCoeficiente" 
                                                        value="{{ old('PorcentajeCoeficiente', $precio->PorcentajeCoeficiente) }}" 
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="Coeficiente" class="font-weight-normal">COEFICIENTE</label>
                                                    <input type="number" id="Coeficiente" name="Coeficiente" 
                                                        value="{{ old('Coeficiente', $precio->Coeficiente) }}" 
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                            <div class="col-1"></div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-1"></div>

                                            <div class="col-10">
                                                <div class="form-group mb-0">
                                                    <label for="Descripcion" class="font-weight-normal">DESCRIPCION</label>
                                                    <input type="text" id="Descripcion" name="Descripcion" 
                                                        value="{{ old('Descripcion', $precio->Descripcion) }}" 
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                            <div class="col-1"></div>
                                        </div>

                                    </div>

                                    <div class="modal-footer justify-content-end">
                                        
                                        <button type="submit" class="btn btn-sidebar btn-sm bg-orange">
                                            <span class="text-white">Guardar</span>
                                            <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>
                                        </button>

                                        <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                            <span class="text-white">Cancelar</span>
                                            <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /.modal -->

                @endif

            @endforeach

        @endforeach

        @foreach ($nota_envio->itemsNotaEnvio as $item_nota_envio)
            
            @php
                $item_orden_trabajo = $item_nota_envio->itemOrdenTrabajo;
            @endphp

            <!-- .modal -->
            <div class="modal fade" id="modal-ne-{{ $item_nota_envio->id }}" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-bold">
                            TRABAJO OT {{ $item_nota_envio->itemOrdenTrabajo->ordenTrabajo->NumeroCompleto }}
                        </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        <div class="row">

                            <form action="{{ route('ventas.ficha-del-cliente-nota-envio.orden-trabajo', $item_nota_envio->itemOrdenTrabajo) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <x-panel-horizontal2>
                                <x-slot name="pestañas">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'custom-tabs-1' ? 'active' : '' }}"
                                        wire:click.prevent="setActiveTab('custom-tabs-1')"
                                        id="custom-tabs-1-tab" data-toggle="pill"
                                        href="#custom-tabs-1" role="tab"
                                        aria-controls="custom-tabs-1" aria-selected="true"
                                        style="padding: 3px 8px; font-size: 0.75rem;">
                                        ITEM
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'custom-tabs-2' ? 'active' : '' }}"
                                        wire:click.prevent="setActiveTab('custom-tabs-2')"
                                        id="custom-tabs-2-tab" data-toggle="pill"
                                        href="#custom-tabs-2" role="tab"
                                        aria-controls="custom-tabs-2" aria-selected="true"
                                        style="padding: 3px 8px; font-size: 0.75rem;">
                                        OBSERVACIONES
                                        </a>
                                    </li>
                                </x-slot>

                                <x-slot name="ventanas">
                                    <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-1' ? 'active' : '' }}"
                                        id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab"
                                        style="height: 18rem; padding: 0.5rem;">
                                        <div class="row justify-content-center m-0">
                                            <div class="col-10 card p-1">
                                                <div class="card-body p-2">
                                                    <div class="row justify-content-center m-0">
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">ITEM NRO</label>
                                                            <input type="hidden" name="items[{{ $item_orden_trabajo->id }}][ItemNumero]" value="{{ old('ItemNumero', $item_orden_trabajo->ItemNumero) }}">
                                                            <input type="text" value="{{ old('ItemNumero', $item_orden_trabajo->ItemNumero) }}" disabled class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DESCRIPCIÓN</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][Descripcion]" value="{{ old('items[$item_orden_trabajo->id][Descripcion]', $item_orden_trabajo->Descripcion) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">NRO PLANO PREDETERMINADO</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][NroPlano]" value="{{ old('items[$item_orden_trabajo->id][NroPlano]', $item_orden_trabajo->certificado->NroPlano ?? '') }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                    </div>

                                                    <div class="row justify-content-center m-0">
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">CANTIDAD</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][Cantidad]" value="{{ old('items[$item_orden_trabajo->id][Cantidad]', $item_orden_trabajo->Cantidad) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">PESO</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][Peso]" value="{{ old('items[$item_orden_trabajo->id][Peso]', $item_orden_trabajo->Peso) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">TRATAMIENTO</label>
                                                            <div class="input-group input-group-sm">
                                                                <select 
                                                                    class="form-control form-control-sm p-1" 
                                                                    name="items[{{ $item_orden_trabajo->id }}][IdTratamiento]" 
                                                                    style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;"
                                                                >
                                                                    @foreach ($tratamientos as $tratamiento)
                                                                        <option 
                                                                            value="{{ $tratamiento->id }}" 
                                                                            {{ $item_orden_trabajo->IdTratamiento == $tratamiento->id ? 'selected' : '' }}
                                                                            style="font-size: 0.7rem; white-space: nowrap;"
                                                                        >
                                                                            {{ $tratamiento->Nombre }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button 
                                                                        type="button"
                                                                        disabled
                                                                        class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                        data-toggle="modal" 
                                                                        data-target="#modal-items-ne-{{ $item_nota_envio->id }}-tratamiento"
                                                                        style="height: 22px;"
                                                                    >
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row m-0">
                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">DUREZA</label>
                                                            <div class="input-group input-group-sm">
                                                                <select
                                                                    class="form-control form-control-sm p-1"
                                                                    name="items[{{ $item_orden_trabajo->id }}][IdDureza]" 
                                                                    style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;">
                                                                    @foreach ($durezas as $dureza)
                                                                        <option value="{{ $dureza->id }}"
                                                                            {{ $item_orden_trabajo->IdDureza == $dureza->id ? 'selected' : '' }}
                                                                            style="font-size: 0.7rem; white-space: nowrap;">
                                                                            {{ $dureza->Nombre }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button type="button"
                                                                            disabled
                                                                            class="btn btn-sidebar btn-xs bg-orange p-1"
                                                                            data-toggle="modal"
                                                                            data-target="#modal-items-ne-{{ $item_nota_envio->id }}-dureza">
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DSMIN</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][DurezaSolicitadaMinima]" value="{{ old('items[$item_orden_trabajo->id][DurezaSolicitadaMinima]', $item_orden_trabajo->DurezaSolicitadaMinima) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>

                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.75rem;">DSMAX</label>
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][DurezaSolicitadaMaxima]" value="{{ old('items[$item_orden_trabajo->id][DurezaSolicitadaMaxima]', $item_orden_trabajo->DurezaSolicitadaMaxima) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                        </div>

                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">MATERIAL</label>
                                                            <div class="input-group input-group-sm">
                                                                <select 
                                                                    class="form-control form-control-sm p-1" 
                                                                    name="items[{{ $item_orden_trabajo->id }}][IdMaterial]" 
                                                                    style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;"
                                                                >
                                                                    @foreach ($materiales as $material)
                                                                        <option 
                                                                            value="{{ $material->id }}" 
                                                                            {{ $item_orden_trabajo->IdMaterial == $material->id ? 'selected' : '' }}
                                                                            style="font-size: 0.7rem; white-space: nowrap;"
                                                                        >
                                                                            {{ $material->Nombre }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button 
                                                                        type="button"
                                                                        disabled
                                                                        class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                        data-toggle="modal" 
                                                                        data-target="#modal-items-ne-{{ $item_nota_envio->id }}-material"
                                                                        style="height: 22px;"
                                                                    >
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    

                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">CC</label>
                                                            <div class="input-group input-group-sm">
                                                            <input type="text" name="items[{{ $item_orden_trabajo->id }}][CodigoComplejidad]" value="{{ old('items[$item_orden_trabajo->id][CodigoComplejidad]', $item_orden_trabajo->CodigoComplejidad) }}" class="form-control form-control-sm p-1" style="height: 22px;">
                                                                <div class="input-group-append">
                                                                    <button 
                                                                        type="button" 
                                                                        disabled
                                                                        class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                        data-toggle="modal" 
                                                                        data-target="#modal-items-ne-{{ $item_nota_envio->id }}-tratamiento"
                                                                        style="height: 22px;"
                                                                    >
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-4 mb-2 px-1">
                                                            <label class="font-weight-normal mb-1" style="font-size: 0.7rem;">ESTADO</label>
                                                            <div class="input-group input-group-sm">
                                                                <select 
                                                                    class="form-control form-control-sm p-1" 
                                                                    name="items[{{ $item_orden_trabajo->id }}][Estado]" 
                                                                    style="height: 22px; font-size: 0.7rem; line-height: 1; padding-right: 20px;"
                                                                >
                                                                    <option 
                                                                        value="PENDIENTE" 
                                                                        {{ $item_orden_trabajo->Estado == 'PENDIENTE' ? 'selected' : '' }}
                                                                        style="font-size: 0.7rem; white-space: nowrap;"
                                                                    >
                                                                    PENDIENTE
                                                                    </option>
                                                                    <option 
                                                                        value="APROBADO" 
                                                                        {{ $item_orden_trabajo->Estado == 'APROBADO' ? 'selected' : '' }}
                                                                        style="font-size: 0.7rem; white-space: nowrap;"
                                                                    >
                                                                    APROBADO
                                                                    </option>
                                                                    <option 
                                                                        value="NO APTO" 
                                                                        {{ $item_orden_trabajo->Estado == 'NO APTO' ? 'selected' : '' }}
                                                                        style="font-size: 0.7rem; white-space: nowrap;"
                                                                    >
                                                                    NO APTO
                                                                    </option>
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button 
                                                                        type="button"
                                                                        disabled
                                                                        class="btn btn-sidebar btn-xs bg-orange p-1" 
                                                                        data-toggle="modal" 
                                                                        data-target="#modal-items-ne-{{ $item_nota_envio->id }}-tratamiento"
                                                                        style="height: 22px;"
                                                                    >
                                                                        <i class="fas fa-search fa-xs text-white"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="d-flex justify-content-end mt-2">
                                                        <button class="btn btn-sidebar btn-xs bg-orange px-2 py-1">
                                                            <span class="text-white">Aceptar</span>
                                                            <i class="fas fa-check fa-xs text-white ml-1"></i>
                                                        </button>
                                                        <button class="btn btn-sidebar btn-xs bg-orange px-2 py-1 ml-2" data-dismiss="modal" >
                                                            <span class="text-white">Cancelar</span>
                                                            <i class="fas fa-xmark fa-xs text-white ml-1"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-2' ? 'active' : '' }}"
                                        id="custom-tabs-2" role="tabpanel"
                                        aria-labelledby="custom-tabs-2-tab"
                                        style="height: 18rem; padding: 0.5rem;">
                                        <textarea class="form-control w-100 p-1"
                                                rows="10"
                                                placeholder="Escriba aquí..."
                                                style="resize: none; font-size: 0.8rem;"
                                                name="items[{{ $item_orden_trabajo->id }}][Observaciones]">{{ old('items[$item_orden_trabajo->id][Observaciones]', $item_orden_trabajo->Observaciones) }}</textarea>
                                    </div>
                                </x-slot>
                            </x-panel-horizontal2>
                            </form>

                        
                            </div>

                        </div>

                        </div>

                        </div>
                        </div>

            <!-- /.modal -->

            <!-- .modal -->
            <div class="modal fade" id="modal-cliente-ne-{{ $item_nota_envio->id }}" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-bold">
                            TRATAMIENTO: "{{ $item_nota_envio->itemOrdenTrabajo->tratamiento->Nombre }}"
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
                                        <th>CC</th>
                                        <th>DESCRIPCION</th>
                                        <th>PRECIO</th>
                                        <th>DIVISA</th>
                                        <th style="max-width: 80px;">% COEF.</th>
                                        <th>COEFICIENTE</th>
                                        <th></th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @forelse ($item_nota_envio->itemOrdenTrabajo->tratamiento->precios->sortBy('CC') as $precio)
                                        <tr>
                                            <td>{{ $precio->CC }}</td>
                                            <td style="min-width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $precio->Descripcion }}">
                                                {{ $precio->Descripcion }}
                                            </td>
                                            <td>{{ number_format($precio->Precio, 2, ',', '.') }}</td>
                                            <td>{{ $precio->Divisa }}</td>
                                            <td style="max-width: 80px; white-space: nowrap;">{{ number_format($precio->PorcentajeCoeficiente, 2, ',', '.') }}</td>
                                            <td>{{ number_format($precio->Coeficiente, 3, ',', '.') }}</td>

                                            @php $key = 'nota_' . $item_nota_envio->id; @endphp

                                            @if (($codigo_complejidad[$key] ?? null) == $precio->CC)
                                                <td class="text-center align-middle">
                                                    <button class="btn btn-sm toggle-row" type="button"
                                                        style="background-color: #fd7e14; color: white;"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit-{{ $precio->id }}"
                                                        wire:click="guardarEstado">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif

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

            @foreach ($item_nota_envio->itemOrdenTrabajo->tratamiento->precios->sortBy('CC') as $precio)

                @php $key = 'nota_' . $item_nota_envio->id; @endphp

                @if (($codigo_complejidad[$key] ?? null) == $precio->CC)

                    <!-- .modal -->
                    <form action="{{ route('ventas.ficha-del-cliente-nota-envio.cc', $precio)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- ID único por cada precio -->
                        <div class="modal fade" 
                            id="modal-edit-{{ $precio->id }}" 
                            wire:ignore.self>

                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            MODIFICANDO CODIGO DE COMPLEJIDAD: "{{ old('CC', $precio->CC) }}"
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="row">
                                            <div class="col-1"></div>

                                            <input type="hidden" name="IdCodigoComplejidad" value="{{ old('IdCodigoComplejidad', $precio->id) }}">
                                            <input type="hidden" name="IdTratamiento" value="{{ $item_nota_envio->itemOrdenTrabajo->tratamiento->id }}">

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="CC" class="font-weight-normal">CC</label>
                                                    <input type="number" id="CC" 
                                                        value="{{ old('CC', $precio->CC) }}" 
                                                        readonly 
                                                        class="form-control form-control-sm">
                                                    <input type="hidden" name="CC" value="{{ old('CC', $precio->CC) }}">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="Precio" class="font-weight-normal">PRECIO</label>
                                                    <input type="text" id="Precio" name="Precio" 
                                                        value="{{ number_format(old('Precio', $precio->Precio), 2, '.', '') }}" 
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="Divisa" class="font-weight-normal">DIVISA</label>
                                                    <select name="Divisa" id="Divisa" 
                                                            class="form-control form-control-sm">
                                                        <option value="ARS" {{ old('Divisa', $precio->Divisa) == 'ARS' ? 'selected' : '' }}>ARS</option>
                                                        <option value="USD" {{ old('Divisa', $precio->Divisa) == 'USD' ? 'selected' : '' }}>USD</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="PorcentajeCoeficiente" class="font-weight-normal">% COEFICIENTE</label>
                                                    <input type="number" id="PorcentajeCoeficiente" name="PorcentajeCoeficiente" 
                                                        value="{{ old('PorcentajeCoeficiente', $precio->PorcentajeCoeficiente) }}" 
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group mb-0">
                                                    <label for="Coeficiente" class="font-weight-normal">COEFICIENTE</label>
                                                    <input type="number" id="Coeficiente" name="Coeficiente" 
                                                        value="{{ old('Coeficiente', $precio->Coeficiente) }}" 
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                            <div class="col-1"></div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-1"></div>

                                            <div class="col-10">
                                                <div class="form-group mb-0">
                                                    <label for="Descripcion" class="font-weight-normal">DESCRIPCION</label>
                                                    <input type="text" id="Descripcion" name="Descripcion" 
                                                        value="{{ old('Descripcion', $precio->Descripcion) }}" 
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                            <div class="col-1"></div>
                                        </div>

                                    </div>

                                    <div class="modal-footer justify-content-end">
                                        <button type="submit" class="btn btn-sidebar btn-sm bg-orange">
                                            <span class="text-white">Guardar</span>
                                            <i class="fas fa-floppy-disk fa-fw text-white ml-2"></i>
                                        </button>

                                        <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                                            <span class="text-white">Cancelar</span>
                                            <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /.modal -->

                @endif

            @endforeach

        @endforeach

    </x-layout2>
    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', () => {
                const all = document.getElementById('checkAll');
                const none = document.getElementById('uncheckAll');
                if (all) all.checked = false;
                if (none) none.checked = false;
            });

            // También cuando se hace click (por si Livewire no recarga)
            document.addEventListener('livewire:load', () => {
                const resetCheckboxes = () => {
                    const all = document.getElementById('checkAll');
                    const none = document.getElementById('uncheckAll');
                    if (all) all.checked = false;
                    if (none) none.checked = false;
                };
                window.Livewire.hook('morph.updated', resetCheckboxes);
            });
        </script>
    @endpush
</div>

