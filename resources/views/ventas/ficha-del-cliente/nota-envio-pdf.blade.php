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
                    style="vertical-align: top; text-align: left; padding-top: 0; position: relative;">

                    <img src="{{ public_path('AdminLTE-3.2.0/dist/img/DurmetalComprimido.png') }}"
                        alt="logo"
                        style="width: 300px; display:block; margin: 0;">

                    <div style="
                        font-size:11px;
                        position: relative;
                        top: -55px;             /* Sube el texto sobre el logo */
                        left: 50%;              /* Punto de referencia */
                        transform: translateX(-50%);  /* Lo centra respecto al logo */
                        font-weight: bold;
                        width: max-content;
                        text-align: center;
                    ">
                        Ing. Miguel A. Grauana
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
                        NOTA DE ENVÍO
                    </span><br><br>

                    <span style="font-size:15px;">
                        Comp. Nro: {{ $numero }}
                    </span><br><br>

                    <span style="font-size:10px; font-weight:normal;">
                        {{ \Carbon\Carbon::parse($nota_envio->FechaEmision)->format('d/m/Y') }}
                    </span><br><br>

                    <span style="font-size:10px; font-weight:normal;">
                        PÁGINA 1/1
                    </span>

                </td>

            </tr>

        </table>

        <br><br>

        <table class="cliente-info">
            <tr>
                <td><strong>Cliente Nº:</strong></td>
                <td>{{ $nota_envio->IdCliente }}</td>

                <td><strong>Razón Social:</strong></td>
                <td>{{ $nota_envio->RazonSocial }}</td>
            </tr>
            <tr>
                <td><strong>Dirección:</strong></td>
                <td colspan="3">{{ $nota_envio->Direccion }}</td>
            </tr>
            <tr>
                <td><strong>Cond. IVA:</strong></td>
                <td>{{ $nota_envio->cliente->condicionIVA->Nombre }}</td>

                <td><strong>CUIT:</strong></td>
                <td>{{ $nota_envio->NumeroDocumentoCliente }}</td>
            </tr>
        </table>

        <table class="tabla-detalle">
            <thead>
                <tr>
                    <th>CANT.</th>
                    <th>DESCRIPCIÓN</th>
                    <th>PESO</th>
                    <th>PRECIO U.</th>
                    <th>% DESC.</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items_nota_envio as $item_nota_envio)
                    <tr>
                        <td>{{ number_format($item_nota_envio->Cantidad, 2, ',', '.') }}</td>
                        <td class="descripcion">{{ $item_nota_envio->Descripcion }}</td>
                        <td>{{ number_format($item_nota_envio->Peso, 2, ',', '.') }}</td>
                        <td>{{ number_format($item_nota_envio->PrecioUnitario, 2, ',', '.') }}</td>
                        <td>{{ number_format($item_nota_envio->PorcentajeDescuento, 2, ',', '.') }}</td>
                        <td>{{ number_format($item_nota_envio->Total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="footer">
            <div class="footer-separator"></div>

            <div class="pagina">
                PÁGINA 1/1
            </div>

            <table class="totales" style="float:right;">
                <tr><td>Subtotal:</td><td>{{ number_format($nota_envio->Neto, 2, ',', '.') }}</td></tr>
                <tr><td>Descuento %:</td><td>{{ number_format($nota_envio->PorcentajeDescuento, 2, ',', '.') }}</td></tr>
                <tr><td>Neto:</td><td>{{ number_format($nota_envio->Neto, 2, ',', '.') }}</td></tr>
                <tr><td>IVA:</td><td>{{ number_format($nota_envio->IVA, 2, ',', '.') }}</td></tr>
                <tr><td><strong>Importe:</strong></td>
                    <td><strong>{{ number_format($nota_envio->Total, 2, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

    </body>
</html>
