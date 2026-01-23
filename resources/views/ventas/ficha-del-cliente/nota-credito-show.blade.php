<x-layout2>

    <x-slot name="title">Crear Nota de Crédito Venta</x-slot>

    <x-simple-table2>

        <x-slot name="filtros">

            <div class="row mb-2 align-items-end">

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="PuntoVenta" class="form-label mb-1" style="font-size: 0.8rem;">PUNTO DE VENTA</label>
                        <select name="PuntoVenta" id="PuntoVenta" class="form-control form-control-sm py-0" disabled>
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
                            value="{{ $nota_credito_venta->Numero }}"
                            class="form-control form-control-sm py-0" disabled>
                        <input type="hidden" name="Numero" value="{{ $nota_credito_venta->Numero }}">
                    </div>
                </div>

                <div class="col-2 d-flex flex-column justify-content-end">
                    <div class="bg-info text-white d-flex justify-content-center align-items-center mx-auto" 
                        style="width: 3rem; height: 3rem; font-weight: bold;">
                        A
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group mb-1">
                        <label for="FechaEmision" class="form-label mb-1" style="font-size: 0.8rem;">FECHA DE EMISION</label>
                        <input type="date" id="FechaEmision" name="FechaEmision" disabled value="{{ $nota_credito_venta->FechaEmision }}"
                            class="form-control form-control-sm py-0">
                    </div>
                </div>

            </div>

            <div class="row mb-2 align-items-end">

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="filtro1" class="form-label mb-1" style="font-size: 0.8rem;">CODIGO CLIENTE</label>
                        <input value="{{ $nota_credito_venta->IdCliente }}" class="form-control form-control-sm py-0" disabled>
                        <input type="hidden" name="IdCliente" value="{{ $nota_credito_venta->IdCliente }}">
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="Numero" class="form-label mb-1" style="font-size: 0.8rem;">NOMBRE</label>
                        <input type="text" id="Numero" name="Numero"
                            value="{{ $nota_credito_venta->RazonSocial }}"
                            class="form-control form-control-sm py-0" disabled>
                    </div>
                </div>

                <div class="col-2"></div>

                    <div class="col-4">

                    <div class="form-group mb-1">
                        <label for="CondicionVenta" class="form-label mb-1" style="font-size: 0.8rem;">FACTURA</label>
                    </div>
                    <div class="input-group mb-1">

                        <input 
                            value="{{ $nota_credito_venta->facturaVenta->NumeroCompleto }}"
                            class="form-control form-control-sm py-0"
                            disabled
                        >

                    </div>

                </div>
            </div>
                
            </div>


        </x-slot>

        <x-slot name="thead"></x-slot>

        <x-slot name="tbody">
            <div class="d-flex justify-content-center py-5">

                <a target="_blank" rel="noopener noreferrer" onclick="setTimeout(() => location.reload(), 500);" href="{{ route('ventas.ficha-del-cliente-nota-credito.pdf', $nota_credito_venta) }}" class="position-relative text-center mx-5" style="cursor: pointer; text-decoration: none; color: inherit;">

                    <div style="
                        position: absolute;
                        top: -10px;
                        left: -10px;
                        background: #007bff;
                        color: white;
                        padding: 6px 10px;
                        border-radius: 50%;
                        font-size: 1.2rem;
                        font-weight: bold;
                        min-width: 40px;
                        text-align: center;
                    ">
                        {{ $nota_credito_venta->CantidadImpresiones }}
                    </div>

                    <img src="{{ asset('AdminLTE-3.2.0/dist/img/impresora.png') }}" style="width: 90px;">
                    <div class="mt-2" style="font-size: 1rem;">Enviar a impresora</div>
                </a>

                <a 
                class="position-relative text-center mx-5"
                data-toggle="modal" 
                data-target="#modal-email"
                style="cursor: pointer; text-decoration: none; color: inherit;">

                    <div style="
                        position: absolute;
                        top: -10px;
                        left: -10px;
                        background: #dc3545;
                        color: white;
                        padding: 6px 10px;
                        border-radius: 50%;
                        font-size: 1.2rem;
                        font-weight: bold;
                        min-width: 40px;
                        text-align: center;
                    ">
                        {{ $nota_credito_venta->CantidadEnviosPorCorreo }}
                    </div>

                    <img src="{{ asset('AdminLTE-3.2.0/dist/img/correo.png') }}" style="width: 90px;">
                    <div class="mt-2" style="font-size: 1rem;">Enviar por correo</div>

                </a>

            </div>

        </x-slot>

    </x-simple-table2>

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
                            @forelse ($nota_credito_venta->cliente->emails as $email)
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
                            // setTimeout(() => location.reload(), 500);

                            const ids = Array.from(
                                document.querySelectorAll('#modal-email input[name=&quot;emails[]&quot;]:checked')
                            ).map(e => e.value);

                            const qs = new URLSearchParams({
                                Emails: ids.join(',')
                            });

                            this.href = '{{ route('ventas.ficha-del-cliente-nota-credito.email', $nota_credito_venta) }}?' + qs.toString();
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

    <div class="container-fluid px-4 py-3">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a class="btn btn-sm btn-primary" href="{{ route('ventas.ficha-del-cliente.show', $nota_credito_venta->IdCliente) }}">
                    <i class="bi bi-x-circle"></i> Salir
                </a>
            </div>
        </div>
    </div>

</x-layout2>