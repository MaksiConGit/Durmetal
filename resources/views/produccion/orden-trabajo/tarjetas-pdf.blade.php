<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>

@page{
    size:10cm 6.2cm;
    margin:0.25cm 0.35cm;
}

body{
    margin:0;
    font-family:"Courier New", monospace;
}

.ticket{
    width:9.3cm;
}

table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

td{
    border:1px solid black;
    padding:4px;
    font-size:15px;
    vertical-align:middle;
    font-weight:bold;
}

.label{
    font-size:9px;
    font-weight:bold;
}

.valor{
    font-weight:bold;
}

.checkbox{
    width:12px;
    height:12px;
    border:2px solid black;
    float:right;
}

.page-break{
    page-break-after:always;
}

.page-break:last-child{
    page-break-after:avoid;
}

</style>

</head>

<body>

@foreach ($orden_trabajo->itemsOrdenTrabajo as $item)

<div class="ticket">

<table>

<tr>
<td>
<div class="label">CLIENTE</div>
<div class="valor">{{ $orden_trabajo->cliente->id }}</div>
</td>

<td></td>

<td colspan="2">
<div class="label">OTI</div>
<div class="valor">
{{ trim(explode('X', $orden_trabajo->NumeroCompleto)[1] ?? '') }}/{{ $item->ItemNumero }}
</div>
</td>
</tr>

<tr>
<td colspan="4">
<b>{{ $item->Cantidad ?? '' }} {{ $item->Descripcion ?? '' }}</b>
</td>
</tr>

<tr>
<td>
<b>
{{ $item->tratamiento->Nombre ?? '' }}<br>
{{ $item->material->Nombre ?? '' }}
</b>
</td>

<td>
<div class="label">DMIN</div>
<b>{{ $item->DurezaSolicitadaMinima ?? 0 }}</b>
</td>

<td>
<div class="label">DMAX</div>
<b>{{ $item->DurezaSolicitadaMaxima ?? 0 }}</b>
</td>

<td>
<div class="label">DTIPO</div>
<b>{{ $item->Dureza->Nombre ?? '' }}</b>
</td>
</tr>

<tr>
<td><b>DT</b></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr>
<td>R1 <span class="checkbox"></span></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr>
<td>R2 <span class="checkbox"></span></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr>
<td>R3 <span class="checkbox"></span></td>
<td></td>
<td></td>
<td></td>
</tr>

</table>

</div>

<div class="page-break"></div>

@endforeach

</body>
</html>