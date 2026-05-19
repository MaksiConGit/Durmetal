<div>
    <x-layout2>
        <x-slot name="title">Crear Recibo de Venta</x-slot>

            <x-simple-table2>

                <x-slot name="filtros">

                    <div class="row mb-2 align-items-end">

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="PuntoVenta" class="form-label mb-1" style="font-size: 0.8rem;">PUNTO DE VENTA</label>
                                <select wire:model.defer="punto_venta" id="PuntoVenta" class="form-control form-control-sm py-0">
                                    @foreach ($pto_ventas as $pto_venta)
                                        <option value="{{ $pto_venta->id }}">
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
                                    wire:model.defer="numero"
                                    class="form-control form-control-sm py-0" disabled>
                            </div>
                        </div>

                        <div class="col-2 d-flex flex-column justify-content-end">
                            <div class="bg-info text-white d-flex justify-content-center align-items-center mx-auto" 
                                style="width: 3rem; height: 3rem; font-weight: bold;">
                                X
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="FechaEmision" class="form-label mb-1" style="font-size: 0.8rem;">FECHA</label>
                                <input type="date" id="FechaEmision"
                                    wire:model.live="fecha_emision"
                                    class="form-control form-control-sm py-0">
                            </div>
                        </div>

                    </div>

                    <div class="row mb-2 align-items-end">

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="Id" class="form-label mb-1" style="font-size: 0.8rem;">CODIGO CLIENTE</label>
                                <input wire:model.defer="id_cliente" id="Id" class="form-control form-control-sm py-0" disabled>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group mb-1">
                                <label for="Nombre" class="form-label mb-1" style="font-size: 0.8rem;">NOMBRE</label>
                                <input type="text" id="Nombre"
                                    wire:model.defer="nombre_cliente"
                                    class="form-control form-control-sm py-0" disabled>
                            </div>
                        </div>

                    </div>
                        
                    </div>

                </x-slot>


                <x-slot name="thead">
                    <tr>
                        <th></th>
                        <th>FECHA</th>
                        <th>VENC.</th>
                        <th>NUMERO</th>
                        <th>IMPORTE</th>
                        <th>PENDIENTE</th>
                        <th>A COBRAR</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($facturas_venta as $factura_venta)
                        @php $id = $factura_venta->id; @endphp

                        <tr>
                            <td>
                                <input 
                                    type="checkbox" 
                                    wire:change="onSeleccionChange({{ $factura_venta->id }}, $event.target.checked)">
                                
                            </td>
                            <td>{{ \Carbon\Carbon::parse($factura_venta->FechaEmision)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($factura_venta->FechaVencimiento)->format('d/m/Y') }}</td>
                            <td>{{ $factura_venta->NumeroCompleto }}</td>
                            <td style="min-width: 300px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ number_format($factura_venta->Total, 2, ',', '.') }}
                            </td>
                            <td>{{ number_format($factura_venta->Total, 2, ',', '.') }}</td>
                            <td class="text-center align-middle">
                                <input
                                    step="0.01"
                                    class="form-control form-control-sm p-1 text-center mx-auto"
                                    style="width: 70px;"
                                    wire:model.live="a_cobrar.{{ $id }}"
                                    wire:input="onACobrarChange({{ $id }}, $event.target.value)"
                                >
                            </td>
                        </tr>

                        @if (!empty($facturas_seleccionadas[$id]) && $facturas_seleccionadas[$id])
                            <input type="hidden" name="items[{{ $id }}][IdFacturaVenta]" value="{{ $id }}">
                            <input type="hidden" name="items[{{ $id }}][Total]" value="{{ $a_cobrar[$id] ?? 0 }}">
                        @endif
                    @endforeach

                    @php
                        $cantidadItems = count($facturas_venta);
                        $filasFaltantes = max(0, 3 - $cantidadItems);
                    @endphp

                    @for ($i = 0; $i < $filasFaltantes; $i++)
                        <tr>
                            @for ($j = 0; $j < 7; $j++)
                                <td>&nbsp;</td>
                            @endfor
                        </tr>
                    @endfor

                    <tr>
                        <td colspan="6" class="fw-bold text-end">TOTAL IMPUTADO</td>
                        <td>{{ number_format($total_imputado, 2, ',', '.') }}</td>
                    </tr>

                </x-slot>

            </x-simple-table2>

            <div class="container-fluid px-4 py-3">

                <div class="row">

                    <div class="col-md-8">

                        <x-panel-horizontal2>

                            <x-slot name="pestañas">

                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'custom-tabs-1' ? 'active' : '' }}" wire:click.prevent="setActiveTab('custom-tabs-1')" id="custom-tabs-1-tab" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">EFECTIVO ({{ $cantidad_efectivo }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'custom-tabs-2' ? 'active' : '' }}" wire:click.prevent="setActiveTab('custom-tabs-2')" id="custom-tabs-2-tab" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="true">TRANSFERENCIAS ({{ $cantidad_transferencias }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'custom-tabs-3' ? 'active' : '' }}" wire:click.prevent="setActiveTab('custom-tabs-3')" id="custom-tabs-3-tab" data-toggle="pill" href="#custom-tabs-3" role="tab" aria-controls="custom-tabs-3" aria-selected="true">CHEQUES ({{ $cantidad_cheques }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'custom-tabs-4' ? 'active' : '' }}" wire:click.prevent="setActiveTab('custom-tabs-4')" id="custom-tabs-4-tab" data-toggle="pill" href="#custom-tabs-4" role="tab" aria-controls="custom-tabs-4" aria-selected="true">TARJETAS ({{ $cantidad_tarjetas }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'custom-tabs-5' ? 'active' : '' }}" wire:click.prevent="setActiveTab('custom-tabs-5')" id="custom-tabs-5-tab" data-toggle="pill" href="#custom-tabs-5" role="tab" aria-controls="custom-tabs-5" aria-selected="true">RETENCIONES ({{ $cantidad_retenciones }})</a>
                                </li>
                            </x-slot>

                            <x-slot name="ventanas">

                                <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-1' ? 'active' : '' }}" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1-tab" style="height:30rem">

                                    <x-simple-table2-no-limit>

                                        <x-slot name="thead">

                                            <tr>
                                                <th>IMPORTE</th>
                                            </tr>

                                        </x-slot>

                                        <x-slot name="tbody">

                                            <tr>
                                                <td>
                                                    <input 
                                                        type="number"
                                                        step="0.01"
                                                        wire:model.live="efectivo">
                                                </td>
                                            </tr>

                                        </x-slot>

                                    </x-simple-table2-no-limit>

                                </div>

                                <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-2' ? 'active' : '' }}" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2-tab" style="height:30rem">

                                    <x-simple-table2-no-limit>

                                        <x-slot name="thead">

                                            <tr>
                                                <th></th>
                                                <th>BANCO</th>
                                                <th>IMPORTE</th>
                                            </tr>

                                        </x-slot>

                                        <x-slot name="tbody">

                                            @foreach ($transferencias as $index => $tranferencia)
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sidebar btn-sm bg-danger"
                                                            wire:click="limpiarFila({{ $index }})"
                                                            data-bs-toggle="tooltip"
                                                        >
                                                            <i class="fas fa-ban fa-fw text-white"></i>
                                                        </button>
                                                    </td>

                                                    <td>
                                                        <select wire:model.live="transferencias.{{ $index }}.IdBanco">
                                                            <option value="" hidden>Seleccionar un banco</option>
                                                            @foreach ($bancos as $banco)
                                                                <option value="{{ $banco->id }}">{{ $banco->Nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input
                                                            type="number"
                                                            step="0.01"
                                                            wire:model.live="transferencias.{{ $index }}.Total"
                                                        >
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </x-slot>

                                    </x-simple-table2-no-limit>

                                </div>

                                <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-3' ? 'active' : '' }}" id="custom-tabs-3" role="tabpanel" aria-labelledby="custom-tabs-3-tab" style="height:30rem">

                                    <x-simple-table2-no-limit>

                                        <x-slot name="thead">

                                            <tr>
                                                <th></th>
                                                <th>BANCO</th>
                                                <th>NUMERO</th>
                                                <th>FECHA EMISION</th>
                                                <th>FECHA VENC.</th>
                                                <th>PLAZA</th>
                                                <th>E-CHECK</th>
                                                <th>IMPORTE</th>
                                            </tr>

                                        </x-slot>

                                        <x-slot name="tbody">

                                            @foreach ($cheques as $index => $cheque)
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sidebar btn-sm bg-danger"
                                                            wire:click="limpiarCheque({{ $index }})"
                                                        >
                                                            <i class="fas fa-ban fa-fw text-white"></i>
                                                        </button>
                                                    </td>

                                                    <td>
                                                        <select wire:model.live="cheques.{{ $index }}.IdBanco" style="max-width: 180px;">
                                                            <option value="" hidden>Seleccionar un banco</option>
                                                            @foreach ($bancos as $banco)
                                                                <option value="{{ $banco->id }}">{{ $banco->Nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="number" wire:model.live="cheques.{{ $index }}.Numero" style="max-width: 80px;">
                                                    </td>

                                                    <td>
                                                        <input type="date" wire:model.live="cheques.{{ $index }}.FechaEmision" style="max-width: 120px;">
                                                    </td>

                                                    <td>
                                                        <input type="date" wire:model.live="cheques.{{ $index }}.FechaAcreditacion" style="max-width: 120px;">
                                                    </td>

                                                    <td>
                                                        <input type="number" wire:model.live="cheques.{{ $index }}.Plaza" style="max-width: 80px;">
                                                    </td>

                                                    <td class="text-center">
                                                        <input type="hidden" value="0">
                                                        <input type="checkbox" wire:model.live="cheques.{{ $index }}.EsEcheck" value="1">
                                                    </td>

                                                    <td>
                                                        <input 
                                                            type="number"
                                                            min="0"
                                                            step="0.01"
                                                            wire:model.live="cheques.{{ $index }}.Total"
                                                        >
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </x-slot>

                                    </x-simple-table2-no-limit>

                                </div>

                                <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-4' ? 'active' : '' }}" id="custom-tabs-4" role="tabpanel" aria-labelledby="custom-tabs-4-tab" style="height:30rem">

                                    <x-simple-table2-no-limit>

                                        <x-slot name="thead">

                                            <tr>
                                                <th></th>
                                                <th>DESCRIPCION</th>
                                                <th>IMPORTE</th>
                                            </tr>

                                        </x-slot>

                                        <x-slot name="tbody">

                                            @foreach ($tarjetas as $index => $tarjeta)
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sidebar btn-sm bg-danger"
                                                            wire:click="limpiarTarjeta({{ $index }})"
                                                        >
                                                            <i class="fas fa-ban fa-fw text-white"></i>
                                                        </button>
                                                    </td>

                                                    <td>
                                                        <input 
                                                            type="text"
                                                            wire:model.live="tarjetas.{{ $index }}.Descripcion"
                                                        >
                                                    </td>

                                                    <td>
                                                        <input 
                                                            type="number"
                                                            min="0"
                                                            step="0.01"
                                                            wire:model.live="tarjetas.{{ $index }}.Total"
                                                        >
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </x-slot>

                                    </x-simple-table2-no-limit>

                                </div>

                                <div class="tab-pane fade show {{ $activeTab === 'custom-tabs-5' ? 'active' : '' }}" id="custom-tabs-5" role="tabpanel" aria-labelledby="custom-tabs-5-tab" style="height:30rem">

                                    <x-simple-table2-no-limit>

                                        <x-slot name="thead">

                                            <tr>
                                                <th>RETENCION</th>
                                                <th>IMPORTE</th>
                                            </tr>

                                        </x-slot>

                                        <x-slot name="tbody">

                                            <tr>
                                                <td>DREI</td>
                                                <td>
                                                    <input 
                                                        type="number"
                                                        min="0"
                                                        step="0.01"
                                                        wire:model.live="retenciones.drei"
                                                    >
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>GANANCIAS</td>
                                                <td>
                                                    <input 
                                                        type="number"
                                                        min="0"
                                                        step="0.01"
                                                        wire:model.live="retenciones.ganancias"
                                                    >
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>IIBB</td>
                                                <td>
                                                    <input 
                                                        type="number"
                                                        min="0"
                                                        step="0.01"
                                                        wire:model.live="retenciones.iibb"
                                                    >
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>IVA</td>
                                                <td>
                                                    <input 
                                                        type="number"
                                                        min="0"
                                                        step="0.01"
                                                        wire:model.live="retenciones.iva"
                                                    >
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>SUSS</td>
                                                <td>
                                                    <input 
                                                        type="number"
                                                        min="0"
                                                        step="0.01"
                                                        wire:model.live="retenciones.suss"
                                                    >
                                                </td>
                                            </tr>

                                        </x-slot>

                                    </x-simple-table2-no-limit>

                                </div>

                            </x-slot>

                        </x-panel-horizontal2>

                    </div>

                    <div class="col-md-4">

                        <div class="d-flex flex-column align-items-end fs-6">

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

                            <div class="w-100 mb-2 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark" style="font-size: 1.30rem;">IMPUTADO</span>

                                <input 
                                    type="text"
                                    disabled
                                    value="{{ number_format($total_imputado, 2, ',', '.') }}"

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

                            <div class="w-100 mb-2 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark" style="font-size: 1.30rem;">REMANENTE</span>

                                <input 
                                    type="text"
                                    disabled
                                    value="{{ number_format(($total_final - $total_imputado), 2, ',', '.') }}"

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

                            <a class="btn btn-app bg-primary disabled:opacity-25" wire:click="validar" wire:loading.class="disabled" wire:target="validar">
                                <i class="fas fa-floppy-disk"></i> Guardar
                            </a>

                            <a class="btn btn-app bg-primary" href="{{ route('ventas.ficha-del-cliente.show', $cliente) }}">
                                <i class="fas fa-ban"></i> Cancelar
                            </a>

                        </div>

                    </div>
            
                </div>
        
            </div>

        <!-- .modal -->
        <div class="modal fade" id="modal-confirmacion" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                        NUEVO RECIBO DE VENTA
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12">
                                <div class="form-check">

                                    <p>Confirme que desea crear el Recibo.</p>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer justify-content-end">

                        <button type="button"
                            class="btn btn-sidebar btn-sm bg-orange"
                            wire:click="guardar"
                            wire:loading.attr="disabled"
                            wire:target="guardar"
                            onclick="this.disabled=true; this.classList.add('disabled')">

                            <span class="text-white">Sí, crear</span>
                        </button>

                        <a class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                            <span class="text-white">Cancelar</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->

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
                Livewire.on('modal-confirmacion', () => {
                    const modal = new bootstrap.Modal(
                        document.getElementById('modal-confirmacion')
                    );

                    modal.show();
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

    </x-layout2>
    
</div>