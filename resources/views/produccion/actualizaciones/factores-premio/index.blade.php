<x-layout>

  <x-slot name="title">Produccion</x-slot>
  <x-slot name="breadcrumbs">
      <li class="nav-home">
          <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Actualizaciones</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Factores Premio</a></li>
  </x-slot>
    
    <x-data-table >
      
        <x-slot name="table_title">Factores Premio</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('factores-premio.create') }}</x-slot>
        <x-slot name="add_text">Añadir factor premio</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Nombre</th>
                <th>Valor Predeterminado</th>
                <th>Activo</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($factores_premio as $factor_premio)
                <tr>
                    <td>{{ $factor_premio->Nombre }}</td>
                    <td>{{ number_format($factor_premio->ValorPredeterminado, 2, '.', '') }}</td>
                    <td>{{ $factor_premio->Activo == 1 ? 'Sí' : 'No' }}</td>
                    <td class="text-start align-middle">
                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                            <a
                                href="{{ route('factores-premio.edit', $factor_premio) }}"
                                class="btn btn-link btn-primary p-0"
                                data-bs-toggle="tooltip"
                                title="Editar factor premio"
                            >
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <form
                                action="{{ route('factores-premio.destroy', $factor_premio) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este factor premio?')"
                                class="m-0 p-0"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-link btn-danger p-0"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar factor spremio"
                                >
                                    <i class="fa fa-times fa-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                      
                </tr>
            @empty
                <tr><td colspan="11">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Nombre</th>
                <th>Valor Predeterminado</th>
                <th>Activo</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
    </x-data-table>
  
</x-layout>
