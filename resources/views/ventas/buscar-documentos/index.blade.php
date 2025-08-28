<x-layout2-sidebar>
    <x-slot name="title">Buscar documentos</x-slot>
    <x-slot name="filtros">

      <div class="form-inline mt-5">
        <div class="form-group w-100 mb-3">
          
          <label for="sidebarSearch" class="form-label text-muted small">
            DESDE FECHA
          </label>
          
          <div class="input-group" data-widget="sidebar-search">
            <input id="sidebarSearch" 
                  class="form-control form-control-sm bg-white text-dark" 
                  type="date" placeholder="0" aria-label="Search">
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
                  type="date" aria-label="Search">
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
                  type="search" placeholder="0" aria-label="Search">
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
                  type="search" placeholder="0" aria-label="Search">
            <div class="input-group-append">
            </div>
          </div>
          
        </div>

        <div class="form-group w-100 mb-3">
          
          <label for="sidebarSearch" class="form-label text-muted small">
            CODIGO CLIENTE
          </label>
          
          <div class="input-group" data-widget="sidebar-search">
            <input id="sidebarSearch" 
                  class="form-control form-control-sm bg-white text-dark" 
                  type="search" placeholder="0" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar btn-sm bg-orange">
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
                    <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio">
                    <label for="customRadio1" class="custom-control-label font-weight-normal">Todos</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio">
                    <label for="customRadio2" class="custom-control-label font-weight-normal">Nota de Envío</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio">
                    <label for="customRadio3" class="custom-control-label font-weight-normal">Factura</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="customRadio4" name="customRadio">
                    <label for="customRadio4" class="custom-control-label font-weight-normal">Nota de Débito</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="customRadio5" name="customRadio">
                    <label for="customRadio5" class="custom-control-label font-weight-normal">Nota de Crédito</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="customRadio6" name="customRadio">
                    <label for="customRadio6" class="custom-control-label font-weight-normal">Recibo</label>
                </div>
            </div>
        </x-slot>

        <x-slot name="thead">
            <tr>
                <th>Fecha</th>
                <th>Fecha Venc.</th>
                <th>Número</th>
                <th>Código</th>
                <th>Razón Social</th>
                <th>Estado</th>
                <th>% Desc</th>
                <th>Total</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @forelse ($documentos as $index => $documento)
                {{-- <tr style="cursor: pointer;" 
                    onclick="window.location='{{ match($filtro) {
                        'trabajos_pendientes_nota_envio' => route('ventas.ficha-del-cliente-nota-envio.create', $documento),
                        'notas_pendientes' => route('ventas.ficha-del-cliente-factura-venta.create', $documento),
                        'facturas_pendientes' => route('ventas.ficha-del-cliente-recibo-venta.create', $documento),
                        default => route('ventas.ficha-del-cliente.show', $documento)
                    } }}'"> --}}
                <tr>
                    <td>{{ \Carbon\Carbon::parse($documento->FechaEmision)->format('j/n/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($documento->FechaVencimiento)->format('j/n/Y') }}</td>
                    <td>{{ $documento->NumeroCompleto }}</td>
                    <td>{{ $documento->IdCliente }}</td>
                    <td>{{ $documento->RazonSocial }}</td>
                    <td>{{ $documento->Estado }}</td>
                    <td>{{ number_format($documento->PorcentajeDescuento, 2, '.', '') }}</td>
                    <td>{{ number_format($documento->Total, 2, '.', '') }}</td>
                </tr>
            @empty
                <tr><td colspan="8">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
    </x-simple-table2>


    {{-- <x-panel-horizontal-6-no-title>
        <x-slot name="panel1">Todos</x-slot>
        <x-slot name="body1">

            <x-data-table-no-plus>
                <x-slot name="table_title">Documentos</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($documentos as $index => $documento)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar documento"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $documento->FechaEmision }}</td>
                            <td>{{ $documento->FechaVencimiento }}</td>
                            <td>{{ $documento->NumeroCompleto }}</td>
                            <td>{{ $documento->IdCliente }}</td>
                            <td>{{ $documento->RazonSocial }}</td>
                            <td>{{ $documento->Estado }}</td>
                            <td>{{ number_format($documento->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($documento->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel2">Nota de Envío</x-slot>

        <x-slot name="body2">

            <x-data-table-no-plus>
                <x-slot name="table_title">Notas de Envío</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($notas_de_envio as $index => $nota_de_envio)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar nota de envío"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $nota_de_envio->FechaEmision }}</td>
                            <td>{{ $nota_de_envio->FechaVencimiento }}</td>
                            <td>{{ $nota_de_envio->NumeroCompleto }}</td>
                            <td>{{ $nota_de_envio->IdCliente }}</td>
                            <td>{{ $nota_de_envio->RazonSocial }}</td>
                            <td>{{ $nota_de_envio->Estado }}</td>
                            <td>{{ number_format($nota_de_envio->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_de_envio->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel3">Factura</x-slot>

        <x-slot name="body3">

            <x-data-table-no-plus>
                <x-slot name="table_title">Facturas</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($facturas as $index => $factura)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar factura"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $factura->FechaEmision }}</td>
                            <td>{{ $factura->FechaVencimiento }}</td>
                            <td>{{ $factura->NumeroCompleto }}</td>
                            <td>{{ $factura->IdCliente }}</td>
                            <td>{{ $factura->RazonSocial }}</td>
                            <td>{{ $factura->Estado }}</td>
                            <td>{{ number_format($factura->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($factura->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel4">Nota de Débito</x-slot>

        <x-slot name="body4">

            <x-data-table-no-plus>
                <x-slot name="table_title">Notas de Débito</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($notas_de_debito as $index => $nota_de_debito)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar nota de débito"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $nota_de_debito->FechaEmision }}</td>
                            <td>{{ $nota_de_debito->FechaVencimiento }}</td>
                            <td>{{ $nota_de_debito->NumeroCompleto }}</td>
                            <td>{{ $nota_de_debito->IdCliente }}</td>
                            <td>{{ $nota_de_debito->RazonSocial }}</td>
                            <td>{{ $nota_de_debito->Estado }}</td>
                            <td>{{ number_format($nota_de_debito->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_de_debito->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel5">Nota de Crédito</x-slot>

        <x-slot name="body5">

            <x-data-table-no-plus>
                <x-slot name="table_title">Notas de Crédito</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($notas_de_credito as $index => $nota_de_credito)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar nota de crédito"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $nota_de_credito->FechaEmision }}</td>
                            <td>{{ $nota_de_credito->FechaVencimiento }}</td>
                            <td>{{ $nota_de_credito->NumeroCompleto }}</td>
                            <td>{{ $nota_de_credito->IdCliente }}</td>
                            <td>{{ $nota_de_credito->RazonSocial }}</td>
                            <td>{{ $nota_de_credito->Estado }}</td>
                            <td>{{ number_format($nota_de_credito->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($nota_de_credito->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel6">Recibo</x-slot>

        <x-slot name="body6">

            <x-data-table-no-plus>
                <x-slot name="table_title">Recibos</x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">

                    @forelse ($recibos as $index => $recibo)
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                                    <a
                                        href="{{ route('ventas.ficha-del-cliente-nota-envio.create', $cliente) }}"
                                        class="btn btn-link btn-primary p-0"
                                        data-bs-toggle="tooltip"
                                        title="Editar recibo"
                                    >
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                            </td>
                            <td>{{ $recibo->FechaEmision }}</td>
                            <td>{{ $recibo->FechaVencimiento }}</td>
                            <td>{{ $recibo->NumeroCompleto }}</td>
                            <td>{{ $recibo->IdCliente }}</td>
                            <td>{{ $recibo->RazonSocial }}</td>
                            <td>{{ $recibo->Estado }}</td>
                            <td>{{ number_format($recibo->PorcentajeDescuento, 2, '.', '') }}</td>
                            <td>{{ number_format($recibo->Total, 2, '.', '') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                    @endforelse
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Opciones</th>
                        <th>Fecha</th>
                        <th>Fecha Venc.</th>
                        <th>Número</th>
                        <th>Código</th>
                        <th>Razón Social</th>
                        <th>Estado</th>
                        <th>% Desc</th>
                        <th>Total</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

    </x-panel-horizontal-6-no-title> --}}

</x-layout2-sidebar>