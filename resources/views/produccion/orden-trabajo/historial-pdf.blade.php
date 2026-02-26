<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    margin: 20px 30px;
}

.tabla-detalle {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 12px;
    margin-bottom: 18px;
    font-size: 11px;
}

.tabla-detalle th {
    background-color: #cfcfcf;
    color: #000;
    padding: 5px;
    border: 1px solid #b5b5b5;
    text-align: center;
    font-weight: bold;
}

.tabla-detalle td {
    padding: 5px;
    border: 1px solid #d5d5d5;
    text-align: center;
}

.tabla-detalle td.descripcion {
    text-align: left;
}

.tabla-azul th {
    background-color: #8db4e2;
    color: #000;
    border: 1px solid #6f9ed6;
}

.bloque-tabla {
    margin-top: 10px;
    margin-bottom: 25px;
}

.cliente-info td {
    padding: 2px 4px;
}

.tabla-programacion th {
    background-color: #e2e2e2;
    color: #000;
    border: 1px solid #cfcfcf;
}

@page {
    margin-bottom: 120px;
}

</style>
</head>

<body>

<table style="width:100%; border-collapse:collapse;">
<tr>
<td style="vertical-align: top; text-align: left; padding-top: 60px;">
<img src="{{ public_path('AdminLTE-3.2.0/dist/img/SRLComprimido.jpg') }}"
style="width: 300px; display:block; margin: 0;">

<div style="font-size:11px; margin-top: 5px; width: 300px; text-align: center; font-weight: bold;">
Ing. Miguel A. Caruana
</div>
</td>

<td style="vertical-align: top; text-align: right; padding-top: 70px; padding-right: 20px;">
<span style="font-size:10px;">
{{ $configuracion_global->DomicilioEmpresa }}
</span><br><br>

<span style="font-size:10px;">
{{ $configuracion_global->LocalidadEmpresa }},
{{ $configuracion_global->ProvinciaEmpresa }}
</span><br><br>

<span style="font-size:10px;">
{{ $configuracion_global->TelefonoEmpresa }}
</span>
</td>
</tr>
</table>

<br><br>

<table class="cliente-info">
<tr>
<td><strong>Fecha:</strong></td>
<td>{{ $orden_trabajo->FechaEmision }}</td>
</tr>
<tr>
<td><strong>Razón Social:</strong></td>
<td>{{ $orden_trabajo->RazonSocial }}</td>
</tr>
<tr>
<td><strong>Órden de trabajo:</strong></td>
<td>{{ $orden_trabajo->NumeroCompleto }}</td>
</tr>
</table>

{{-- =========================
     ITEMS
========================= --}}
@foreach($orden_trabajo->itemsOrdenTrabajo as $item_orden_trabajo)

    {{-- =========================
         SOLO SI HAY PROGRAMACION
    ========================= --}}
    @if($item_orden_trabajo->programacion->count() > 0)

        <div style="margin-top:15px; margin-bottom:5px; font-size:12px;">
        TRABAJO {{ $orden_trabajo->Numero }}/{{ $item_orden_trabajo->ItemNumero }}
        </div>

        {{-- DETALLE --}}
        <div class="bloque-tabla">
        <table class="tabla-detalle">
        <thead>
        <tr>
        <th>Cantidad</th>
        <th>Descripción</th>
        <th>Material</th>
        <th>Trat. térmico</th>
        <th>Dureza MIN</th>
        <th>Dureza MAX</th>
        <th>Dureza tipo</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td>{{ $item_orden_trabajo->Cantidad }}</td>
        <td class="descripcion">{{ $item_orden_trabajo->Descripcion }}</td>
        <td>{{ $item_orden_trabajo->material->Nombre }}</td>
        <td>{{ $item_orden_trabajo->tratamiento->Nombre }}</td>
        <td>{{ $item_orden_trabajo->DurezaSolicitadaMinima }}</td>
        <td>{{ $item_orden_trabajo->DurezaSolicitadaMaxima }}</td>
        <td>{{ $item_orden_trabajo->dureza->Nombre }}</td>
        </tr>
        </tbody>
        </table>
        </div>

        {{-- PROGRAMACION --}}
        <div class="bloque-tabla">
        <table class="tabla-detalle tabla-programacion">
        <thead>
        <tr>
        <th>Programación</th>
        <th>Temp. (°C)</th>
        <th>Tiempo (min)</th>
        <th>Medio enf.</th>
        <th>Horno</th>
        <th>Resultado</th>
        </tr>
        </thead>
        <tbody>

        @php
        $programacionesAgrupadas = $item_orden_trabajo->programacion->groupBy('NumeroProgramacion');
        $contadorPorTipo = [];
        @endphp

        @foreach ($programacionesAgrupadas as $grupo)

        @php
        $primeraProgramacion = $grupo->first();
        $tipoNombre = $primeraProgramacion->tipoProgramacion->Nombre;

        if (!isset($contadorPorTipo[$tipoNombre])) {
            $contadorPorTipo[$tipoNombre] = 1;
        } else {
            $contadorPorTipo[$tipoNombre]++;
        }

        $numeroTipo = $contadorPorTipo[$tipoNombre];
        @endphp

        @foreach ($grupo as $index => $programacion)
        <tr>
        <td class="descripcion">
        {{ $tipoNombre }} {{ $numeroTipo }}{{ $grupo->count() > 1 ? '-' . ($index+1) : '' }}
        </td>
        <td>{{ $programacion->Temperatura }}</td>
        <td>
        {{ \Carbon\Carbon::parse($programacion->FechaCarga)
        ->diffInMinutes(\Carbon\Carbon::parse($programacion->FechaDescarga)) }}
        </td>
        <td>{{ $programacion->medioEnfriamiento->Nombre }}</td>
        <td>{{ $programacion->NumeroHorno }}</td>
        <td>{{ $programacion->DurezaMinima }}-{{ $programacion->DurezaMaxima }}</td>
        </tr>
        @endforeach

        @endforeach

        </tbody>
        </table>
        </div>

    @endif

    {{-- =========================
        RESPONSABLES (SOLO SI HAY CERTIFICADOS)
    ========================= --}}
    @if($item_orden_trabajo->certificados->count() > 0)

    <div style="margin-top:15px; margin-bottom:5px; font-size:12px;">
    RESPONSABLES TECNICOS
    </div>

    @foreach($item_orden_trabajo->certificados as $certificado)

    <div class="bloque-tabla">
    <table class="tabla-detalle tabla-azul">
    <thead>
    <tr>
    <th>N° plano del cliente</th>
    <th>Cantidad</th>
    <th>Responsable</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td class="descripcion">{{ $certificado->Nombre }}</td>
    <td>{{ $certificado->Cantidad }}</td>
    <td class="descripcion">{{ $certificado->usuario->name }}</td>
    </tr>
    </tbody>
    </table>
    </div>

    @endforeach

    @endif

@endforeach

</body>
</html>