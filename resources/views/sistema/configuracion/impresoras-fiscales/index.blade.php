<x-layout>

    <x-slot name="title">Sistema</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-sliders-h"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Actualizaciones</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Impresoras Fiscales</a></li>
    </x-slot>

    <x-data-table >
      
        <x-slot name="table_title">Impresoras Fiscales</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('sistema.configuracion.impresoras-fiscales.create') }}</x-slot>
        <x-slot name="add_text">Añadir Impresora Fiscal</x-slot>
        <x-slot name="head_tr">
            <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Modelo</th>
                <th>Fecha cierre Z</th>
            </tr>
        </x-slot>
        <x-slot name="body_tr">

            @forelse ($impresoras_fiscales as $impresora_fiscal)
                <tr>
                    <td class="text-start align-middle">
                        <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                            <a
                                href="{{ route('sistema.configuracion.impresoras-fiscales.edit', $impresora_fiscal) }}"
                                class="btn btn-link btn-primary p-0"
                                data-bs-toggle="tooltip"
                                title="Editar impresora fiscal"
                            >
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <form
                                action="{{ route('sistema.configuracion.impresoras-fiscales.destroy', $impresora_fiscal) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta impresora fiscal?')"
                                class="m-0 p-0"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-link btn-danger p-0"
                                    data-bs-toggle="tooltip"
                                    title="Eliminar impresora fiscal"
                                >
                                    <i class="fa fa-times fa-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td>{{ $impresora_fiscal->Nombre }}</td>
                    <td>{{ $impresora_fiscal->Modelo }}</td>
                    <td>{{ $impresora_fiscal->FechaUltimoCierreZ }}</td>
                </tr>

            @empty
                <tr><td colspan="4">No se encontraron resultados.</td></tr>
            @endforelse
        </x-slot>
        <x-slot name="foot_tr">
            <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Modelo</th>
                <th>Fecha cierre Z</th>
            </tr>
        </x-slot>
    </x-data-table>

</x-layout>
