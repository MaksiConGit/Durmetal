<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>
@page {
    size: A4 portrait;
    margin: 20mm;
}

body {
    font-family: "Courier New", Courier, monospace;
    font-size: 13px;
    color: #000;
}

.titulo {
    text-align: center;
    font-size: 18px;
    letter-spacing: 3px;
    margin-bottom: 25px;
}

.espacio {
    margin-top: 15px;
}

.subtitulo {
    font-weight: bold;
    margin-bottom: 5px;
}

.tabla-100 {
    width: 100%;
}

.derecha {
    text-align: right;
}

.observaciones {
    height: 50px;
}

.linea-firma {
    border-top: 1px dotted #000;
    width: 300px;
    margin-top: 5px;
}

.firma-contenedor {
    position: fixed;
    bottom: 20mm;
    left: 20mm;
    right: 20mm;
}

.header-factura {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
}

.header-factura .header-right span {
    font-size: 15px;
    font-weight: bold;
}

.header-factura table {
    font-size: 10px;
}

</style>
</head>

<body>
<div class="header-factura">

<table class="header" style="width:100%; border-collapse:collapse;">
    <tr>

        <td style="width: 100%; position: relative; border-right: 0.5px solid #000;">

            <img src="{{ public_path('AdminLTE-3.2.0/dist/img/SRLComprimido.jpg') }}"
                style="width: 400px; display:block;">

            <div style="
                font-size:11px;
                margin-top: 5px;
                width: 400px;
                text-align: center;
                font-weight: bold;
            ">
                Ing. Miguel A. Caruana
            </div>

        <div style="
            position: absolute;
            right: -90px;
            top: 35px;
            width: 280px;
            font-size:10px;
            text-align: left;
            line-height: 1.4;
        ">
            {{ $configuracion_global->DomicilioEmpresa }}<br>
            {{ $configuracion_global->LocalidadEmpresa }}, {{ $configuracion_global->ProvinciaEmpresa }}<br>
            {{ $configuracion_global->TelefonoEmpresa }}<br>
            IVA Responsable Inscripto
        </div>

        </td>

    </tr>
        
    <br>

    <tr>
        <td colspan="2" style="border-top: 0.5px solid #000;"></td>
    </tr>


</table>

</div>

<br>
<br>
<br>

<div class="titulo">
    CERTIFICADO DE TRATAMIENTO TERMICO
</div>

<table class="tabla-100">
    <tr>
        <td>
            Registro de trazabilidad:
            {{ $certificado->itemOrdenTrabajo->ordenTrabajo->NumeroCompleto }}
        </td>
        <td class="derecha">
            {{ \Carbon\Carbon::parse($certificado->Fecha)->format('d/m/Y') }}
        </td>
    </tr>
</table>

<div class="espacio">
    CLIENTE: {{ $certificado->itemOrdenTrabajo->ordenTrabajo->cliente->Nombre }}
</div>

<div class="espacio">
    <div class="subtitulo">DATOS IDENTIFICATORIOS DE LA PIEZA</div>
    Descripción: {{ $certificado->itemOrdenTrabajo->Descripcion }}
</div>


<table class="tabla-100">
    <tr>
        <td width="50%">
            Cantidad: {{ number_format($certificado->Cantidad, 2) }}
        </td>
        <td width="50%">
            Material: {{ $certificado->itemOrdenTrabajo->material->Nombre }}
        </td>
    </tr>
    <tr>
        <td>
            Rto/OC del cliente N°:
        </td>
        <td>
            Plano N°: {{ $certificado->NroPlano }}
        </td>
    </tr>
</table>


TRAT. EFECTUADO:
{{ $certificado->itemOrdenTrabajo->tratamiento->Descripcion }}

<br><br>

<table class="tabla-100">
    <tr>
        <td width="60%" valign="top">
            <div class="subtitulo">PROP.MECANICAS SOLICITADAS</div>
            Mínimo: 432.00<br>
            Máximo: 4243.00<br>
            Dureza Tipo: HRF
        </td>

        <td width="40%" valign="top">
            <div class="subtitulo derecha">RESULTADOS OBTENIDOS</div>
            <div class="derecha">
                Mínimo: 0.00<br>
                Máximo: 0.00<br>
                Promedio: 0.00
            </div>
        </td>
    </tr>
</table>

<br>

<div class="subtitulo">OBSERVACIONES</div>
<div class="observaciones"></div>

<table class="tabla-100">
    <tr>
        <td width="50%">
            Responsable técnico:
            {{ $certificado->responsableTecnico->Nombre ?? 'Caruana Miguel Angel' }}
        </td>

<td width="40%" style="text-align:center;">
    
    <div style="
        border-top:1px dotted #000;
        width:250px;
        margin:0 auto 5px auto;
    "></div>

    Firma responsable técnico

</td>

    </tr>
</table>

</body>
</html>
