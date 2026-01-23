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
            @if ($cliente)
                <div class="mt-2">
                    <strong>{{ $cliente->Nombre ?? $cliente->nombre }}</strong>
                </div>
            @endif
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

            @if($cliente)

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

                        if (in_array($item['tipo'], ['factura', 'debito'])) {
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
            @endif

        </x-slot>

    </x-simple-table2>

    @if (!is_null($cliente))
        <div class="d-flex justify-content-end mt-3">
            <a class="btn btn-app bg-primary"
            href="{{ route('ventas.resumen-cuenta-corriente.pdf', [
                    'cliente' => $cliente->id,
                    'desde'   => $cliente_desde,
                    'hasta'   => $cliente_hasta,
            ]) }}">
                <i class="fas fa-print"></i> Imprimir
            </a>

            <a class="btn btn-app bg-primary" data-toggle="modal" data-target="#modal-email">
                <i class="fas fa-share"></i> Enviar
            </a>
        </div>

        <!-- .modal -->
        <div class="modal fade" id="modal-email" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title text-bold">
                        ENVIAR POR EMAIL
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
                                    <th>EMAIL</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @forelse ($cliente->emails as $email)
                                    <tr>
                                        <td>
                                        <input type="checkbox"
                                            name="emails[]"
                                            value="{{ $email->id }}"
                                            checked>
                                        </td>
                                        <td>{{ $email->Email }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2">No se encontraron resultados.</td></tr>
                                @endforelse

                            </x-slot>
                        </x-simple-table2>
                        </div>
                        </div>

                    </div>

                    </div>

                    <div class="modal-footer justify-content-end">

                        <a class="btn btn-sidebar btn-sm bg-orange"
                        href="#"
                        onclick="

                                const ids = Array.from(
                                    document.querySelectorAll('#modal-email input[name=&quot;emails[]&quot;]:checked')
                                ).map(e => e.value);

                                const qs = new URLSearchParams({
                                    Emails: ids.join(',')
                                });

                                this.href = '{{ route('ventas.resumen-cuenta-corriente.email', $cliente) }}?' + qs.toString();
                        ">
                            <span class="text-white">Aceptar</span>
                            <i class="fas fa-check fa-fw text-white ml-2"></i>
                        </a>

                        <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                            <span class="text-white">Cerrar</span>
                            <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                        </button>

                    </div>
                    </div>
                    </div>

        </div>
        <!-- /.modal -->
    @endif

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
                            
                            @forelse ($periodos as $periodo)
                                <tr wire:click.prevent="seleccionarPeriodo({{ $periodo->id }})"
                                    style="cursor:pointer;"
                                    class="{{ $periodo_id == $periodo->id ? 'table-primary' : '' }}">
                                    <td>{{ $periodo->Nombre }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="1">No se encontraron resultados.</td></tr>
                            @endforelse

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
