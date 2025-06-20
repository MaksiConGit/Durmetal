<x-layout>
  <x-slot name="title">Producción</x-slot>
  <x-slot name="breadcrumbs">
      <li class="nav-home">
          <a href="#"><i class="fas fa-money-bill-wave"></i></a>
      </li>
      <li class="separator"><i class="icon-arrow-right"></i></li>
      <li class="nav-item"><a href="#">Actualizaciones</a></li>
      <li class="separator"><i class="icon-arrow-right"></i></li>
      <li class="nav-item"><a href="#">Repartir Premios</a></li>
  </x-slot>

  <x-data-table-acordion>
    <x-slot name="table_title">Repartir premios por producciones</x-slot>
    <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
    <x-slot name="create_route">{{ route('repartir-premios.create') }}</x-slot>
    <x-slot name="add_text">Repartir premios</x-slot>

    <x-slot name="head_tr">
      <tr>
        <th>Nombre</th>
        <th>Fecha Desde</th>
        <th>Fecha Hasta</th>
        <th>Premio</th>
        <th>Estado</th>
        <th>Opciones</th>
      </tr>
    </x-slot>

    <x-slot name="body_tr">

        @forelse ($premios as $premio)
            <tr 
                class="toggle-expand" 
                data-id="{{ $premio->id }}"
                style="cursor:pointer;" 
                aria-expanded="false"
            >
                <td>{{ $premio->Nombre }}</td>
                <td>{{ $premio->FechaDesde }}</td>
                <td>{{ $premio->FechaHasta }}</td>
                <td>{{ number_format($premio->Premio, 2, '.', '') }}</td>
                <td>{{ $premio->Estado }}</td>
                <td class="text-start align-middle">
                    <div class="d-flex justify-content-start align-items-center gap-3 ms-2">
                        <a
                            href="{{ route('repartir-premios.edit', $premio) }}"
                            class="btn btn-link btn-primary p-0"
                            data-bs-toggle="tooltip"
                            title="Editar premio"
                        >
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                        <form
                            action="{{ route('repartir-premios.destroy', $premio) }}"
                            method="POST"
                            onsubmit="return confirm('¿Estás seguro de que quieres eliminar este premio?')"
                            class="m-0 p-0"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn btn-link btn-danger p-0"
                                data-bs-toggle="tooltip"
                                title="Eliminar premio"
                            >
                                <i class="fa fa-times fa-lg"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            <tr 
                class="expandable-body" 
                data-for="{{ $premio->id }}" 
                style="display: none;"
            >
                <td colspan="12">

                    <x-card-no-buttons>

                        <x-slot name="body">

                            <x-data-table-no-plus-no-export>

                                <x-slot name="table_title">Factores de {{ $premio->name }}</x-slot>

                                <x-slot name="head_tr">
                                    <tr>
                                        <th>Empleado</th>
                                        <th>Base</th>
                                        <th>Índice Base</th>
                                        <th>Coeficiente</th>
                                        <th>Premio</th>
                                    </tr>
                                </x-slot>

                                <x-slot name="body_tr">

                                    @forelse ($premio->itemsPremio as $item_premio)

                                        <tr>
                                            <td>{{ $item_premio->usuario->name }}</td>
                                            <td>{{ number_format($item_premio->PremioBase, 2, '.', '') }}</td>
                                            <td>{{ number_format($item_premio->IndiceBase, 2, '.', '') }}</td>
                                            <td>{{ number_format($item_premio->Coeficiente, 2, '.', '') }}</td>
                                            <td>{{ number_format($item_premio->Premio, 2, '.', '') }}</td>
                                        </tr>

                                    @empty
                                        <tr><td colspan="11">No se encontraron resultados.</td></tr>
                                    @endforelse

                                </x-slot>

                                <x-slot name="foot_tr">
                                    <tr>
                                        <th>Empleado</th>
                                        <th>Base</th>
                                        <th>Índice Base</th>
                                        <th>Coeficiente</th>
                                        <th>Premio</th>
                                    </tr>
                                </x-slot>
                            </x-data-table-no-plus-no-export>
                        </x-slot>

                    </x-card-no-buttons>
                </td>
            </tr>
        @empty
            <tr><td colspan="11">No se encontraron resultados.</td></tr>
        @endforelse

    </x-slot>

    <x-slot name="foot_tr">
      <tr>
        <th>Nombre</th>
        <th>Fecha Desde</th>
        <th>Fecha Hasta</th>
        <th>Premio</th>
        <th>Estado</th>
        <th>Opciones</th>
      </tr>
    </x-slot>
  </x-data-table-acordion>


  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.toggle-expand').forEach(row => {
        row.addEventListener('click', () => {
          const currentId = row.dataset.id;
          const expanded = row.getAttribute('aria-expanded') === 'true';

          document.querySelectorAll('.toggle-expand').forEach(r => r.setAttribute('aria-expanded', 'false'));
          document.querySelectorAll('.expandable-body').forEach(r => r.style.display = 'none');

          if (!expanded) {
            row.setAttribute('aria-expanded', 'true');
            const target = document.querySelector(`.expandable-body[data-for="${currentId}"]`);
            if (target) target.style.display = 'table-row';
          }
        });
      });
    });
  </script>
</x-layout>
