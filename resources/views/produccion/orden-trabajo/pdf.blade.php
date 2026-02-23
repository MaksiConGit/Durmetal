<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>
@page {
    size: A5 landscape;
    margin: 20mm;
}

body {
    font-family: "Courier New", Courier, monospace;
    font-size: 16px;
    font-weight: bold;
}

.tabla {
    width: 65%;
    border-collapse: collapse;
}

.tabla td {
    border: 1px solid #000;
    padding: 6px 8px;
    height: 45px;
    vertical-align: middle;
    font-weight: bold;
}

.label {
    font-weight: 400 !important;
    font-size: 12px;
    display: block;
}

.fila-chica td {
    height: 22px;
}

.checkbox {
    width: 14px;
    height: 14px;
    border: 2px solid #000;
    display: inline-block;
    float: right;
    margin-top: 2px;
}

.page-break {
    page-break-after: always;
}

.page-break:last-child {
    page-break-after: avoid;
}

</style>
</head>

<body>

@foreach ($orden_trabajo->itemsOrdenTrabajo as $item)

<table class="tabla">

<tr>
    <td width="25%">
        <span class="label">CLIENTE</span>
        {{ $orden_trabajo->cliente->id }}
    </td>

    <td width="25%"></td>

    <td width="50%" colspan="2">
        <span class="label">OTI</span>
        {{ trim(explode('X', $orden_trabajo->NumeroCompleto)[1] ?? '') }}/{{ $item->ItemNumero }}
    </td>
</tr>

<tr class="fila-chica">
    <td colspan="4">
        {{ $item->Cantidad ?? '' }} {{ $item->Descripcion ?? '' }}
    </td>
</tr>

<tr>
    <td>
        {{ $item->tratamiento->Nombre ?? '' }}<br>
        {{ $item->material->Nombre ?? '' }}
    </td>

    <td>
        <span class="label">DMIN</span>
        {{ $item->DurezaSolicitadaMinima ?? 0 }}
    </td>

    <td>
        <span class="label">DMAX</span>
        {{ $item->DurezaSolicitadaMaxima ?? 0 }}
    </td>

    <td>
        <span class="label">DTIPO</span>
        {{ $item->Dureza->Nombre ?? '' }}
    </td>
</tr>

<tr class="fila-chica">
    <td>DT</td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr class="fila-chica">
    <td>R1 <span class="checkbox"></span></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr class="fila-chica">
    <td>R2 <span class="checkbox"></span></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

<tr class="fila-chica">
    <td>R3 <span class="checkbox"></span></td>
    <td></td>
    <td></td>
    <td></td>
</tr>

</table>

<div class="page-break"></div>

@endforeach

</body>
</html>