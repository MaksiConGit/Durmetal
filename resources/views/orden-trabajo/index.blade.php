<x-layout>
    <x-slot name="title">Producción</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ingreso de materiales</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Ver Órden de Trabajo</a></li>
    </x-slot>
        <x-data-table >
      
        <x-slot name="table_title">Órden de Trabajo</x-slot>
        <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
        <x-slot name="create_route">{{ route('clients.create') }}</x-slot>
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
                        <div class="d-flex justify-content-center align-items-center gap-3">
                          <a
                            href="{{ route('clients.edit', $items_orden_trabajo) }}"
                            class="btn btn-link btn-primary p-0"
                            data-bs-toggle="tooltip"
                            title="Editar cliente"
                          >
                            <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <form
                            action="{{ route('clients.destroy', $items_orden_trabajo) }}"
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
                              title="Eliminar cliente"
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
</x-layout>