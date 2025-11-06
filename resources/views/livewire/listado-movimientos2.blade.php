<x-simple-table2>
    <x-slot name="filtros">
        <div class="row">
            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">FECHA DESDE</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="fechaDesde" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

            <div class="col-2">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">FECHA HASTA</label>
                    <input type="date" id="filtro1" name="filtro1" wire:model.live="fechaHasta" class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group mb-0">
                    <label for="filtro1" class="font-weight-normal">CUENTA DE GASTOS</label>
                    <select name="" id="" wire:model.live="filtro" class="form-control form-control-sm">
                        <option value="">Todas</option>
                        @foreach ($cuentas_de_gastos as $cuenta_de_gastos)
                            <option value="{{ $cuenta_de_gastos->id }}">{{ $cuenta_de_gastos->Nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    </x-slot>
    <x-slot name="thead">
        <tr>
            <th>FECHA</th>
            <th>N° COMPROBANTE</th>
            <th>PROVEEDOR</th>
            <th>CUENTA</th>
            <th>EXENTO</th>
            <th>ITEM NRO</th>
            <th>NO GRAVADO</th>
            <th>MONOTRIBUTO</th>
            <th>NETO</th>
            <th>IVA</th>
            <th>PERCEPCIONES</th>
            <th>PERCEPCION IVA</th>
            <th>GASTOS NETO IVA</th>
            <th>TOTAL</th>
        </tr>
    </x-slot>
    <x-slot name="tbody">
        @foreach ($this->facturasFiltradas as $factura_compra)

            @foreach ($factura_compra->items as $index => $item)

                <tr style="cursor:pointer;" onclick="window.location='{{ $this->getUrlEditarDocumento($factura_compra) }}'">
                    <td>{{ $factura_compra->FechaEmision }}</td>
                    <td>{{ $factura_compra->NumeroCompleto }}</td>
                    <td>{{ $factura_compra->proveedor->Nombre }}</td>
                    <td>{{ $item->cuentaGastos->Nombre }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ $index <= 0 ? '' : $index }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                </tr>
                
            @endforeach

        @endforeach

        @foreach ($this->notasCreditoFiltradas as $nota_credito_compra)

            @foreach ($nota_credito_compra->items as $index => $item)

                <tr style="cursor:pointer;" onclick="window.location='{{ $this->getUrlEditarDocumento($nota_credito_compra) }}'">
                    <td>{{ $nota_credito_compra->FechaEmision }}</td>
                    <td>{{ $nota_credito_compra->NumeroCompleto }}</td>
                    <td>{{ $nota_credito_compra->proveedor->Nombre }}</td>
                    <td>{{ $item->cuentaGastos->Nombre }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ $index <= 0 ? '' : $index }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                </tr>
                
            @endforeach

        @endforeach
    </x-slot>
</x-simple-table2>


{{-- <div>
    <x-layout2-sidebar>
        <x-slot name="title">Buscar comprobantes</x-slot>
        <x-slot name="filtros">

            <div class="form-inline mt-5">

                <div class="form-group w-100 mb-3">
                
                    <label for="sidebarSearch" class="form-label text-muted small">
                        DESDE FECHA
                    </label>
                    
                    <div class="input-group" data-widget="sidebar-search">
                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="date" placeholder="0" aria-label="Search" wire:model.live="fechaDesde">
                        <div class="input-group-append">
                        </div>
                    </div>
                
                </div>

                <div class="form-group w-100 mb-3">
                
                    <label for="sidebarSearch" class="form-label text-muted small">
                        HASTA FECHA
                    </label>
                    
                    <div class="input-group" data-widget="sidebar-search">
                        <input id="sidebarSearch" 
                            class="form-control form-control-sm bg-white text-dark" 
                            type="date" aria-label="Search" wire:model.live="fechaHasta">
                        <div class="input-group-append">
                        </div>
                    </div>
                
                </div>

                <div class="form-group w-100 mb-3">
                
                <label for="sidebarSearch" class="form-label text-muted small">
                    PUNTO DE VENTA
                </label>
                
                <div class="input-group" data-widget="sidebar-search">
                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" placeholder="0" aria-label="Search" wire:model.live="puntoVenta">
                    <div class="input-group-append">
                    </div>
                </div>
                
                </div>

                <div class="form-group w-100 mb-3">
                
                <label for="sidebarSearch" class="form-label text-muted small">
                    NUMERO
                </label>
                
                <div class="input-group" data-widget="sidebar-search">
                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" placeholder="0" aria-label="Search" wire:model.live="numero">
                    <div class="input-group-append">
                    </div>
                </div>
                
                </div>

                <div class="form-group w-100 mb-3">
                
                <label for="sidebarSearch" class="form-label text-muted small">
                    CODIGO PROVEEDOR
                </label>
                
                <div class="input-group">
                    <input id="sidebarSearch" 
                        class="form-control form-control-sm bg-white text-dark" 
                        type="search" placeholder="0" wire:model.live="proveedor_id">
                    <div class="input-group-append">
                        <button type="button" 
                                class="btn btn-sidebar btn-sm bg-orange" 
                                data-toggle="modal" 
                                data-target="#modal-cliente">
                            <i class="fas fa-search fa-fw text-white"></i>
                        </button>
                    </div>
                </div>
                
                </div>
            </div>

        </x-slot>

        <x-simple-table2>
            <x-slot name="filtros">
                <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" wire:model.live="filtroTipo" value="Todos">
                        <label for="customRadio1" class="custom-control-label font-weight-normal">Todos</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" wire:model.live="filtroTipo" value="FacturaCompra">
                        <label for="customRadio2" class="custom-control-label font-weight-normal">Factura</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio" wire:model.live="filtroTipo" value="NotaDebitoCompra">
                        <label for="customRadio3" class="custom-control-label font-weight-normal">Nota de Débito</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio4" name="customRadio" wire:model.live="filtroTipo" value="NotaCreditoCompra">
                        <label for="customRadio4" class="custom-control-label font-weight-normal">Nota de crédito</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio5" name="customRadio" wire:model.live="filtroTipo" value="OrdenPago">
                        <label for="customRadio5" class="custom-control-label font-weight-normal">Orden de pago</label>
                    </div>
                </div>
            </x-slot>

            <x-slot name="thead">
                <tr>
                    <th>FECHA</th>
                    <th>FECHA VENC.</th>
                    <th>NUMERO</th>
                    <th>CODIGO</th>
                    <th>RAZON SOCIAL</th>
                    <th>ESTADO</th>
                    <th>TOTAL</th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($this->documentosFiltrados as $index => $documento)
                    <tr style="cursor:pointer;" onclick="window.location='{{ $this->getUrlEditarDocumento($documento) }}'">
                        <td>{{ \Carbon\Carbon::parse($documento['FechaEmision'])->format('j/n/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($documento['FechaVencimiento'])->format('j/n/Y') }}</td>
                        <td>{{ $documento['NumeroCompleto'] }}</td>
                        <td>{{ $documento['IdProveedor'] }}</td>
                        <td>{{ $documento['RazonSocial'] }}</td>
                        <td>{{ $documento['Estado'] }}</td>
                        <td>{{ number_format($documento['Total'], 2, '.', '') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8">No se encontraron resultados.</td></tr>
                @endforelse
            </x-slot>
        </x-simple-table2>

    <!-- .modal -->
    <div class="modal fade" id="modal-cliente" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">
                    BUSCAR PROVEEDOR
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
                                <th>CUIT</th>
                                <th>DOMICILIO</th>
                                <th>LOCALIDAD</th>
                                <th>PROVINCIA</th>
                                <th>ACTIVO</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            
                            @forelse ($proveedores as $proveedor)
                                <tr wire:click.prevent="seleccionarCliente({{ $proveedor->id }})"
                                    style="cursor:pointer;"
                                    class="{{ $proveedor_id == $proveedor->id ? 'table-primary' : '' }}">
                                    <td>{{ $proveedor->id }}</td>
                                    <td>{{ $proveedor->Nombre }}</td>
                                    <td>{{ $proveedor->NumeroDocumento }}</td>
                                    <td>{{ $proveedor->Direccion }}</td>
                                    <td>{{ $proveedor->Localidad }}</td>
                                    <td>{{ $proveedor->Provincia }}</td>
                                    <td><input type="checkbox" name="" id="" disabled {{ $proveedor->Activo == 1 ? 'checked' : '' }}></td>
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

    </x-layout2-sidebar>
</div> --}}