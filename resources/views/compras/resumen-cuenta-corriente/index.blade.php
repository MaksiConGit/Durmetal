{{-- <x-layout>
    <x-slot name="title">Compras</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Resumen de cuenta corriente proveedor</a></li>
    </x-slot>

    <div class="card">

        <div class="card-header">
            <div class="card-title">Filtros</div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-wrap gap-2">

                    <div class="col-md-2">

                        <x-form-input-default-livewire>
                            <x-slot name="label">Cod. Cliente</x-slot>
                            <x-slot name="livewire">wire:model.live="cliente_id"</x-slot>
                            <x-slot name="name">cliente_id</x-slot>
                            <x-slot name="placeholder"></x-slot>
                            <x-slot name="value"></x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-default-livewire>

                    </div>

                    <div class="col-md-4">

                        <x-form-input-select-livewire>
                            <x-slot name="label">Nombre</x-slot>
                            <x-slot name="livewire">wire:model.live="cliente_id"</x-slot>
                            <x-slot name="name">cliente_id</x-slot>
                            <x-slot name="option">
                                <option value="">-- Todos los clientes --</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->Nombre }}</option>
                                @endforeach
                            </x-slot>
                            <x-slot name="message"></x-slot>
                            <x-slot name="error"></x-slot>
                        </x-form-input-select-livewire>
                        
                    </div>
                    
                    <div class="align-self-end">
                        <div class="form-group">
                            <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalToggle">Buscar</a>
                        </div>
                    </div>

                    <x-modal-table>
                        <x-slot name="title">Buscar Cliente</x-slot>
                        <x-slot name="body">

                            <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">

                                <x-data-table-no-plus-no-export>
        
                                    <x-slot name="table_title">Clientes</x-slot>
                                    <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
                                    <x-slot name="create_route">{{ route('clients.create') }}</x-slot>
                                    <x-slot name="add_text">Añadir cliente</x-slot>
                                    <x-slot name="head_tr">
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Documento</th>
                                            <th>Número</th>
                                            <th>Domicilio</th>
                                            <th>Localidad</th>
                                            <th>Provincia</th>
                                            <th>Activo</th>
                                        </tr>
                                    </x-slot>
                                    <x-slot name="body_tr">
                                
                                        @foreach ($proveedores as $proveedor)
                                            <tr style="cursor: pointer;" wire:click="$set('cliente_id', {{ $proveedor->id }})" data-bs-dismiss="modal">
                                                <td>{{ $proveedor->id }}</td>
                                                <td>{{ $proveedor->Nombre }}</td>
                                                <td>{{ $proveedor->TipoDocumento }}</td>
                                                <td>{{ $proveedor->Telefono }}</td>
                                                <td>{{ $proveedor->Domicilio }}</td>
                                                <td>{{ $proveedor->localidad->Nombre ?? 'Ciudad no asignada' }}</td>
                                                <td>{{ $proveedor->localidad->provincia->Nombre ?? 'Provincia no asignada' }}</td>
                                                <td>
                                                    <input type="checkbox" name="" id="" disabled {{ $proveedor->Activo == 1 ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </x-slot>
                                    <x-slot name="foot_tr">
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Documento</th>
                                            <th>Número</th>
                                            <th>Domicilio</th>
                                            <th>Localidad</th>
                                            <th>Provincia</th>
                                            <th>Activo</th>
                                        </tr>
                                    </x-slot>
                                </x-data-table-no-plus-no-export>

                            </div>

                        </x-slot>
                        <x-slot name="primary_text">Aceptar</x-slot>
                        <x-slot name="secondary_text">Volver</x-slot>
                    </x-modal-table>
                
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <x-form-input-date>
                        <x-slot name="label">Desde Fecha</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_desde"</x-slot>
                        <x-slot name="name">cliente_desde</x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date>
                </div>

                <div class="col-md-3">
                    <x-form-input-date>
                        <x-slot name="label">Hasta Fecha</x-slot>
                        <x-slot name="livewire">wire:model.live="cliente_hasta"</x-slot>
                        <x-slot name="name">cliente_hasta</x-slot>
                        <x-slot name="placeholder"></x-slot>
                        <x-slot name="value"></x-slot>
                        <x-slot name="message"></x-slot>
                        <x-slot name="error"></x-slot>
                    </x-form-input-date>
                </div>
            </div>
        </div>
    </div>

    <x-card>
        <x-slot name="card_title">Listado de Cheques</x-slot>
        <x-slot name="body">
            <x-data-table-no-plus>
                <x-slot name="table_title">Listado de Cheques a Clientes</x-slot>
                <x-slot name="export_route"></x-slot>
                <x-slot name="head_tr">
                    <tr>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Conceptos</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <th>Saldo</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @if($proveedor)
                        @php
                            $saldo = $proveedor->SaldoSistemaAnterior;
                        @endphp

                        <tr>
                            <td></td>
                            <td></td>
                            <td>Saldo Anterior</td>
                            <td>{{ number_format($proveedor->SaldoSistemaAnterior, 2, '.', '') }}</td>
                            <td></td>
                            <td>{{ number_format($saldo, 2, '.', '') }}</td>
                        </tr>

                        @foreach ($documentos as $documento)
                            @php
                                if ($documento instanceof App\Models\OrdenPago || $documento instanceof App\Models\NotaCreditoCompra) {
                                    $saldo -= $documento->Total;
                                    $debe = '';
                                    $haber = number_format($documento->Total, 2, '.', '');
                                } else {
                                    $saldo += $documento->Total;
                                    $debe = number_format($documento->Total, 2, '.', '');
                                    $haber = '';
                                }
                            @endphp

                            <tr>
                                <td>{{ $documento->FechaEmision }}</td>
                                <td>{{ $documento->FechaVencimiento ?? '' }}</td>
                                <td>{{ $documento->NumeroCompleto ?? '' }}</td>
                                <td>{{ $debe }}</td>
                                <td>{{ $haber }}</td>
                                <td>{{ number_format($saldo, 2, '.', '') }}</td>
                            </tr>
                        @endforeach


                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>Total Saldo</strong></td>
                            <td></td>
                            <td></td>
                            <td><strong>{{ number_format($saldo, 2, '.', '') }}</strong></td>
                        </tr>
                    @endif
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Conceptos</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <th>Saldo</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>

        <x-slot name="buttons">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <x-button>
                        <x-slot name="text">Imprimir</x-slot>
                        <x-slot name="color">success</x-slot>
                        <x-slot name="href"></x-slot>
                    </x-button>
                    <x-button>
                        <x-slot name="text">Enviar</x-slot>
                        <x-slot name="color">success</x-slot>
                        <x-slot name="href"></x-slot>
                    </x-button>
                    <x-button>
                        <x-slot name="text">Salir</x-slot>
                        <x-slot name="color">danger</x-slot>
                        <x-slot name="href"></x-slot>
                    </x-button>
                </div>
            </div>
        </x-slot>
    </x-card>

</x-layout> --}}

