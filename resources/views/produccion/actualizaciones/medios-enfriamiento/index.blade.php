<x-layout>

  <x-slot name="title">Produccion</x-slot>
  <x-slot name="breadcrumbs">
      <li class="nav-home">
          <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Actualizaciones</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Medios de Enfriamiento</a></li>
  </x-slot>
    
    <x-data-table >
      
        <x-slot name="table_title">Medios de Enfriamiento</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('medios-enfriamiento.create') }}</x-slot>
        <x-slot name="add_text">Añadir medio enfriamiento</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Nombre</th>
                <th>Predeterminado</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">
    
            @forelse ($medios_enfriamiento as $medio_enfriamiento)
                <tr>
                    <td>{{ $medio_enfriamiento->Nombre }}</td>
                    <td><input type="checkbox" name="" id="" disabled {{ $medio_enfriamiento->Predeterminado == 1 ? 'checked' : 'N' }}></td>
                    <td class="text-start align-middle">
                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                            <a
                                href="{{ route('medios-enfriamiento.edit', $medio_enfriamiento) }}"
                                class="btn btn-link btn-primary p-0"
                                data-bs-toggle="tooltip"
                                title="Editar medio enfriamiento"
                            >
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <form
                                action="{{ route('medios-enfriamiento.destroy', $medio_enfriamiento) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este medio de enfriamiento?')"
                                class="m-0 p-0"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-link btn-danger p-0"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar medio enfriamiento"
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
                <th>Predeterminado</th>
                <th>Opciones</th>
            </tr>
        </x-slot>
    </x-data-table>
  
</x-layout>
