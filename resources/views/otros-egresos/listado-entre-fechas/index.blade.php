{{-- <x-layout>

    <x-slot name="title">Otros Egresos</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Listado de Otros Egresos entre Fechas</a></li>            
    </x-slot>


</x-layout> --}}

<x-layout2>
    <x-slot name="title">Listado entre Fechas</x-slot>

    @livewire('listado-entre-fechas2')

</x-layout2>
