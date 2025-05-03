<x-layout>
    
    <x-slot name="title">Ventas</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-money-bill-wave"></i></a>
          </li>
          <li class="separator"><i class="icon-arrow-right"></i></li>
          <li class="nav-item"><a href="#">Clientes</a></li>
          <li class="separator"><i class="icon-arrow-right"></i></li>
          <li class="nav-item"><a href="#">Ver clientes</a></li>
    </x-slot>

    <div class="container mt-4">
        <div class="row g-4">
            @for ($i = 1; $i <= 6; $i++)
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <div class="card-title">H{{ $i }}</div>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div style="width: 80px; height: 80px; background-color: #f0f0f0; border: 1px solid #ccc;"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</x-layout>
