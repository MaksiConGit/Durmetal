<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>
@page {
    size: A5 portrait;
    margin: 15mm;
}

body {
    font-family: "Courier New", Courier, monospace;
    font-size: 12px;
    color: #000;
    margin: 0;
}

.titulo {
    text-align: center;
    font-size: 17px;
    letter-spacing: 2px;
    margin-bottom: 18px;
}

.espacio {
    margin-top: 10px;
}

.subtitulo {
    font-weight: bold;
    margin-bottom: 4px;
}

.tabla-100 {
    width: 100%;
    border-collapse: collapse;
}

.derecha {
    text-align: right;
}

.header-factura {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
}

.header-factura table {
    font-size: 10px;
}

.header-logo {
    width: 350px;
    display: block;
}

.header-nombre {
    font-size: 10px;
    margin-top: 4px;
    width: 350px;
    text-align: center;
    font-weight: bold;
}

.observaciones {
    margin-top: 3px;
}

.firma {
    height: 120px;
    margin-bottom: 3px;
}

.linea-firma {
    border-top: 1px dotted #000;
    width: 220px;
    margin: 0 auto 4px auto;
}

.seccion {
    margin-top: 10px;
}

.tabla-100 td {
    padding: 2px 0;
}

.firma-contenedor {
    position: fixed;
    bottom: 10mm;
    left: 0;
    right: 0;
}

</style>
</head>

<body>

<div class="header-factura">
    
<table style="width:100%; border-collapse:collapse;">
    <tr>
        <td style="width:100%; text-align:center;">

            <img
                src="{{ public_path('AdminLTE-3.2.0/dist/img/SRLComprimido.jpg') }}"
                class="header-logo"
                style="display:block; margin:0 auto;"
            >

            <div style="
                width:100%;
                text-align:center;
                font-size:10px;
                margin-top:4px;
                font-weight:bold;
            ">
                Ing. Miguel A. Caruana
            </div>

        </td>
    </tr>
<br>

    <tr>
        <td style="border-top:0.5px solid #000;"></td>
    </tr>
    
</table>

</div>


<div style="margin-top:18px;"></div>


<div class="titulo">
    CERTIFICADO DE TRATAMIENTO TERMICO
</div>

<br>

<table class="tabla-100">
    <tr>
        <td>
            Registro de trazabilidad:
            {{ $item->ordenTrabajo->NumeroCompleto }}
        </td>

        <td class="derecha">
            {{ \Carbon\Carbon::parse($item->FechaCreacion)->format('d/m/Y') }}
        </td>
    </tr>
</table>


<div class="seccion">
    CLIENTE:
    {{ $item->ordenTrabajo->cliente->Nombre }}
</div>

<br>

<div class="seccion">

    <div class="subtitulo">
        DATOS IDENTIFICATORIOS DE LA PIEZA
    </div>

    Descripción:
    {{ $item->Descripcion }}

</div>


<table class="tabla-100">
    <tr>
        <td width="50%">
            Cantidad:
            {{ number_format($cantidad ?? $item->Cantidad, 2) }}
        </td>

        <td width="50%">
            Material:
            {{ $item->material->Nombre }}
        </td>
    </tr>

    <tr>
        <td>
            Rto/OC del cliente N°:
        </td>
    </tr>
</table>


<div class="seccion">

    TRAT. EFECTUADO:
    {{ $item->tratamiento->Descripcion }}

</div>

<br>

<table class="tabla-100" style="margin-top:10px;">
    <tr>

        <td width="60%" valign="top">

            <div class="subtitulo">
                PROP.MECANICAS SOLICITADAS
            </div>

            Mínimo:
            {{ number_format($item->DurezaSolicitadaMinima, 2) }}
            <br>

            Máximo:
            {{ number_format($item->DurezaSolicitadaMaxima, 2) }}
            <br>

            Dureza Tipo:
            {{ $item->Dureza->Nombre }}

        </td>

        <td width="40%" valign="top">

            <div class="subtitulo derecha">
                RESULTADOS OBTENIDOS
            </div>

            <div class="derecha">

                @php
                    $prog = $item->programacion->last();
                    $min = $prog->DurezaMinima ?? 0;
                    $max = $prog->DurezaMaxima ?? 0;
                    $promedio = ($min + $max) / 2;
                @endphp

                Mínimo:
                {{ number_format($min, 2) }}
                <br>

                Máximo:
                {{ number_format($max, 2) }}
                <br>

                Promedio:
                {{ number_format($promedio, 2) }}

            </div>

        </td>

    </tr>
</table>

<br>

<div class="seccion">

    <div class="subtitulo">
        OBSERVACIONES
    </div>

    <div class="observaciones">
        {{ $observaciones }}
    </div>

</div>


<div class="firma-contenedor">

    <table class="tabla-100">
        <tr>

            <td width="50%" style="vertical-align: bottom;">

                Responsable técnico:
                {{ $usuario->Nombre }}

            </td>

            <td width="50%" style="text-align:center;">

                @if($usuario && $usuario->Firma)

                    <img
                        src="{{ public_path($usuario->Firma) }}"
                        class="firma"
                    >

                @endif

                <div class="linea-firma"></div>

                Firma responsable técnico

            </td>

        </tr>
    </table>

</div>

</body>
</html>