<x-layout2>
    <x-slot name="title">Resumen de cuenta corriente proveedor</x-slot>

<div>
<div>
    <x-simple-table2>
        <x-slot name="filtros">
            <div class="row">
                <div class="col-2">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">CODIGO</label>
                    </div>
                    <div class="input-group">
                        <input id="sidebarSearch" wire:model.live="cliente_id"
                            class="form-control form-control-sm bg-white text-dark" 
                            type="search" placeholder="0" aria-label="Search">
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

                <div class="col-2">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">DESDE FECHA</label>
                        <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_desde" class="form-control form-control-sm" placeholder="Buscar...">
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group mb-0">
                        <label for="filtro1" class="font-weight-normal">HASTA FECHA</label>
                        <input type="date" id="filtro1" name="filtro1" wire:model.live="cliente_hasta" class="form-control form-control-sm" placeholder="Buscar...">
                    </div>
                </div>

                <div class="col-2 d-flex align-items-end">
                    <div class="input-group-append">
                        <button type="button" 
                                class="btn btn-sidebar btn-sm bg-orange" 
                                data-toggle="modal" 
                                data-target="#modal-periodos">
                            <i class="fas fa-ellipsis-h fa-fw text-white"></i>
                        </button>
                    </div>
                </div>

            </div>
            </div>
        </x-slot>
        <x-slot name="thead">
            <tr>
                <th>FECHA</th>
                <th>FECHA VENC.</th>
                <th>CONCEPTOS</th>
                <th>DEBE</th>
                <th>HABER</th>
                <th>SALDO</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">

            {{-- @if($cliente)

                @php 
                    $saldo = $cliente->SaldoSistemaAnterior; 
                    $minFilas = 9;
                @endphp

                <tr>
                    <td></td>
                    <td></td>
                    <td>Saldo Anterior</td>
                    <td>{{ number_format($saldo, 2, '.', '') }}</td>
                    <td></td>
                    <td>{{ number_format($saldo, 2, '.', '') }}</td>
                </tr>

                @foreach ($documentos as $item)
                    @php
                        $doc = $item['documento'];
                        if ($item['tipo'] === 'factura') {
                            $saldo += $doc->Total;
                            $debe = number_format($doc->Total, 2, '.', '');
                            $haber = '';
                        } else {
                            $saldo -= $doc->Total;
                            $debe = '';
                            $haber = number_format($doc->Total, 2, '.', '');
                        }
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($doc->FechaEmision)->format('j/n/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($doc->FechaVencimiento)->format('j/n/Y') }}</td>
                        <td>{{ $doc->NumeroCompleto ?? '' }}</td>
                        <td>{{ $debe }}</td>
                        <td>{{ $haber }}</td>
                        <td>{{ number_format($saldo, 2, '.', '') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5"><strong>Total Saldo</strong></td>
                    <td><strong>{{ number_format($saldo, 2, '.', '') }}</strong></td>
                </tr>
                @php
                    $filasActuales = count($documentos) + 1;
                    $filasFaltantes = max(0, $minFilas - $filasActuales);
                @endphp

                @for ($i = 0; $i < $filasFaltantes; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor

            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td>Saldo Anterior</td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                    <td></td>
                    <td>{{ number_format(0, 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td colspan="5"><strong>Total Saldo</strong></td>
                    <td><strong>{{ number_format(0, 2, '.', '') }}</strong></td>
                </tr>
                @for ($i = 0; $i < 9; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor
            @endif --}}

        </x-slot>

    </x-simple-table2>

    <div class="d-flex justify-content-end mt-3">
        <a class="btn btn-app bg-info disabled">
            <i class="fas fa-print"></i> Imprimir
        </a>

        <a class="btn btn-app bg-info disabled">
            <i class="fas fa-share"></i> Enviar
        </a>
    </div>

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
                            
                            {{-- @forelse ($clientes as $cliente)
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
                            @endforelse --}}
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

    <!-- .modal -->
    <div class="modal fade" id="modal-periodos" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">
                    PERIODOS
                </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <x-simple-table2>

                        <x-slot name="tbody">
                            
                            {{-- @forelse ($periodos as $periodo)
                                <tr wire:click.prevent="seleccionarPeriodo({{ $periodo->id }})"
                                    style="cursor:pointer;"
                                    class="{{ $periodo_id == $periodo->id ? 'table-primary' : '' }}">
                                    <td>{{ $periodo->Nombre }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="1">No se encontraron resultados.</td></tr>
                            @endforelse --}}

                        </x-slot>
                    </x-simple-table2>

                </div>

                <div class="modal-footer justify-content-end">

                    <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                        <span class="text-white">Aceptar</span>
                        <i class="fas fa-check fa-fw text-white ml-2"></i>
                    </button>

                    <button class="btn btn-sidebar btn-sm bg-orange" 
                            data-dismiss="modal" 
                            wire:click="cancelarPeriodo">
                        <span class="text-white">Cancelar</span>
                        <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                    </button>

                </div>

            </div>
        </div>
    </div>
    <!-- /.modal -->
</div>

</x-layout2>