<x-layout2>

    <x-slot name="title">Crear Recibo de Venta</x-slot>

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
                            value="{{ $recibo_venta->Numero }}"
                            class="form-control form-control-sm py-0" disabled>
                        <input type="hidden" name="Numero" value="{{ $recibo_venta->Numero }}">
                    </div>
                </div>

                <div class="col-2 d-flex flex-column justify-content-end">
                    <div class="bg-info text-white d-flex justify-content-center align-items-center mx-auto" 
                        style="width: 3rem; height: 3rem; font-weight: bold;">
                        A
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="FechaEmision" class="form-label mb-1" style="font-size: 0.8rem;">FECHA DE EMISION</label>
                        <input type="date" id="FechaEmision" name="FechaEmision" disabled
                            value="{{ $recibo_venta->FechaEmision }}"
                            class="form-control form-control-sm py-0">
                    </div>
                </div>

                <div class="col-2">

                    <div class="form-group mb-1">
                        <label for="FechaVencimiento" class="form-label mb-1" style="font-size: 0.8rem;">FECHA DE VENCIMIENTO</label>
                    </div>
                    <div class="input-group mb-1">
                        <input type="date" id="FechaVencimiento" name="FechaVencimiento" disabled
                            value="{{ $recibo_venta->FechaVencimiento }}"
                            class="form-control form-control-sm py-0">
                        <div class="input-group-append">
                            <button type="button" 
                                    class="btn btn-sidebar btn-sm bg-orange">
                                <i class="fas fa-pencil fa-fw text-white"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>

            <div class="row mb-2 align-items-end">

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="filtro1" class="form-label mb-1" style="font-size: 0.8rem;">CODIGO CLIENTE</label>
                        <input value="{{ $recibo_venta->IdCliente }}" class="form-control form-control-sm py-0" disabled>
                        <input type="hidden" name="IdCliente" value="{{ $recibo_venta->IdCliente }}">
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-group mb-1">
                        <label for="Numero" class="form-label mb-1" style="font-size: 0.8rem;">NOMBRE</label>
                        <input type="text" id="Numero" name="Numero"
                            value="{{ $recibo_venta->RazonSocial }}"
                            class="form-control form-control-sm py-0" disabled>
                    </div>
                </div>

                <div class="col-2"></div>

                <div class="col-2">
                    <div class="form-check">
                        <input id="saldo0" type="checkbox" class="form-check-input" disabled>
                        <label for="saldo0" class="form-check-label">GENERAR RECIBO CON PAGO EN EFECTIVO</label>
                    </div>
                </div>

                <div class="col-4">

                    <div class="form-group mb-1">
                        <label for="CondicionVenta" class="form-label mb-1" style="font-size: 0.8rem;">CONDICION DE VENTA</label>
                    </div>
                    <div class="input-group mb-1">

                    <input 
                        value="{{ $recibo_venta->CondicionVenta }}"
                        class="form-control form-control-sm py-0"
                        disabled
                    >

                    {{-- <input 
                        type="hidden"
                        name="CondicionVenta"
                        value="{{ implode(' / ', $condicionesSeleccionadas ?? []) }}"
                    > --}}
                        
                        <div class="input-group-append">
                            <button type="button"
                                    class="btn btn-sidebar btn-sm bg-orange">
                                <i class="fas fa-pencil fa-fw text-white"></i>
                            </button>
                        </div>

                    </div>

                </div>

            </div>
                
            </div>


        </x-slot>

        <x-slot name="thead"></x-slot>

        <x-slot name="tbody">
            <div class="d-flex justify-content-center py-5">

                <a target="_blank" rel="noopener noreferrer" onclick="setTimeout(() => location.reload(), 500);" href="{{ route('ventas.ficha-del-cliente-factura-venta.pdf', $recibo_venta) }}" class="position-relative text-center mx-5" style="cursor: pointer; text-decoration: none; color: inherit;">

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
                        {{ $recibo_venta->CantidadImpresiones }}
                    </div>

                    <img src="{{ asset('AdminLTE-3.2.0/dist/img/impresora.png') }}" style="width: 90px;">
                    <div class="mt-2" style="font-size: 1rem;">Enviar a impresora</div>
                </a>

                <div class="position-relative text-center mx-5" style="cursor: pointer;" onclick="alert('Enviar por correo')">

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
                        {{ $recibo_venta->CantidadEnviosPorCorreo }}
                    </div>

                    <img src="{{ asset('AdminLTE-3.2.0/dist/img/correo.png') }}" style="width: 90px;">
                    <div class="mt-2" style="font-size: 1rem;">Enviar por correo</div>
                </div>

            </div>

        </x-slot>

    </x-simple-table2>

    <div class="container-fluid px-4 py-3">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a class="btn btn-sm btn-primary" href="{{ route('ventas.ficha-del-cliente.show', $recibo_venta->IdCliente) }}">
                    <i class="bi bi-x-circle"></i> Salir
                </a>
            </div>
        </div>
    </div>

</x-layout2>