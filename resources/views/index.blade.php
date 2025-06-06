<x-layout>
    <x-slot name="title">Tableros</x-slot>
    <x-slot name="breadcrumbs">
        <li class="nav-home">
            <a href="#"><i class="fas fa-layer-group"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Hornos</a></li>
    </x-slot>

    <style>
        h1, h2, h3, h4, h5, h6 {
            font-size: 1.5rem;
        }

        .horno-card {
            border: 2px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            height: 310px;
            position: relative;
        }

        .horno-header {
            background-color: #343a40;
            color: white;
            padding: 0.5rem 1rem;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .horno-title {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .cuadro-gris {
            width: 70px;
            height: 70px;
            background-color: #dee2e6;
            border: 2px solid #adb5bd;
            border-radius: 6px;
        }

        .tabla-wrapper {
            overflow-y: auto;
            max-height: 140px;
        }

        .tabla-horno {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .tabla-horno th:nth-child(1),
        .tabla-horno td:nth-child(1) {
            width: 60px;
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
            overflow: hidden;
        }

        .tabla-horno th:nth-child(2),
        .tabla-horno td:nth-child(2) {
            width: 90px;
            text-align: center;
            vertical-align: middle;
        }

        .tabla-horno th:nth-child(3),
        .tabla-horno td:nth-child(3) {
            width: 150px;
            text-align: center;
            vertical-align: middle;
        }

        .tabla-horno th:nth-child(4),
        .tabla-horno td:nth-child(4) {
            width: 90px;
            white-space: nowrap;
            overflow: hidden;
            vertical-align: middle;
            text-align: center;
        }

        .tabla-horno th:nth-child(5),
        .tabla-horno td:nth-child(5) {
            white-space: nowrap;
            overflow: hidden;
            vertical-align: middle;
            text-align: center;
        }

        .tabla-horno th {
            font-size: 0.7rem !important;
            padding: 0.25rem 0.4rem !important;
            text-align: center;
            vertical-align: middle;
        }

        .tabla-horno td {
            font-size: 0.7rem;
            padding: 0.25rem 0.4rem;
            text-align: center;
            vertical-align: middle;
        }

        .progreso-fino {
            height: 8px;
            margin-top: 0.5rem;
        }

        .card-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .reload-icon {
            position: absolute;
            bottom: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 1.2rem;
            color: #6c757d;
        }

        .d-flex.flex-grow-1.position-relative > .d-flex {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <div class="container mt-4">
        <div class="row g-4">
            @for ($i = 1; $i <= 6; $i++)
                <div class="col-md-6">
                    <div class="horno-card">
                        <div class="horno-header">
                            <div class="horno-title">H{{ $i }}</div>
                            @if ($i === 2)
                                <div class="text-end">
                                    <small class="text-white-50">RF</small>
                                    <span class="fw-bold ms-2">850º</span>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            @if ($i === 2)
                                <div class="progress progreso-fino mb-3">
                                    <div class="progress-bar bg-success" style="width: 20%;"></div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small>05/06/2025 13:35</small>
                                    <button class="btn btn-warning btn-sm rounded-circle">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <small>13/06/2025 00:00</small>
                                </div>

                                <div class="tabla-wrapper">
                                    <table class="table table-bordered tabla-horno">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th>CLI</th>
                                                <th>OTI</th>
                                                <th>Desc.</th>
                                                <th>MAT</th>
                                                <th>PROG</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td>27</td>
                                                <td>64215/1</td>
                                                <td>98.00 BULON M14</td>
                                                <td>SAE 4140</td>
                                                <td>TEMPLADO</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>64217/1</td>
                                                <td>72.00 BULON</td>
                                                <td>SAE 4140</td>
                                                <td>TEMPLADOooooooooo</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>64217/1</td>
                                                <td>72.00 BULON</td>
                                                <td>SAE 4140</td>
                                                <td>TEMPLADO</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>64217/1</td>
                                                <td>72.00 BULON</td>
                                                <td>SAE 4140</td>
                                                <td>TEMPLADO</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="d-flex flex-grow-1 position-relative">
                                    <div class="d-flex justify-content-center align-items-center flex-grow-1">
                                        <div class="cuadro-gris"></div>
                                    </div>
                                    <i class="fas fa-sync-alt reload-icon"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</x-layout>
