<x-layout2>
    <x-slot name="title">Asignar factores a empleados</x-slot>

    <x-data-table-acordion2>
        <x-slot name="thead">
            <tr class="bg-secondary text-white">
                <th>USUARIO</th>
                <th>NOMBRE</th>
                <th>INDICE BASE</th>
                <th>PROMEDIO</th>
            </tr>
        </x-slot>

        <x-slot name="tbody">

            @forelse ($empleados as $usuario)
            
                @livewire('factores-premio-form', ['factoresPremioUsuario' => $usuario->factoresPremioUsuario, 'factoresPremio' => $factores_premio, 'usuario' => $usuario])

                {{-- <tr 
                    style="cursor: pointer;"
                    wire:click="selectAndExpand({{ $premio->id }})"
                    class="{{ $selectedItem == $premio->id ? 'table-primary' : '' }}"
                    aria-expanded="{{ in_array($premio->id, $expanded) ? 'true' : 'false' }}"
                >
                    <td>{{ $premio->Nombre }}</td>
                    <td>{{ $premio->FechaDesde }}</td>
                    <td>{{ $premio->FechaHasta }}</td>
                    <td>{{ number_format($premio->Premio, 2, '.', '') }}</td>
                    <td>{{ $premio->Estado }}</td>
                </tr>

                <tr class="expandable-body" style="display: {{ in_array($premio->id, $expanded) ? 'table-row' : 'none' }};">
                    <td colspan="15">
                        <div class="p-0">
                        <table class="table table-sm table-bordered mb-0">
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>EMPLEADO</th>
                                <th>BASE</th>
                                <th>INDICE BASE</th>
                                <th>COEFICIENTE</th>
                                <th>PREMIO</th>
                            </tr>
                            </thead>
                            <tbody>

                                @php
                                    $itemsPremio = $premio->itemsPremio;
                                    $itemsPremioCount = $premio->itemsPremio->count();
                                @endphp

                                @foreach ($itemsPremio as $item_premio)
                                    <tr>
                                        <td>{{ $item_premio->usuario->name }}</td>
                                        <td>{{ number_format($item_premio->PremioBase, 2, '.', '') }}</td>
                                        <td>{{ number_format($item_premio->IndiceBase, 2, '.', '') }}</td>
                                        <td>{{ number_format($item_premio->Coeficiente, 2, '.', '') }}</td>
                                        <td>{{ number_format($item_premio->Premio, 2, '.', '') }}</td>
                                    </tr>
                                @endforeach

                                @for ($i = $itemsPremioCount; $i < 6; $i++)
                                    <tr>
                                        <td colspan="15">&nbsp;</td>
                                    </tr>
                                @endfor

                            </tbody>
                        </table>
                        </div>
                    </td>

                </tr> --}}

            @endforeach
            
            @php
                $filasFaltantes = max(0, 11 - count($empleados));
            @endphp

            @for ($i = 0; $i < $filasFaltantes; $i++)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endfor

        </x-slot>
    </x-data-table-acordion2>
</x-layout2>

{{-- <x-layout>
  <x-slot name="title">Producción</x-slot>
  <x-slot name="breadcrumbs">
      <li class="nav-home">
          <a href="#"><i class="fas fa-money-bill-wave"></i></a>
      </li>
      <li class="separator"><i class="icon-arrow-right"></i></li>
      <li class="nav-item"><a href="#">Actualizaciones</a></li>
      <li class="separator"><i class="icon-arrow-right"></i></li>
      <li class="nav-item"><a href="#">Asignar Factores Premio</a></li>
  </x-slot>

  <x-data-table-no-plus-acordion>
    <x-slot name="table_title">Asignar factores a empleado</x-slot>
    <x-slot name="export_route">{{ route('clients.export') }}</x-slot>
    <x-slot name="create_route">{{ route('clients.create') }}</x-slot>
    <x-slot name="add_text">Añadir factor premio</x-slot>

    <x-slot name="head_tr">
      <tr>
        <th>Usuario</th>
        <th>Nombre</th>
        <th>Índice Base</th>
        <th>Promedio</th>
      </tr>
    </x-slot>

    <x-slot name="body_tr">
      @forelse ($empleados as $usuario)

        @livewire('factores-premio-form', ['factoresPremioUsuario' => $usuario->factoresPremioUsuario, 'factoresPremio' => $factores_premio, 'usuario' => $usuario])

      @empty

        <tr><td colspan="11">No se encontraron resultados.</td></tr>

      @endforelse
    </x-slot>

    <x-slot name="foot_tr">
      <tr>
        <th>Usuario</th>
        <th>Nombre</th>
        <th>Índice Base</th>
        <th>Promedio</th>
      </tr>
    </x-slot>
  </x-data-table-no-plus-acordion>


  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.toggle-expand').forEach(row => {
        row.addEventListener('click', () => {
          const currentId = row.dataset.id;
          const expanded = row.getAttribute('aria-expanded') === 'true';

          // Cierra todas
          document.querySelectorAll('.toggle-expand').forEach(r => r.setAttribute('aria-expanded', 'false'));
          document.querySelectorAll('.expandable-body').forEach(r => r.style.display = 'none');

          // Si estaba cerrada, la abre
          if (!expanded) {
            row.setAttribute('aria-expanded', 'true');
            const target = document.querySelector(`.expandable-body[data-for="${currentId}"]`);
            if (target) target.style.display = 'table-row';
          }
        });
      });
    });
  </script>
</x-layout> --}}
