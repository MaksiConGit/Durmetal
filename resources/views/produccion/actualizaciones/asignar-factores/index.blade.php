<x-layout>
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
</x-layout>
