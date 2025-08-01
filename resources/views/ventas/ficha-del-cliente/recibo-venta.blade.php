<x-layout>
    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-dollar-sign"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ficha del Cliente</a></li>
    </x-slot>

    <x-form>
        <x-slot name="card_title">Recibo de Venta</x-slot>
        {{-- <x-slot name="action">{{ route('orden-trabajo.update', $orden_trabajo) }}</x-slot> --}}
        <x-slot name="action"></x-slot>
        <x-slot name="method">@method('PUT')</x-slot>
        <x-slot name="inputs">

    <div class="row mb-3 align-items-center">

        <div class="col-md-3">
            <x-form-input-select>
                <x-slot name="label">Punto de Venta</x-slot>
                <x-slot name="name">PuntoVenta</x-slot>
                <x-slot name="option">
                @foreach ($pto_ventas as $pto_venta)
                    <option value="{{$pto_venta->id}}" {{$pto_venta->id == old('PutnoVenta') ? 'selected' : ''}}>{{$pto_venta->Nombre}}</option>                            
                @endforeach
                </x-slot>
                <x-slot name="message">
                    @if ($errors->has('PuntoVenta'))
                        {{ $errors->first('PuntoVenta') }}
                    @elseif (old('PuntoVenta'))
                        Todo correcto
                    @endif
                </x-slot>
                <x-slot name="error">
                    @if ($errors->has('PuntoVenta'))
                        is-invalid
                    @elseif (old('PuntoVenta') && ! $errors->has('PuntoVenta'))
                        is-valid
                    @endif
                </x-slot>
            </x-form-input-select>
        </div>

        <div class="col-md-2">
            <x-form-input-default>
            <x-slot name="label">Número</x-slot>
            <x-slot name="name">Numero</x-slot>
            <x-slot name="placeholder"></x-slot>
            <x-slot name="value">{{old('Numero', $next_numero)}}</x-slot>
            <x-slot name="message">
                @if ($errors->has('Numero'))
                    {{ $errors->first('Numero') }}
                @elseif (old('Numero'))
                    Todo correcto
                @endif
            </x-slot>
            <x-slot name="error">
                @if ($errors->has('Numero'))
                    is-invalid
                @elseif (old('Numero') && ! $errors->has('Numero'))
                    is-valid
                @endif
            </x-slot>
            </x-form-input-default>
        </div>

        <div class="col-md-1 d-flex justify-content-center">
            <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded" 
                style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: 700;">
            X
            </div>
        </div>

        <div class="col-md-3">
            <x-form-input-date>
                <x-slot name="label">Fecha</x-slot>
                <x-slot name="name">FechaEmision</x-slot>
                <x-slot name="value">{{old('FechaEmision', now()->format('Y-m-d'))}}</x-slot>
                <x-slot name="message">
                    @if ($errors->has('FechaEmision'))
                        {{ $errors->first('FechaEmision') }}
                    @elseif (old('FechaEmision'))
                        Todo correcto
                    @endif
                </x-slot>
                <x-slot name="error">
                    @if ($errors->has('FechaEmision'))
                        is-invalid
                    @elseif (old('FechaEmision') && ! $errors->has('FechaEmision'))
                        is-valid
                    @endif
                </x-slot>
            </x-form-input-date>
        </div>

        <div class="col-md-4">
            <x-form-input-default>
                <x-slot name="label">Código Cliente</x-slot>
                <x-slot name="name"></x-slot>
                <x-slot name="placeholder"></x-slot>
                <x-slot name="value">{{ $cliente->id }}</x-slot>
                <x-slot name="message">
                </x-slot>
                <x-slot name="error">
                </x-slot>
            </x-form-input-default>
        </div>

        <div class="col-md-4">
            <x-form-input-default>
                <x-slot name="label">Razón Social</x-slot>
                <x-slot name="name"></x-slot>
                <x-slot name="placeholder"></x-slot>
                <x-slot name="value">{{ $cliente->Nombre }}</x-slot>
                <x-slot name="message">
                </x-slot>
                <x-slot name="error">
                </x-slot>
            </x-form-input-default>
        </div>

        <div class="col-md-4">
            <x-form-input-default>
                <x-slot name="label">Estado</x-slot>
                <x-slot name="name"></x-slot>
                <x-slot name="placeholder"></x-slot>
                <x-slot name="value">PENDIENTE</x-slot>
                <x-slot name="message">
                </x-slot>
                <x-slot name="error">
                </x-slot>
            </x-form-input-default>
        </div>

    </div>

    <x-data-table-no-plus>
        <x-slot name="table_title">Pendientes de Pagar</x-slot>
        <x-slot name="add_text">Añadir Item</x-slot>
        <x-slot name="export_route"></x-slot>
        <x-slot name="head_tr">
            <tr>
                <th></th>
                <th>Fecha</th>
                <th>Venc.</th>
                <th>Número</th>
                <th>Importe</th>
                <th>Pendiente</th>
                <th>A cobrar</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">

            @forelse ($facturas_venta as $factura_venta)
                <tr>
                    <td>
                        <input type="checkbox" name="" id="">
                    </td>
                    <td>{{ $factura_venta->FechaEmision }}</td>
                    <td>{{ $factura_venta->FechaVencimiento }}</td>
                    <td>{{ $factura_venta->Numero }}</td>
                    <td>{{ $factura_venta->Total }}</td>
                    <td>{{ $factura_venta->Total }}</td>
                    <td>{{ $factura_venta->Total }}</td>
                </tr>
            @empty
                <tr><td colspan="11">No se encontraron resultados.</td></tr>
            @endforelse
            <tr>
                <td>Total Imputado</td>
                <td></td>
            </tr>
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th></th>
                <th>Fecha</th>
                <th>Venc.</th>
                <th>Número</th>
                <th>Importe</th>
                <th>Pendiente</th>
                <th>A cobrar</th>
            </tr>
        </x-slot>
    </x-data-table-no-plus>

    <x-panel-horizontal-5>
        <x-slot name="title">Métodos de Pago</x-slot>
        
        <x-slot name="panel1">Efectivo (0)</x-slot>
        <x-slot name="body1">

            <x-data-table-no-plus-no-export>
                <x-slot name="table_title"></x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Importe</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                        @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <td>
                                    <input type="text">
                                </td>
                            </tr>
                        @endfor
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Importe</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus-no-export>

        </x-slot>

        <x-slot name="panel2">Trasferencias (0)</x-slot>
        <x-slot name="body2">

            <x-data-table-no-plus>
                <x-slot name="table_title"></x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Banco</th>
                        <th>Importe</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>
                                <select name="" id="">
                                    @foreach ($bancos as $banco)
                                        <option value="{{$banco->id}}">{{$banco->Nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                    @endfor
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Importe</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>

        </x-slot>

        <x-slot name="panel3">Cheques (0)</x-slot>
        <x-slot name="body3">
            <x-data-table-no-plus>
                <x-slot name="table_title"></x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Banco</th>
                        <th>Número</th>
                        <th>Fecha Emisión</th>
                        <th>Fecha Venc.</th>
                        <th>Plaza</th>
                        <th>E-Check</th>
                        <th>Importe</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>
                                <select name="" id="">
                                    @foreach ($bancos as $banco)
                                        <option value="{{$banco->id}}">{{$banco->Nombre}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="date" name="FechaEmision[]" id="">
                            </td>
                            <td>
                                <input type="date" name="FechaVencimiento[]" id="">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="checkbox" name="" id="">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                    @endfor
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Banco</th>
                        <th>Número</th>
                        <th>Fecha Emisión</th>
                        <th>Fecha Venc.</th>
                        <th>Plaza</th>
                        <th>E-Check</th>
                        <th>Importe</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>

        <x-slot name="panel4">Tarjetas (0)</x-slot>
        <x-slot name="body4">
            <x-data-table-no-plus>
                <x-slot name="table_title"></x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Descripción</th>
                        <th>Importe</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                    @endfor
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Descripción</th>
                        <th>Importe</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>

        <x-slot name="panel5">Retenciones (0)</x-slot>
        <x-slot name="body5">
            <x-data-table-no-plus>
                <x-slot name="table_title"></x-slot>
                <x-slot name="export_route">{{ route('programacion.export') }}</x-slot>
                <x-slot name="add_text">Añadir Item</x-slot>

                <x-slot name="head_tr">
                    <tr>
                        <th>Retención</th>
                        <th>Importe</th>
                    </tr>
                </x-slot>

                <x-slot name="body_tr">
                    <tr>
                        <td>DREI</td>
                        <td>
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>Ganancias</td>
                        <td>
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>IIBB</td>
                        <td>
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>IVA</td>
                        <td>
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td>SUSS</td>
                        <td>
                            <input type="text">
                        </td>
                    </tr>
                </x-slot>

                <x-slot name="foot_tr">
                    <tr>
                        <th>Retención</th>
                        <th>Importe</th>
                    </tr>
                </x-slot>
            </x-data-table-no-plus>
        </x-slot>

    </x-panel-horizontal-5>

    </x-slot>

    <x-slot name="buttons">
        <div class="row mb-3">

            <div class="col-md-8"></div>

            <div class="col-md-4">
                <x-form-input-disabled>
                    <x-slot name="label">Total</x-slot>
                    <x-slot name="name"></x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value"></x-slot>
                    <x-slot name="message"></x-slot>
                    <x-slot name="error"></x-slot>
                </x-form-input-disabled>
                <x-form-input-disabled>
                    <x-slot name="label">Imputado</x-slot>
                    <x-slot name="name"></x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value"></x-slot>
                    <x-slot name="message"></x-slot>
                    <x-slot name="error"></x-slot>
                </x-form-input-disabled>
                <x-form-input-disabled>
                    <x-slot name="label">Remanente</x-slot>
                    <x-slot name="name"></x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value"></x-slot>
                    <x-slot name="message"></x-slot>
                    <x-slot name="error"></x-slot>
                </x-form-input-disabled>
            </div>

        </div>

        <div class="row">
            <div class="col text-end">
            <x-form-button>
                <x-slot name="text">Guardar</x-slot>
                <x-slot name="color">success</x-slot>
            </x-form-button>
            <x-button>
                <x-slot name="text">Cancelar</x-slot>
                <x-slot name="color">danger</x-slot>
                <x-slot name="href">{{ route('index') }}</x-slot>
            </x-button>
            </div>
        </div>
        
    </x-slot>

  </x-form>

    <form id="delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>


    <script>
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este ítem?')) {
                const form = document.getElementById('delete-form');
                form.action = "{{ route('item-orden-trabajo.destroy', ':id') }}".replace(':id', id);
                form.submit();
            }
        }
    </script>

  {{-- <script>
    
    function redirigirConInputs() {
    const ordenTrabajoId = @json($orden_trabajo->id);

    const puntoVenta = document.querySelector('[name="PuntoVenta"]').value;
    const idCliente = document.querySelector('[name="IdCliente"]').value;
    const numero = document.querySelector('[name="Numero"]').value;
    const fechaEmision = document.querySelector('[name="FechaEmision"]').value;
    const numeroRemitoCliente = document.querySelector('[name="NumeroRemitoCliente"]').value;

    const url = new URL(`{{ url('/item-orden-trabajo/create') }}/${ordenTrabajoId}`);
    url.searchParams.append('PuntoVenta', puntoVenta);
    url.searchParams.append('IdCliente', idCliente);
    url.searchParams.append('Numero', numero);
    url.searchParams.append('FechaEmision', fechaEmision);
    url.searchParams.append('NumeroRemitoCliente', numeroRemitoCliente);

    window.location.href = url.toString();
  }
  </script> --}}

</x-layout>