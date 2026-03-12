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

            .header {
                width: 100%;
            }

            .header-left img {
                width: 160px;
            }

            .header-right {
                text-align: right;
                font-size: 14px;
                font-weight: bold;
            }

            .cliente-info td {
                padding: 2px 4px;
            }

            .tabla-detalle {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .tabla-detalle th {
                background: #ddd;
                padding: 6px;
                border: 1px solid #999;
                text-align: center;
            }

            .tabla-detalle td {
                padding: 6px;
                border: 1px solid #ccc;
                text-align: right;
            }

            .tabla-detalle td.descripcion {
                text-align: left;
            }

            .footer-separator {
                width: 100%;
                border-top: 1px solid #000;
                margin-top: 40px;
                margin-bottom: 10px;
            }

            .totales {
                width: 250px;
                float: right;
                font-size: 12px;
            }

            .totales td {
                padding: 2px 4px;
            }

            .pagina {
                text-align: center;
                margin-top: 10px;
                font-size: 11px;
            }



    @page {
        margin-bottom: 120px; /* espacio reservado para el footer */
    }

    #footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 110px;
    }

        </style>
    </head>
    <body>
        <table class="header" style="width:100%; border-collapse:collapse;">
            <tr>

                <td class="header-left" 
                style="
                    vertical-align: top;
                    text-align: left;
                    padding-top: 60px;   /* ↓ BAJA logo + texto */
                    position: relative;
                ">

                    <img src="{{ public_path('AdminLTE-3.2.0/dist/img/SRLComprimido.jpg') }}"
                        alt="logo"
                        style="width: 300px; display:block; margin: 0;">

                        <div style="
                            font-size:11px;
                            margin-top: 5px;
                            width: 300px;          /* mismo ancho que el logo */
                            text-align: center;
                            font-weight: bold;
                        ">
                            Ing. Miguel A. Caruana
                        </div>

                </td>

                <td class="header-right"
                    style="
                        vertical-align: top;
                        text-align: right;
                        padding-top: 70px;    /* ↓ MÁS ABAJO */
                        padding-right: 20px;  /* ← MÁS A LA IZQUIERDA */
                    ">

                    <span style="font-size:15px; font-weight:bold;">
                        NOTA DE CREDITO {{ $numero }}
                    </span><br><br>

                    <span style="font-size:10px; font-weight:normal;">
                        Fecha: {{ \Carbon\Carbon::parse($nota_credito->FechaEmision)->format('d/m/Y') }}
                    </span><br>

                    <span style="font-size:10px; font-weight:normal;">
                        Vencimiento: {{ \Carbon\Carbon::parse($nota_credito->FechaVencimiento)->format('d/m/Y') }}
                    </span><br><br>


                    <span style="font-size:10px; font-weight:normal;">
                        C.U.I.T.: {{ $configuracion_global->CUITEmpresa }}
                    </span><br>
                    <span style="font-size:10px; font-weight:normal;">
                        Ingresos brutos: {{ $configuracion_global->IIBBEmpresa }}
                    </span><br>
                    <span style="font-size:10px">
                        Inicio actividades: {{ \Carbon\Carbon::parse($configuracion_global->FechaInicioActividadesEmpresa)->format('d/m/Y') }}
                    </span><br>


                </td>

            </tr>

        </table>

        <br><br>

        <table class="cliente-info">
            <tr>
                <td colspan="3"><span style="font-size:14px">Razón social:</span></td>
                <td><span style="font-size:14px">{{ $nota_credito->RazonSocial }}</span></td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-size:14px">Dirección:</span></td>
                <td><span style="font-size:14px">{{ $nota_credito->Direccion }}, {{ $nota_credito->Localidad }}</span></td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-size:14px">Categoría IVA:</span></td>
                <td><span style="font-size:14px">{{ $nota_credito->condicionIVA->Nombre ?? "N/A" }}</span></td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-size:14px">DNI:</span></td>
                <td><span style="font-size:14px">{{ $nota_credito->NumeroDocumentoCliente }}</span></td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-size:14px">Cbte asoc.:</span></td>
                <td><span style="font-size:14px">{{ $nota_credito->facturaVenta->NumeroCompleto }}</span></td>
            </tr>
        </table>

        <table class="tabla-detalle">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items_nota_credito as $item_nota_credito)
                    <tr>
                        <td>{{ $item_nota_credito->IdArticulo }}</td>
                        <td class="descripcion">{{ $item_nota_credito->Descripcion }}</td>
                        <td>{{ number_format($item_nota_credito->Cantidad, 2, ',', '.') }}</td>
                        <td>{{ number_format($item_nota_credito->PrecioUnitario, 2, ',', '.') }}</td>
                        <td>{{ number_format($item_nota_credito->Total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="footer">
            <div class="footer-separator"></div>

            @php
                $subtotal = $nota_credito->Total;

                $esExento = $cliente->condicionIVA->Nombre === 'Exento';

                $ivaPorcentaje = $esExento ? 0 : 0.21;
                $ivaTotal = $subtotal * $ivaPorcentaje;
                $totalFinal = $subtotal + $ivaTotal;
            @endphp


            <table class="totales" style="float:right;">
                <tr><td>Exento:</td><td>{{ number_format($nota_credito->Exento, 2, ',', '.') }}</td></tr>
                <tr><td>No Gravado:</td><td>{{ number_format($nota_credito->NetoNoGravado, 2, ',', '.') }}</td></tr>
                <tr><td>Neto:</td><td>{{ number_format($nota_credito->Neto, 2, ',', '.') }}</td></tr>
                <tr><td>IVA:</td><td>{{ number_format($nota_credito->IVA, 2, ',', '.') }}</td></tr>
                <tr><td>Otros Tributos:</td><td>{{ number_format(0, 2, ',', '.') }}</td></tr>
                <tr><td><strong>Total:</strong></td>
                    <td><strong>{{ number_format($nota_credito->Total, 2, ',', '.') }}</strong></td>
                </tr>
            </table>

        </div>

    </body>
</html>
