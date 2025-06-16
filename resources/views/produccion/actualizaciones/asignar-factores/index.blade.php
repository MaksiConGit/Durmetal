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

        @php
          $usuario_factores_premio = $usuario->factoresPremioUsuario;
          $valor_total = 0;
        @endphp

        @foreach ($factores_premio as $index => $factor_premio)

          <input type="hidden" name="IdFactores[{{$index}}]" id="" value="{{$factor_premio->id}}">

          @php
            $tiene_factor = false;
            $valor = $factor_premio->ValorPredeterminado;
          @endphp

          @foreach ($usuario_factores_premio as $usuario_factor_premio)

              @if ($factor_premio->id == $usuario_factor_premio->IdFactorPremio)

                  @php
                      $tiene_factor = true;
                      $valor = $usuario_factor_premio->Valor;
                      $valor_total = $valor_total + $valor;
                  @endphp

              @endif

          @endforeach

        @endforeach

        @php
            $promedio = count($usuario_factores_premio) ? $valor_total / count($usuario_factores_premio) : 0;
        @endphp

        <tr class="toggle-expand" data-id="{{ $usuario->id }}" aria-expanded="false">
          <td>{{ $usuario->email }}</td>
          <td>{{ $usuario->name }}</td>
          <td>{{ number_format($usuario->IndiceBasePremio, 2, '.', '') }}</td>
          <td>{{ number_format($promedio, 2, '.', '') }}</td>
          <td></td>
        </tr>
        <tr class="expandable-body" data-for="{{ $usuario->id }}" style="display: none;">
          <td colspan="12" class="asd">

            <form action="{{ route('asignar-factores.update', $usuario) }}" method="POST">

              @csrf
              @method('PUT')

              <x-card>

                  <x-slot name="body">

                      <x-data-table-no-plus-no-export>
                          <x-slot name="table_title">Factores de {{ $usuario->name }}</x-slot>

                          <x-slot name="head_tr">
                              <tr>
                              <th></th>
                              <th>Factor</th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th>Valor</th>
                              </tr>
                          </x-slot>

                          <x-slot name="body_tr">

                              @php
                                $usuario_factores_premio = $usuario->factoresPremioUsuario;
                                $valor_total = 0;
                              @endphp

                              @foreach ($factores_premio as $index => $factor_premio)

                                <input type="hidden" name="IdFactores[{{$index}}]" id="" value="{{$factor_premio->id}}">

                                @php
                                  $tiene_factor = false;
                                  $valor = $factor_premio->ValorPredeterminado;
                                @endphp

                                @foreach ($usuario_factores_premio as $usuario_factor_premio)

                                    @if ($factor_premio->id == $usuario_factor_premio->IdFactorPremio)

                                        @php
                                            $tiene_factor = true;
                                            $valor = $usuario_factor_premio->Valor;
                                            $valor_total = $valor_total + $valor;
                                        @endphp

                                    @endif

                                @endforeach

                                @php
                                  $promedio = count($usuario_factores_premio) ? $valor_total / count($usuario_factores_premio) : 0;
                                @endphp

                                <tr>
                                    <td>
                                      <input type="hidden" name="FactorActivo[{{$index}}]" id="" value="0">
                                      <input type="checkbox" name="FactorActivo[{{$index}}]" id="" value="1" {{ $tiene_factor == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $factor_premio->Nombre }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      <input type="text" name="ValorFactor[{{$index}}]" id="" value="{{ number_format($valor, 2, '.', '') }}">
                                    </td>
                                </tr>

                              @endforeach

                          </x-slot>

                          <x-slot name="foot_tr">
                              <tr>
                              <th></th>
                              <th>Factor</th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th>Valor</th>
                              </tr>
                          </x-slot>
                      </x-data-table-no-plus-no-export>

                  </x-slot>

                  <x-slot name="buttons">

                      <div class="row mb-3">
                          <div class="col-md-3">
                              <x-form-input-default>
                                  <x-slot name="label">Índice Base</x-slot>
                                  <x-slot name="name">IndiceBasePremio[{{$usuario->id}}]</x-slot>
                                  <x-slot name="placeholder"></x-slot>
                                  <x-slot name="value">{{ number_format($usuario->IndiceBasePremio, 2, '.', '') }}</x-slot>
                                  <x-slot name="message">
                                      @if ($errors->has('IndiceBasePremio'))
                                          {{ $errors->first('IndiceBasePremio') }}
                                      @elseif (old('IndiceBasePremio'))
                                          Todo correcto
                                      @endif
                                  </x-slot>
                                  <x-slot name="error">
                                      @if ($errors->has('IndiceBasePremio'))
                                          is-invalid
                                      @elseif (old('IndiceBasePremio') && ! $errors->has('IndiceBasePremio'))
                                          is-valid
                                      @endif
                                  </x-slot>
                              </x-form-input-default>
                          </div>

                          <div class="col-md-6"></div>

                          <div class="col-md-3 text-end">
                              <x-form-input-disabled>
                                  <x-slot name="label">Promedio</x-slot>
                                  <x-slot name="name"></x-slot>
                                  <x-slot name="placeholder"></x-slot>
                                  <x-slot name="value">{{ number_format($promedio, 2, '.', '') }}</x-slot>
                                  <x-slot name="message"></x-slot>
                                  <x-slot name="error"></x-slot>
                              </x-form-input-disabled>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col text-end">
                              <x-form-button>
                                  <x-slot name="text">Aceptar</x-slot>
                                  <x-slot name="color">success</x-slot>
                              </x-form-button>
                              <x-button>
                                  <x-slot name="text">Cancelar</x-slot>
                                  <x-slot name="color">danger</x-slot>
                                  <x-slot name="href">{{ route('durezas.index') }}</x-slot>
                              </x-button>
                          </div>
                      </div>

                  </x-slot>

              </x-card>

            </form>

          </td>
        </tr>
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

  <style>
    .table-condensed td,
    .table-condensed th {
      padding: 0.6rem 0.75rem;
      font-size: 1rem;
      white-space: nowrap;
    }

    .table-container {
      font-size: 1rem;
    }

    @media (max-width: 768px) {
      .btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
      }

      .btn-primary {
        font-size: 0.875rem;
        padding: 0.4rem 0.8rem;
      }

      .d-flex {
        gap: 0.5rem;
      }

      .table-condensed td,
      .table-condensed th {
        padding: 0.4rem 0.5rem;
        font-size: 0.9rem;
      }
    }
  </style>

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
