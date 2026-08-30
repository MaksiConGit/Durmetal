<div>
<style>
.tabla-clientes-scroll {
    height: 500px;
    max-height: 500px;
    overflow-y: auto;
    overflow-x: hidden;
}

.tabla-clientes-scroll table {
    width: 100%;
}

.expand-wrapper {
    width: 100%;
    max-width: 100%;
    overflow: hidden;
    box-sizing: border-box;
}
</style>
<div
    x-data="{ open: null }"
    x-on:open-item.window="
        open = $event.detail.id;
        $wire.set('selectedIdItem', open);
    "
>
    <x-layout2-sidebar>
        <x-slot name="title">Crear Factura Compra</x-slot>

        <x-slot name="filtros">

            <div class="form-inline mt-5 mr-3 d-flex flex-column align-items-center">

                <div class="form-group mb-3">
                <button 
                    type="button"
                    wire:click="addNewItem"
                    class="btn btn-app bg-primary"
                >
                    <i class="fas fa-plus"></i> Nuevo
                </button>
                </div>
                

                <div class="form-group mb-3">
                    <button
                        type="button"
                        class="btn btn-app bg-primary"
                        x-bind:disabled="open === null"
                        x-on:click="$wire.confirmarEliminarItem()"
                        wire:loading.attr="disabled"
                        wire:target="confirmarEliminarItem"
                        data-bs-toggle="tooltip"
                    >
                        <i class="fas fa-trash-can"></i> Eliminar
                    </button>
                </div>

            </div>

        </x-slot>

