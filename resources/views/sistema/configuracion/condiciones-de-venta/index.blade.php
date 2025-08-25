<x-layout>

    <x-slot name="title">Sistema</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-sliders-h"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Configuración</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Condiciones de Venta</a></li>
    </x-slot>

    <x-data-table >
      
        <x-slot name="table_title">Condiciones de Venta</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('sistema.configuracion.condiciones-de-venta.create') }}</x-slot>
        <x-slot name="add_text">Añadir Condición de Venta</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Seleccionado</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">

            @forelse ($condiciones_venta as $condicion_venta)
                <tr>
                    <td class="text-start align-middle">
                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                            <a
                                href="{{ route('sistema.configuracion.condiciones-de-venta.edit', $condicion_venta) }}"
                                class="btn btn-link btn-primary p-0"
                                data-bs-toggle="tooltip"
                                title="Editar condición de venta"
                            >
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <form
                                action="{{ route('sistema.configuracion.condiciones-de-venta.destroy', $condicion_venta) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta condición de venta?')"
                                class="m-0 p-0"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-link btn-danger p-0"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar condición de venta"
                                >
                                    <i class="fa fa-times fa-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td>{{ $condicion_venta->Nombre }}</td>
                    <td><input type="checkbox" name="" id="" disabled {{ $condicion_venta->Seleccionado == 1 ? 'checked' : '' }}></td>
                </tr>

            @empty
                <tr><td colspan="3">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Seleccionado</th>
            </tr>
        </x-slot>
    </x-data-table>

</x-layout>
