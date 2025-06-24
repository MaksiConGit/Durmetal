<x-layout>

  <x-slot name="title">Produccion</x-slot>
  <x-slot name="breadcrumbs">
      <li class="nav-home">
          <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Actualizaciones</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Tratamientos</a></li>
  </x-slot>
    
    <x-data-table >
      
        <x-slot name="table_title">Tratamientos</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('tratamientos.create') }}</x-slot>
        <x-slot name="add_text">Añadir tratamiento</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Predeterminado</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($tratamientos as $tratamiento)
                <tr>
                    <td>{{ $tratamiento->Nombre }}</td>
                    <td>{{ $tratamiento->Descripcion }}</td>
                    <td><input type="checkbox" name="" id="" disabled {{ $tratamiento->Predeterminado == 1 ? 'checked' : '' }}></td>
                    <td class="text-start align-middle">
                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                            <a
                                href="{{ route('tratamientos.edit', $tratamiento) }}"
                                class="btn btn-link btn-primary p-0"
                                data-bs-toggle="tooltip"
                                title="Editar tratamiento"
                            >
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <form
                                action="{{ route('tratamientos.destroy', $tratamiento) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta tratamiento?')"
                                class="m-0 p-0"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-link btn-danger p-0"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar tratamiento"
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
                <th>Descripción</th>
                <th>Predeterminado</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
    </x-data-table>
  
</x-layout>