<div class="tabla-clientes-scroll">

        <x-data-table-acordion3>

            <x-slot name="filtros">

                <div class="row align-items-end mb-1">

                    <div class="col-2">
                        <div class="form-group mb-1">
                            <label for="PuntoVenta" class="font-weight-normal mb-0 small">PUNTO DE VENTA</label>
                            <input type="number"
                                wire:model.live="punto_venta"
                                name="PuntoVenta"
                                id="PuntoVenta"
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group mb-1">
                            <label for="Numero" class="font-weight-normal mb-0 small">NUMERO</label>
                            <input type="number"
                                id="Numero"
                                wire:model.live="numero"
                                name="Numero"
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="bg-info text-white d-flex justify-content-center align-items-center mx-auto" 
                            style="width: 3rem; height: 3rem; font-weight: bold;">
                            @php
                                $mapa = [
                                    0 => 'C',
                                    1 => 'A',
                                    2 => 'A',
                                    3 => 'C',
                                    4 => 'C',
                                    5 => 'C',
                                ];

                                $letra = $mapa[$proveedor->condicionIVA->id] ?? 'B';
                            @endphp
                            {{ $letra }}
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group mb-1">
                            <label for="FechaEmision" class="font-weight-normal mb-0 small">FECHA DE EMISION</label>
                            <input type="date"
                                id="FechaEmision"
                                name="FechaEmision"
                                wire:model.live="fecha_emision"
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group mb-1">
                            <label for="FechaVencimiento" class="font-weight-normal mb-0 small">
                                FECHA DE VENCIMIENTO
                            </label>
                            <input type="date"
                                id="FechaVencimiento"
                                name="FechaVencimiento"
                                wire:model.live="fecha_vencimiento"
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;">
                        </div>
                    </div>

                </div>

                <div class="row align-items-end mb-1">

                    <div class="col-2">
                        <div class="form-group mb-1">
                            <label for="CodigoProveedor" class="font-weight-normal mb-0 small">
                                CODIGO PROVEEDOR
                            </label>
                            <input type="text"
                                id="CodigoProveedor"
                                name="CodigoProveedor"
                                wire:model.live="proveedor_codigo"
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;"
                                disabled>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group mb-1">
                            <label for="NombreProveedor" class="font-weight-normal mb-0 small">
                                NOMBRE
                            </label>
                            <input type="text"
                                id="NombreProveedor"
                                name="NombreProveedor"
                                wire:model.live="proveedor_nombre"
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;"
                                disabled>
                        </div>
                    </div>

                    <div class="col-2"></div>

                    <div class="col-2">
                        <div class="form-group mb-1">
                            <label for="FechaRegistro" class="font-weight-normal mb-0 small">
                                FECHA DE REGISTRO
                            </label>
                            <input type="date"
                                id="FechaRegistro"
                                name="FechaRegistro"
                                wire:model.live="fecha_registro"
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="custom-control custom-checkbox" style="font-size: 12px;">
                            <input type="hidden" name="Archivado" value="0">
                            <input class="custom-control-input"
                                type="checkbox"
                                id="Archivado"
                                name="Archivado"
                                value="1">
                            <label for="Archivado" class="custom-control-label">
                                PAGO AL CONTADO
                            </label>
                        </div>
                    </div>

                </div>

                <div class="row align-items-end">

                    <div class="col-2">
                        <div class="form-group mb-1">
                            <label for="CAE" class="font-weight-normal mb-0 small">CAE</label>
                            <input type="text"
                                id="CAE"
                                name="CAE"
                                wire:model.live="cae"
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group mb-1">
                            <label for="FechaVencimientoCAE" class="font-weight-normal mb-0 small">
                                FECHA DE VENCIMIENTO CAE
                            </label>
                            <input type="date"
                                id="FechaVencimientoCAE"
                                name="FechaVencimientoCAE"
                                wire:model.live="fecha_vencimiento_cae"
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;">
                        </div>
                    </div>

                </div>

            </x-slot>

            <x-slot name="thead">
                <tr>
                    <th>CODIGO</th>
                    <th>DESCRIPCION</th>
                    <th>CUENTA DE GASTOS</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO UNITARIO</th>
                    <th>% IVA</th>
                    <th>SUBTOTAL</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">

            <tbody x-on:close-all.window="open = null">

                @foreach ($newItems as $index => $newItem)
                        <tr
                            wire:key="new-item-{{ $newItem['id'] }}"
                            @click="
                                open = open === {{ $newItem['id'] }} ? null : {{ $newItem['id'] }};
                                $wire.set('selectedIdItem', open);
                            "
                            style="cursor: pointer;"
                        >
                            <td>{{ $newItem['CodigoArticulo'] }}</td>
                            <td>{{ $newItem['Descripcion'] }}</td>
                            <td>
                                @foreach ($cuentas_gastos as $cuenta_gastos)
                                    @if ($cuenta_gastos->id == $newItem['CuentaGastos'])
                                        {{ $cuenta_gastos->Nombre }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ number_format((float) ($newItem['Cantidad'] ?? 0), 2, ',', '.') }}</td>
                            <td>{{ number_format($newItem['PrecioUnitarioNeto'], 6, ',', '.') }}</td>
                            <td>
                                @foreach ($impuestos_iva as $impuesto_iva)
                                    @if ($impuesto_iva->id == $newItem['IVA'])
                                        {{ $impuesto_iva->Tasa }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ number_format($newItem['Importe'], 2, ',', '.') }}</td>
                        </tr>

                        <tr
                        x-show="open === {{ $newItem['id'] }}"    x-cloak
                            x-transition
                        >                     
                            <td colspan="15" class="p-0">
                                <div class="expand-wrapper">

                            <div class="p-0 m-0">
                                <x-panel-horizontal2>
                                    <x-slot name="pestañas">
                                        <li class="nav-item">
                                            <a class="nav-link {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}"
                                            wire:click.prevent="setActiveTabParametros('custom-tabs-1')"
                                            id="custom-tabs-1-tab" data-toggle="pill"
                                            href="#custom-tabs-1" role="tab"
                                            aria-controls="custom-tabs-1" aria-selected="true"
                                            style="padding: 3px 8px; font-size: 0.75rem;">
                                            ITEM
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}"
                                            wire:click.prevent="setActiveTabParametros('custom-tabs-2')"
                                            id="custom-tabs-2-tab" data-toggle="pill"
                                            href="#custom-tabs-2" role="tab"
                                            aria-controls="custom-tabs-2" aria-selected="true"
                                            style="padding: 3px 8px; font-size: 0.75rem;">
                                            OBSERVACIONES
                                            </a>
                                        </li>
                                    </x-slot>

                                    <x-slot name="ventanas">

                                        <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-1' ? 'active' : '' }}"
                                            id="custom-tabs-1"
                                            role="tabpanel"
                                            aria-labelledby="custom-tabs-1-tab"
                                            style="padding: 0.25rem;">

                                            <div class="row justify-content-center m-0">
                                                <div class="col-10 card p-1">
                                                    <div class="card-body p-1"
                                                        x-data
                                                        x-on:keydown.enter.prevent="
                                                            let inputs = Array.from(
                                                                $el.querySelectorAll('input:not([type=hidden]):not([disabled]), select:not([disabled]), textarea:not([disabled])')
                                                            ).filter(el => el.offsetParent !== null);

                                                            let index = inputs.indexOf(document.activeElement);

                                                            if (inputs[index + 1]) inputs[index + 1].focus();
                                                        ">

                                                        <div class="row m-0">

                                                            <div class="col-2 px-1">
                                                                <label class="font-weight-normal mb-0"
                                                                    style="font-size: 0.65rem;">
                                                                    ITEM NRO
                                                                </label>

                                                                <input type="hidden"
                                                                    name="items[{{ $newItem['id'] }}][ItemNumero]"
                                                                    value="{{ ($item_orden_trabajo->ItemNumero ?? 0) + 1 }}">

                                                                <input type="text"
                                                                    value="{{ ($item_orden_trabajo->ItemNumero ?? 0) + 1 }}"
                                                                    disabled
                                                                    class="form-control form-control-sm p-1"
                                                                    style="height: 20px; font-size: 0.7rem;">
                                                            </div>

                                                            <div class="col-2 px-1">
                                                                <label class="font-weight-normal mb-0"
                                                                    style="font-size: 0.65rem;">
                                                                    CODIGO ARTICULO
                                                                </label>

                                                                <input type="text"
                                                                    wire:model.defer="newItems.{{ $index }}.CodigoArticulo"
                                                                    disabled
                                                                    class="form-control form-control-sm p-1"
                                                                    style="height: 20px; font-size: 0.7rem;">
                                                            </div>

                                                            <div
                                                                class="col-8 px-1"
                                                                x-data="{
                                                                    descripcion: @js($newItem['Descripcion'] ?? ''),

                                                                    sincronizar() {
                                                                        $wire.set(
                                                                            'newItems.{{ $index }}.Descripcion',
                                                                            this.descripcion
                                                                        );
                                                                    }
                                                                }"
                                                            >
                                                                <label class="font-weight-normal mb-0"
                                                                    style="font-size: 0.65rem;">
                                                                    DESCRIPCIÓN
                                                                </label>

                                                                <input
                                                                    type="text"
                                                                    x-model="descripcion"
                                                                    @blur="sincronizar()"
                                                                    class="form-control form-control-sm p-1"
                                                                    style="height: 20px; font-size: 0.7rem;"
                                                                >
                                                            </div>


                                                        </div>

                                                        <div
                                                            class="row m-0 mt-1"
                                                            x-data="{
                                                                cantidad: {{ (float) ($newItem['Cantidad'] ?? 0) }},
                                                                precio: @js($newItem['PrecioUnitarioNeto'] ?? ''),

                                                                get importe() {
                                                                    return (parseFloat(this.cantidad) || 0) *
                                                                        (parseFloat(this.precio) || 0);
                                                                },

                                                                sincronizarCantidad() {
                                                                    $wire.set(
                                                                        'newItems.{{ $index }}.Cantidad',
                                                                        this.cantidad
                                                                    );
                                                                },

                                                                sincronizarPrecio() {
                                                                    $wire.set(
                                                                        'newItems.{{ $index }}.PrecioUnitarioNeto',
                                                                        this.precio === '' ? null : this.precio
                                                                    );
                                                                }
                                                            }"
                                                        >

                                                            {{-- CANTIDAD --}}
                                                            <div class="col-2 px-1">
                                                                <label class="font-weight-normal mb-0"
                                                                    style="font-size: 0.65rem;">
                                                                    CANTIDAD
                                                                </label>

                                                                <input
                                                                    type="number"
                                                                    x-model.number="cantidad"
                                                                    @blur="sincronizarCantidad()"
                                                                    class="form-control form-control-sm p-1"
                                                                    style="height: 20px; font-size: 0.7rem;"
                                                                >
                                                            </div>


                                                            {{-- IVA --}}
                                                            <div class="col-2 px-1">
                                                                <label class="font-weight-normal mb-0"
                                                                    style="font-size: 0.65rem;">
                                                                    IVA
                                                                </label>

                                                                <select
                                                                    wire:model.live="newItems.{{ $index }}.IVA"
                                                                    class="form-control form-control-sm p-1"
                                                                    style="
                                                                        height: 23px;
                                                                        font-size: 0.65rem;
                                                                        line-height: 1;
                                                                        padding-top: 0;
                                                                        padding-bottom: 0;
                                                                        padding-right: 15px;
                                                                    "
                                                                >
                                                                    @foreach ($impuestos_iva as $impuesto_iva)
                                                                        <option value="{{ $impuesto_iva->id }}">
                                                                            {{ $impuesto_iva->Nombre }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>


                                                        {{-- PRECIO UNITARIO --}}
                                                        <div class="col-4 px-1">
                                                            <label class="font-weight-normal mb-0"
                                                                style="font-size: 0.65rem;">
                                                                PRECIO UNITARIO NETO
                                                            </label>

                                                            <input
                                                                type="number"
                                                                x-model.number="precio"
                                                                @blur="sincronizarPrecio()"
                                                                placeholder="0"
                                                                class="form-control form-control-sm p-1"
                                                                style="height: 20px; font-size: 0.7rem;"
                                                            >
                                                        </div>



                                                            {{-- IMPORTE --}}
                                                            <div class="col-4 px-1">
                                                                <label class="font-weight-normal mb-0"
                                                                    style="font-size: 0.65rem;">
                                                                    IMPORTE
                                                                </label>

                                                                <input
                                                                    type="text"
                                                                    readonly
                                                                    :value="importe.toLocaleString('es-AR', {
                                                                        minimumFractionDigits: 2,
                                                                        maximumFractionDigits: 2
                                                                    })"
                                                                    class="form-control form-control-sm p-1"
                                                                    style="height: 20px; font-size: 0.7rem;"
                                                                >
                                                            </div>
                                                        </div>


                                                        <div class="row m-0 mt-1">

                                                            <div class="col-4 px-1">
                                                                <label class="font-weight-normal mb-0"
                                                                    style="font-size: 0.65rem;">
                                                                    CUENTA DE GASTOS
                                                                </label>

                                                                    <select
                                                                        wire:model.live="newItems.{{ $index }}.CuentaGastos"
                                                                        class="form-control form-control-sm p-1"
                                                                        style="height: 23px; font-size: 0.65rem; line-height: 1; padding-top: 0; padding-bottom: 0; padding-right: 15px;">

                                                                    @foreach ($cuentas_gastos as $cuenta_gastos)
                                                                        <option value="{{ $cuenta_gastos->id }}">
                                                                            {{ $cuenta_gastos->Nombre }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="d-flex justify-content-end mt-1">

                                                            <button
                                                                type="button"
                                                                class="btn btn-sidebar btn-xs bg-orange px-2 py-0"
                                                                wire:click="validar"
                                                                wire:loading.class="disabled"
                                                                wire:target="validar"
                                                                style="font-size: 0.7rem; height: 22px;">

                                                                <span class="text-white">Aceptar</span>
                                                                <i class="fas fa-check fa-xs text-white ml-1"></i>

                                                            </button>

                                                            <button
                                                                class="btn btn-sidebar btn-xs bg-orange px-2 py-0 ml-1"
                                                                @click="open = null"
                                                                wire:click="cancelarItem({{ $newItem['id'] }})"
                                                                type="button"
                                                                style="font-size: 0.7rem; height: 22px;">

                                                                <span class="text-white">Cancelar</span>
                                                                <i class="fas fa-xmark fa-xs text-white ml-1"></i>

                                                            </button>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade show {{ $activeTabParametros === 'custom-tabs-2' ? 'active' : '' }}"
                                            id="custom-tabs-2" role="tabpanel"
                                            aria-labelledby="custom-tabs-2-tab"
                                            style="height: 18rem; padding: 0.5rem;">
                                            <textarea class="form-control w-100 p-1"
                                                    rows="10"
                                                    placeholder="Escriba aquí..."
                                                    style="resize: none; font-size: 0.8rem;"
                                                    wire:model.defer="observaciones"></textarea>
                                        </div>
                                    </x-slot>
                                </x-panel-horizontal2>
                            </div>
                            </div>

                        </td>
                    </tr>

                @endforeach

                @php
                    $filasFaltantes = max(0, 8 - count($newItems));
                @endphp

                @for ($i = 0; $i < $filasFaltantes; $i++)
                    <tr>
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

        </x-data-table-acordion3>
    </div>

    <div class="row mt-3">

        {{-- IZQUIERDA: INPUTS --}}
        <div class="col-md-6">

            <div class="row align-items-end mb-2">

                <div class="col-4">
                    <div class="form-group mb-1">
                        <label for="Bonificacion" class="font-weight-normal mb-0 small">
                            % BONIFICACION
                        </label>

                        <input
                            type="number"
                            wire:model.live="bonificacion"
                            name="Bonificacion"
                            id="Bonificacion"
                            placeholder="0"
                            class="form-control form-control-sm py-0"
                            style="height: 28px; font-size: 12px;"
                            @disabled(count($newItems) === 0)
                        >
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group mb-1">
                        <label for="Recargo" class="font-weight-normal mb-0 small">
                            % RECARGO
                        </label>

                        <input
                            type="number"
                            wire:model.live="recargo"
                            name="Recargo"
                            id="Recargo"
                            placeholder="0"
                            class="form-control form-control-sm py-0"
                            style="height: 28px; font-size: 12px;"
                            @disabled(count($newItems) === 0)
                        >
                    </div>
                </div>
            </div>

            <div class="row align-items-end">

                <div class="col-4">
                    <div class="form-group mb-1">
                        <label for="Percepciones" class="font-weight-normal mb-0 small">
                            PERCEPCIONES
                        </label>

                        <div class="input-group">
                            <input
                                type="number"
                                wire:model.live="percepciones"
                                name="Percepciones"
                                id="Percepciones"
                                placeholder="0"
                                disabled
                                class="form-control form-control-sm py-0"
                                style="height: 28px; font-size: 12px;">

                            <div class="input-group-append">
                                <button
                                    type="button"
                                    class="btn btn-sidebar btn-sm bg-orange"
                                    data-toggle="modal"
                                    data-target="#modal-percepciones"
                                    style="height: 28px;">
                                    <i class="fas fa-pencil fa-fw text-white"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        {{-- DERECHA: SUBTOTALES + BOTONES --}}
        <div class="col-md-4 ml-auto">

            <div class="d-flex flex-column align-items-end">

                {{-- SUBTOTAL --}}
                <div class="w-100 mb-1 d-flex justify-content-between align-items-center">
                    <span class="font-weight-semibold" style="font-size: 1.1rem;">
                        SUBTOTAL
                    </span>

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
                    >

                    <input type="hidden" name="Neto" value="{{ $subtotal }}">
                </div>


                {{-- IVA --}}
                <div class="w-100 mb-1 d-flex justify-content-between align-items-center">
                    <span class="font-weight-semibold" style="font-size: 1.1rem;">
                        IVA
                    </span>

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
                            font-size: 0.9rem;
                            color: #6c757d;
                        "
                    >

                    <input type="hidden" name="IVA" value="{{ $iva }}">
                </div>

                {{-- REDONDEO --}}
                <div class="w-100 mb-1 d-flex justify-content-between align-items-center">
                    <span class="font-weight-semibold" style="font-size: 0.8rem;">
                        AJUSTE POR REDONDEO
                    </span>

                    <input
                        type="number"
                        wire:model.live="redondeo"
                        step="0.01"
                        placeholder="0"
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
                    >
                </div>

                {{-- TOTAL --}}
                <div class="w-100 mb-2 d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-dark" style="font-size: 1.2rem;">
                        TOTAL
                    </span>

                    <input
                        type="text"
                        disabled
                        value="{{ number_format($total_final, 2, ',', '.') }}"
                        class="form-control form-control-sm"
                        style="
                            width: 160px;
                            font-size: 1rem;
                            color: #000;
                            text-align: right;
                            background-color: #e9ecef;
                        "
                    >

                    <input type="hidden" name="Total" value="{{ $total_final }}">
                </div>

            </div>


            {{-- BOTONES --}}
            <div class="d-flex justify-content-end align-items-center mt-2">

                <div>
                    <button
                        type="button"
                        wire:click="guardar"
                        wire:loading.attr="disabled"
                        wire:target="guardar"
                        class="btn btn-app bg-primary d-flex align-items-center justify-content-center"
                    >
                        <span wire:loading.remove wire:target="guardar">
                            <i class="fas fa-floppy-disk mr-1"></i>
                            Guardar
                        </span>

                        <span wire:loading wire:target="guardar">
                            <i class="fas fa-spinner fa-spin mr-1"></i>
                            Guardando...
                        </span>
                    </button>
                </div>

                <a
                    class="btn btn-app bg-primary d-flex align-items-center justify-content-center"
                    href="{{ route('compras.ficha-del-proveedor.show', $proveedor) }}"
                >
                    <i class="fas fa-ban mr-1"></i>
                    Cancelar
                </a>

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
            Livewire.on('abrirPdf', (event) => {
                window.open(event.url, '_blank');
            });
        });
    </script>

    <script>
        function abrirModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;

            if (typeof $ !== 'undefined') {
                $('#' + id).modal('show');
            } else {
                const m = new bootstrap.Modal(modal);
                m.show();
            }
        }
    </script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('modal-confirmacion', () => {
                const modal = new bootstrap.Modal(
                    document.getElementById('modal-confirmacion')
                );

                modal.show();
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('refresh-manual', () => {

                setTimeout(() => {
                    document.querySelectorAll('.expandable-body').forEach(el => {
                        el.style.display = 'none';
                    });

                    Livewire.dispatch('$refresh');
                }, 50);

            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('sync-expand', () => {

                setTimeout(() => {

                    const rows = document.querySelectorAll('[data-widget="expandable-table"]');

                    rows.forEach(row => {
                        const isExpanded = row.getAttribute('aria-expanded') === 'true';
                        const body = row.nextElementSibling;

                        if (!isExpanded && body) {
                            body.style.display = 'none';
                        }

                        if (isExpanded && body) {
                            body.style.display = 'table-row';
                        }
                    });

                }, 50);
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

        document.addEventListener('livewire:init', () => {
            Livewire.on('modal-confirmar-eliminar', () => {
                const modal = new bootstrap.Modal(
                    document.getElementById('modal-confirmar-eliminar')
                );

                modal.show();
            });
        });
    </script>

    </x-layout2-sidebar>

<!-- MODAL PERCEPCIONES -->
<div class="modal fade" id="modal-percepciones" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">

            <div class="modal-header py-2">
                <h5 class="modal-title">
                    PERCEPCIONES
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

            <div class="modal-body py-2">

                <div class="row">

                    {{-- IIBB --}}
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label
                                for="percepcion_iibb"
                                class="font-weight-normal mb-0 small"
                            >
                                PERCEPCIÓN IIBB
                            </label>

                            <input
                                type="number"
                                id="percepcion_iibb"
                                wire:model.live="percepcion_iibb"
                                placeholder="0"
                                step="0.01"
                                class="form-control form-control-sm"
                            >
                        </div>
                    </div>

                    {{-- IVA --}}
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label
                                for="percepcion_iva"
                                class="font-weight-normal mb-0 small"
                            >
                                PERCEPCIÓN IVA
                            </label>

                            <input
                                type="number"
                                id="percepcion_iva"
                                wire:model.live="percepcion_iva"
                                placeholder="0"
                                step="0.01"
                                class="form-control form-control-sm"
                            >
                        </div>
                    </div>

                    {{-- GANANCIAS --}}
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label
                                for="percepcion_ganancias"
                                class="font-weight-normal mb-0 small"
                            >
                                PERCEPCIÓN GANANCIAS
                            </label>

                            <input
                                type="number"
                                id="percepcion_ganancias"
                                wire:model.live="percepcion_ganancias"
                                placeholder="0"
                                step="0.01"
                                class="form-control form-control-sm"
                            >
                        </div>
                    </div>

                    {{-- CONCEPTOS NO GRAVADOS --}}
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label
                                for="conceptos_no_gravados"
                                class="font-weight-normal mb-0 small"
                            >
                                CONCEPTOS NO GRAVADOS
                            </label>

                            <input
                                type="number"
                                id="conceptos_no_gravados"
                                wire:model.live="conceptos_no_gravados"
                                placeholder="0"
                                step="0.01"
                                class="form-control form-control-sm"
                            >
                        </div>
                    </div>

                    {{-- IMPUESTO INTERNO --}}
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label
                                for="impuesto_interno"
                                class="font-weight-normal mb-0 small"
                            >
                                IMPUESTO INTERNO
                            </label>

                            <input
                                type="number"
                                id="impuesto_interno"
                                wire:model.live="impuesto_interno"
                                placeholder="0"
                                step="0.01"
                                class="form-control form-control-sm"
                            >
                        </div>
                    </div>

                    {{-- IMPUESTO COMBUSTIBLE --}}
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label
                                for="impuesto_combustible"
                                class="font-weight-normal mb-0 small"
                            >
                                IMPUESTO COMBUSTIBLE
                            </label>

                            <input
                                type="number"
                                id="impuesto_combustible"
                                wire:model.live="impuesto_combustible"
                                placeholder="0"
                                step="0.01"
                                class="form-control form-control-sm"
                            >
                        </div>
                    </div>

                    {{-- IMPUESTO TASA VIAL --}}
                    <div class="col-6">
                        <div class="form-group mb-2">
                            <label
                                for="impuesto_tasa_vial"
                                class="font-weight-normal mb-0 small"
                            >
                                IMPUESTO TASA VIAL
                            </label>

                            <input
                                type="number"
                                id="impuesto_tasa_vial"
                                wire:model.live="impuesto_tasa_vial"
                                placeholder="0"
                                step="0.01"
                                class="form-control form-control-sm"
                            >
                        </div>
                    </div>

                    {{-- SELLADOS --}}
                    <div class="col-6">
                        <div class="form-group mb-0">
                            <label
                                for="sellados"
                                class="font-weight-normal mb-0 small"
                            >
                                SELLADOS
                            </label>

                            <input
                                type="number"
                                id="sellados"
                                wire:model.live="sellados"
                                placeholder="0"
                                step="0.01"
                                class="form-control form-control-sm"
                            >
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer py-2 justify-content-end">

                <button
                    type="button"
                    class="btn btn-sidebar btn-sm bg-orange"
                    data-dismiss="modal"
                    wire:click="calcularPercepciones"
                >
                    <span class="text-white">Aceptar</span>
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

        </div>
    </div>
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-confirmar-eliminar" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-warning text-white">
                <h4 class="modal-title">Confirmar eliminación</h4>

                <button
                    type="button"
                    class="close text-white"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="mb-0">
                    ¿Está seguro de que desea eliminar este item?
                </p>
            </div>

            <div class="modal-footer justify-content-end">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    Cancelar
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    wire:click="eliminarItem"
                    wire:loading.attr="disabled"
                    wire:target="eliminarItem"
                    data-dismiss="modal"
                >
                    <i class="fas fa-trash-can mr-1"></i>
                    Eliminar
                </button>

            </div>

        </div>
    </div>
</div>
    
</div>
</div>