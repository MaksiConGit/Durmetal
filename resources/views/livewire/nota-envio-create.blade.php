<div>
    <x-layout2>
        <x-slot name="title">Crear Nota de Envío</x-slot>

        <form action="{{ route('ventas.ficha-del-cliente-nota-envio.store', $cliente)}}" method="POST">
            @csrf

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
                                    value="{{old('Numero', $next_nota_numero)}}"
                                    class="form-control form-control-sm py-0" disabled>
                                <input type="hidden" name="Numero" value="{{old('Numero', $next_nota_numero)}}">
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
                                <input type="date" id="FechaEmision" name="FechaEmision"
                                    value="{{old('FechaEmision', $fechaEmision)}}"
                                    class="form-control form-control-sm py-0">
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

                </x-slot>


                <x-slot name="thead">
                    <tr>
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
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                @foreach ($items_orden_trabajo as $item_orden_trabajo)
                    @php $id = $item_orden_trabajo->id; @endphp

                    <tr>
                        <td>
                            <input 
                                type="checkbox" 
                                wire:model.live="seleccionados.{{ $id }}"
                            >
                        </td>

                        <td></td>
                        <td class="text-center align-middle">
                            <input 
                                type="text"
                                class="form-control form-control-sm p-1 text-center mx-auto 
                                    {{ $codigo_invalido[$id] ? 'text-danger border-danger' : '' }}"
                                style="width: 30px;"
                                value="{{ $item_orden_trabajo->CodigoComplejidad }}"
                                        wire:model.live="codigo_complejidad.{{ $id }}"

                                wire:input="onCodigoComplejidadChange({{ $id }}, $event.target.value)"
                            />
                        </td>

                        <td>
                            <input 
                                class="form-control form-control-sm p-1 text-center mx-auto"
                                style="width: 40px;"
                                wire:model.live="descuento.{{ $id }}"
                            />
                        </td>

                        <td>{{ $item_orden_trabajo->ordenTrabajo->FechaEmision }}</td>
                        <td>{{ $item_orden_trabajo->ordenTrabajo->NumeroCompleto }} {{ $item_orden_trabajo->ItemNumero }}</td>
                        <td class="text-center align-middle">
                            <button class="btn btn-sm toggle-row" type="button" style="background-color: #fd7e14; color: white;">
                                <i class="fa-solid fa-pencil"></i>
                            </button>
                        </td>
                        <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                        <td style="min-width: 300px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $descripcion[$id] ?? $item_orden_trabajo->Descripcion }}
                        </td>
                        <td>{{ $item_orden_trabajo->Estado }}</td>
                        <td>{{ $item_orden_trabajo->Cantidad }}</td>
                        <td>{{ $item_orden_trabajo->Peso }}</td>
                        <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                        <td class="text-center align-middle">
                            <input 
                                step="0.01"
                                class="form-control form-control-sm p-1 text-center mx-auto"
                                style="width: 70px;"
                                wire:model.live="precio_unitario.{{ $id }}"
                                wire:input="onPrecioChange({{ $id }}, $event.target.value)"
                            />
                        </td>
                        <td class="text-center align-middle">
                            <button class="btn btn-sm toggle-row" type="button" style="background-color: #fd7e14; color: white;">
                                <i class="fa-solid fa-list"></i>
                            </button>
                        </td>
                        <td class="text-center align-middle">
                            <input 
                                type="text"
                                class="form-control form-control-sm p-1 text-center mx-auto bg-light"
                                style="width: 90px;"
                                value="{{ number_format($total[$id] ?? 0, 2) }}"
                                readonly
                            />
                        </td>
                    </tr>

                    @if (!empty($seleccionados[$id]) && $seleccionados[$id])
                        <input type="hidden" name="items[{{ $id }}][IdItemOrdenTrabajo]" value="{{ $id }}">
                        <input type="hidden" name="items[{{ $id }}][Descripcion]" value="{{ $descripcion[$id] ?? $item_orden_trabajo->Descripcion }}">
                        <input type="hidden" name="items[{{ $id }}][CodigoComplejidad]" value="{{ $codigo_complejidad[$id] ?? '' }}">
                        <input type="hidden" name="items[{{ $id }}][Coeficiente]" value="{{ $coeficiente[$id] ?? 1 }}">
                        <input type="hidden" name="items[{{ $id }}][PorcentajeDescuento]" value="{{ $descuento[$id] ?? 0 }}">
                        <input type="hidden" name="items[{{ $id }}][PrecioUnitario]" value="{{ $precio_unitario[$id] ?? 0 }}">
                        <input type="hidden" name="items[{{ $id }}][Total]" value="{{ $total[$id] ?? 0 }}">
                    @endif
                @endforeach


                    @php
                        $filasFaltantes = max(0, 12 - count($items_orden_trabajo));
                    @endphp

                    @for ($i = 10; $i < 12; $i++)
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endfor

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
                            ></textarea>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label class="form-label fw-normal small me-2 mb-0 mr-3">ESTADO</label>
                            <input type="text" class="form-control form-control-sm text-dark w-auto" value="PENDIENTE" disabled>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="d-flex flex-column align-items-end fs-6">

                            <div class="w-100 mb-1 d-flex justify-content-between">
                                <span class="fw-semibold" style="font-size: 0.9rem;">SUBTOTAL</span>
                                <span class="text-muted" style="font-size: 0.9rem;">
                                    {{ number_format($subtotal, 2, ',', '.') }}
                                </span>
                            </div>

                            <div class="w-100 mb-1 d-flex justify-content-between align-items-center">
                                <span class="fw-semibold" style="font-size: 1rem;">% DESCUENTO</span>
                                <input 
                                    name="PorcentajeDescuento"
                                    class="form-control form-control-sm text-end"
                                    style="width: 80px; text-align: right;"
                                    wire:model.live="porcentaje_descuento"
                                    wire:input="onPorcentajeDescuentoChange($event.target.value)"
                                />
                            </div>

                            <div class="w-100 mb-1 d-flex justify-content-between">
                                <span class="fw-semibold" style="font-size: 1rem;">BASE IMPONIBLE</span>
                                <span class="text-muted" style="font-size: 1rem;">
                                    {{ number_format($base_imponible, 2, ',', '.') }}
                                </span>
                                <input type="hidden" name="Neto" value="{{ $base_imponible }}">
                            </div>

                            <div class="w-100 mb-2 d-flex justify-content-between">
                                <span class="fw-semibold" style="font-size: 1rem;">IVA (21%)</span>
                                <span class="text-muted" style="font-size: 1rem;">
                                    {{ number_format($iva, 2, ',', '.') }}
                                </span>
                                <input type="hidden" name="IVA" value="{{ $iva }}">
                            </div>

                            <div class="w-100 mt-2 d-flex justify-content-between align-items-center bg-light px-3 py-2 rounded border">
                                <span class="fw-bold text-dark" style="font-size: 1.15rem;">TOTAL</span>
                                <span class="fw-bold text-dark" style="font-size: 1.15rem;">
                                    {{ number_format($total_final, 2, ',', '.') }}
                                </span>
                                <input type="hidden" name="Total" value="{{ $total_final }}">
                            </div>
                        </div>

                        <div class="mt-3 text-end">
                            <button class="btn btn-sm btn-primary me-2">
                            <i class="bi bi-save"></i> Guardar
                            </button>

                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('ventas.ficha-del-cliente.show', $cliente) }}">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>

                        </div>

                    </div>
            
                </div>
        
            </div>
    
        </form>

    </x-layout2>
    
</div>