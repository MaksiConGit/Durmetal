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


    <div class="d-flex gap-4 justify-content-center my-4 text-center">
        <h2>Orden creada exitosamente</h2>
    </div>

    <div class="d-flex flex-column flex-md-row gap-4 justify-content-center align-items-center my-4 text-center">
        <a href="" class="btn btn-primary btn-lg px-4 py-3 mb-2" style="min-width: 240px;">
            <i class="fas fa-print fa-2x d-block mb-2"></i>
            <span class="fs-5">Enviar a Impresora</span>
        </a>

        <a href="" class="btn btn-warning btn-lg px-4 py-3 mb-2" style="min-width: 240px;">
            <i class="fas fa-envelope fa-2x d-block mb-2"></i>
            <span class="fs-5">Enviar por Correo</span>
        </a>
    </div>


</x-layout>