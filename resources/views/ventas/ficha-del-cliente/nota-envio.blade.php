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
        <x-slot name="card_title">Nota de Envío</x-slot>
        <x-slot name="action">{{ route('ventas.ficha-del-cliente-nota-envio.store', $cliente) }}</x-slot>
        <x-slot name="method"></x-slot>
        <x-slot name="inputs">

    <div class="row mb-3 align-items-center">

        <div class="col-md-3">
                <input type="hidden" name="IdCliente" value="{{$cliente->id}}">
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

        <div class="col-md-3">
            <x-form-input-default>
            <x-slot name="label">Número</x-slot>
            <x-slot name="name">Numero</x-slot>
            <x-slot name="placeholder"></x-slot>
            <x-slot name="value">{{old('Numero', $next_nota_numero)}}</x-slot>
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
            NE
            </div>
        </div>

        <div class="col-md-3">
            <x-form-input-date>
                <x-slot name="label">Fecha de Emisión</x-slot>
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
                <x-slot name="label">Nombre</x-slot>
                <x-slot name="name"></x-slot>
                <x-slot name="placeholder"></x-slot>
                <x-slot name="value">{{ $cliente->Nombre }}</x-slot>
                <x-slot name="message">
                </x-slot>
                <x-slot name="error">
                </x-slot>
            </x-form-input-default>
        </div>

    </div>

    <x-data-table-no-plus>
        <x-slot name="table_title">Items Órden de Trabajo</x-slot>
        <x-slot name="add_text">Añadir Item</x-slot>
        <x-slot name="export_route"></x-slot>
        <x-slot name="head_tr">
            <tr>
                <th></th>
                <th>N°</th>
                <th>CC</th>
                <th>% DESC.</th>
                <th>Fecha</th>
                <th>OTI</th>
                <th></th>
                <th>Material</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>Trat.</th>
                <th>Precio U.</th>
                <th></th>
                <th>Total</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">

            @forelse ($items_orden_trabajo as $item_orden_trabajo)
                <tr>
                    <td>
                        <input type="checkbox" name="" id="">
                    </td>
                    <td></td>
                    <td>
                        <input type="text">
                    </td>
                    <td>
                        <input type="text">
                    </td>
                    <td>{{ $item_orden_trabajo->ordenTrabajo->FechaEmision }}</td>
                    <td>{{ $item_orden_trabajo->ordenTrabajo->NumeroCompleto }} {{ $item_orden_trabajo->ItemNumero }}</td>
                    <td>
                        <a
                            href="{{ route('item-orden-trabajo.edit', $item_orden_trabajo->id) }}"
                            class="btn btn-link btn-primary p-0"
                            data-bs-toggle="tooltip"
                            title="Editar ítem"
                        >
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                    </td>
                    <td>{{ $item_orden_trabajo->material->Nombre }}</td>
                    <td>{{ $item_orden_trabajo->Descripcion }}</td>
                    <td>{{ $item_orden_trabajo->Estado }}</td>
                    <td>{{ $item_orden_trabajo->Cantidad }}</td>
                    <td>{{ $item_orden_trabajo->Peso }}</td>
                    <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
                    <td></td>
                    <td>
                        <a
                            href="{{ route('item-orden-trabajo.edit', $item_orden_trabajo->id) }}"
                            class="btn btn-link btn-primary p-0"
                            data-bs-toggle="tooltip"
                            title="Editar código complejidad"
                        >
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                    </td>
                    <td></td>
                </tr>
            @empty
                <tr><td colspan="11">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th></th>
                <th>N°</th>
                <th>CC</th>
                <th>% DESC.</th>
                <th>Fecha</th>
                <th>OTI</th>
                <th></th>
                <th>Material</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Cant.</th>
                <th>Peso</th>
                <th>Trat.</th>
                <th>Precio U.</th>
                <th></th>
                <th>Total</th>
            </tr>
        </x-slot>
    </x-data-table-no-plus>

    </x-slot>

    <x-slot name="buttons">
        <div class="row mb-3">

            <div class="col-md-5">
                <x-form-input-disabled>
                    <x-slot name="label">SubTotal</x-slot>
                    <x-slot name="name"></x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value"></x-slot>
                    <x-slot name="message"></x-slot>
                    <x-slot name="error"></x-slot>
                </x-form-input-disabled>
                <x-form-input-disabled>
                    <x-slot name="label">% Descuento</x-slot>
                    <x-slot name="name"></x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value"></x-slot>
                    <x-slot name="message"></x-slot>
                    <x-slot name="error"></x-slot>
                </x-form-input-disabled>
                <x-form-input-disabled>
                    <x-slot name="label">Base Imponible</x-slot>
                    <x-slot name="name"></x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value"></x-slot>
                    <x-slot name="message"></x-slot>
                    <x-slot name="error"></x-slot>
                </x-form-input-disabled>
            </div>

            <div class="col-md-5">

                <x-form-input-disabled>
                    <x-slot name="label">IVA</x-slot>
                    <x-slot name="name"></x-slot>
                    <x-slot name="placeholder"></x-slot>
                    <x-slot name="value"></x-slot>
                    <x-slot name="message"></x-slot>
                    <x-slot name="error"></x-slot>
                </x-form-input-disabled>
                <x-form-input-disabled>
                    <x-slot name="label">Total</x-slot>
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