<x-layout>

  <x-slot name="title">Produccion</x-slot>
  <x-slot name="breadcrumbs">
      <li class="nav-home">
          <a href="#"><i class="fas fa-money-bill-wave"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Actualizaciones</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Código de Complejidad</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Editar código de complejidad</a></li>
  </x-slot>

    <x-form>
        <x-slot name="card_title">Modificando Código de Complejidad: "{{$precio->CC}}"</x-slot>
        <x-slot name="action">{{ route('precios.store') }}</x-slot>
        <x-slot name="method"></x-slot>

        <x-slot name="inputs">

            @livewire('editar-codigo-complejidad', ['codigo_complejidad' => $precio, 'tratamiento' => $precio->tratamiento])

        </x-slot>
        <x-slot name="buttons">
            <div class="col text-end">
                <x-form-button>
                    <x-slot name="text">Guardar</x-slot>
                    <x-slot name="color">success</x-slot>
                </x-form-button>
                <x-button>
                    <x-slot name="text">Cancelar</x-slot>
                    <x-slot name="color">danger</x-slot>
                    <x-slot name="href">{{ route('tratamientos.edit', $precio->tratamiento) }}</x-slot>
                </x-button>
            </div>
        </x-slot>
    </x-form>
</x-layout>