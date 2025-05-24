<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-cogs"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ingreso de materiales</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Editar Órden de Trabajo</a></li>
    </x-slot>
    <x-form>
        <x-slot name="card_title">Órden de Trabajo</x-slot>
        <x-slot name="action">{{ route('orden-trabajo.update', $orden_trabajo) }}</x-slot>
        <x-slot name="method">@method('PUT')</x-slot>
        <x-slot name="inputs">

          <div class="col-md-4 mb-3">
            <x-form-input-select>
                <x-slot name="label">Punto de Venta</x-slot>
                <x-slot name="name">PuntoVenta</x-slot>
                <x-slot name="option">
                    @foreach ($pto_ventas as $pto_venta)
                        <option value="{{$pto_venta->id}}" {{$pto_venta->id == $orden_trabajo->PuntoVenta ? 'selected' : ''}}>{{$pto_venta->Nombre}}</option>                            
                    @endforeach
                </x-slot>
                <x-slot name="message">
                    @error('PuntoVenta')
                        {{$message}}
                    @enderror
                </x-slot>
                <x-slot name="error">
                    @if ($errors->has('PuntoVenta'))
                        is-invalid
                    @elseif (old('PuntoVenta') && ! $errors->has('PuntoVenta'))
                        is-valid
                    @endif
                </x-slot>
            </x-form-input-select>

            @include('components.form-input-select2', [
                'name' => 'IdCliente',
                'label' => 'Cliente',
                'route' => route('clientes.buscar'),
                'placeholder' => 'Selecciona un cliente',
                'selected' => $clienteSeleccionado ?? null
            ])

          </div>

          <div class="col-md-4 mb-3">

              <x-form-input-default>
                  <x-slot name="label">Número</x-slot>
                  <x-slot name="name">Numero</x-slot>
                  <x-slot name="placeholder"></x-slot>
                  <x-slot name="value">{{old('Numero', $orden_trabajo->Numero)}}</x-slot>
                  <x-slot name="message">
                      @error('Numero')
                          {{$message}}
                      @enderror
                  </x-slot>
                  <x-slot name="error">
                      @if ($errors->has('Numero'))
                          is-invalid
                      @elseif (old('Numero') && ! $errors->has('Numero'))
                          is-valid
                      @endif
                  </x-slot>
              </x-form-input-default>

              <x-form-input-date>
                <x-slot name="label">Fecha de Emisión</x-slot>
                <x-slot name="name">FechaEmision</x-slot>
                <x-slot name="value">{{ now()->toDateString() }}</x-slot>
            </x-form-input-date>

          </div>

            <div class="col-md-4 mb-3">
                <x-form-input-default>
                <x-slot name="label">N° Remito Cliente</x-slot>
                <x-slot name="name">NumeroRemitoCliente</x-slot>
                <x-slot name="placeholder"></x-slot>
                <x-slot name="value">{{old('NumeroRemitoCliente', $orden_trabajo->NumeroRemitoCliente)}}</x-slot>
                <x-slot name="message">
                    @error('NumeroRemitoCliente')
                        {{$message}}
                    @enderror
                </x-slot>
                <x-slot name="error">
                    @if ($errors->has('NumeroRemitoCliente'))
                        is-invalid
                    @elseif (old('NumeroRemitoCliente') && ! $errors->has('NumeroRemitoCliente'))
                        is-valid
                    @endif
                </x-slot>
                </x-form-input-default>
            </div>

          <x-data-table>
            <x-slot name="table_title">Items Órden de Trabajo</x-slot>
            <x-slot name="export_route">{{ route('orden-trabajo.export', $orden_trabajo->id) }}</x-slot>
            <x-slot name="create_route">{{ route('item-orden-trabajo.create', $orden_trabajo) }}</x-slot>
            <x-slot name="add_text">Añadir Item</x-slot>
            <x-slot name="head_tr">
                <tr>
                    <th>Descripción</th>
                    <th>Material</th>
                    <th>Cant.</th>
                    <th>Peso</th>
                    <th>Trat.</th>
                    <th>Dureza</th>
                    <th>DSMIN</th>
                    <th>DSMAX</th>
                    <th>Opciones</th>
                </tr>
            </x-slot>
            <x-slot name="body_tr">
        
                @forelse ($items_orden_trabajo as $items_orden_trabajo)
                    <tr>
                        <td>{{ $items_orden_trabajo->Descripcion }}</td>
                        <td>{{ $items_orden_trabajo->material->Nombre }}</td>
                        <td>{{ $items_orden_trabajo->Cantidad }}</td>
                        <td>{{ $items_orden_trabajo->Peso }}</td>
                        <td>{{ $items_orden_trabajo->tratamiento->Nombre }}</td>
                        <td>{{ $items_orden_trabajo->dureza->Nombre }}</td>
                        <td>{{ $items_orden_trabajo->DurezaSolicitadaMinima }}</td>
                        <td>{{ $items_orden_trabajo->DurezaSolicitadaMaxima }}</td>
                        <td class="text-center align-middle">
                            <div class="d-flex align-items-center gap-3 ms-3">
                              <a
                                href="{{ route('item-orden-trabajo.edit', $items_orden_trabajo) }}"
                                class="btn btn-link btn-primary p-0"
                                data-bs-toggle="tooltip"
                                title="Editar item"
                              >
                                <i class="fa fa-edit fa-lg"></i>
                              </a>
                              {{-- <form
                                action="{{ route('item-orden-trabajo.destroy', $items_orden_trabajo) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este cliente?')"
                                class="m-0 p-0"
                              >
                                @csrf
                                @method('DELETE')
                                <button
                                  type="submit"
                                  class="btn btn-link btn-danger p-0"
                                  data-bs-toggle="tooltip"
                                  title="Eliminar item"
                                >
                                  <i class="fa fa-times fa-lg"></i>
                                </button>
                              </form> --}}
                            </div>
                          </td>
                          
                    </tr>
                @empty
                    <tr><td colspan="11">No se encontraron resultados.</td></tr>
                @endforelse
            </x-slot>
            <x-slot name="foot_tr">
                <tr>
                    <th>Descripción</th>
                    <th>Material</th>
                    <th>Cant.</th>
                    <th>Peso</th>
                    <th>Trat.</th>
                    <th>Dureza</th>
                    <th>DSMIN</th>
                    <th>DSMAX</th>
                    <th>Opciones</th>
                </tr>
            </x-slot>
        </x-data-table>

    </x-slot>
    <x-slot name="buttons">
        <x-form-button>
            <x-slot name="text">Aceptar</x-slot>
            <x-slot name="color">success</x-slot>
        </x-form-button>
        <x-button>
            <x-slot name="text">Cancelar</x-slot>
            <x-slot name="color">danger</x-slot>
            <x-slot name="href">{{ route('index') }}</x-slot>
        </x-button>
    </x-slot>
  </x-form>

</x-layout>