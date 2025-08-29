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
          
          <div class="input-group">
            <input id="sidebarSearch" 
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

    <!-- .modal -->
  <div class="modal fade" id="modal-cliente">
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
                        <tr>
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

                <button class="btn btn-sidebar btn-sm bg-orange" data-dismiss="modal">
                    <span class="text-white">Cancelar</span>
                    <i class="fas fa-xmark fa-fw text-white ml-2"></i>
                </button>

            </div>

        </div>
    </div>
  </div>
  <!-- /.modal -->

</x-layout2-sidebar>