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
                        RECIBO
                    </span><br><br>

                    <span style="font-size:15px;">
                        Comp. Nro: {{ $recibo_venta->NumeroCompleto }}
                    </span><br><br>

                    <span style="font-size:10px; font-weight:normal;">
                        {{ \Carbon\Carbon::parse($recibo_venta->FechaEmision)->format('d/m/Y') }}
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
                <td>{{ $recibo_venta->IdCliente }}</td>

                <td><strong>Razón Social:</strong></td>
                <td>{{ $recibo_venta->RazonSocial }}</td>
            </tr>
            <tr>
                <td><strong>Dirección:</strong></td>
                <td colspan="3">{{ $recibo_venta->Direccion }}</td>
            </tr>
            <tr>
                <td><strong>Cond. IVA:</strong></td>
                <td>{{ $recibo_venta->cliente->condicionIVA->Nombre }}</td>

                <td><strong>CUIT:</strong></td>
                <td>{{ $recibo_venta->NumeroDocumentoCliente }}</td>
            </tr>
        </table>

        <table class="tabla-detalle">
            <thead>
                <tr>
                    <th>DESCRIPCIÓN</th>
                    <th>IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items_recibo_venta as $item_recibo_venta)
                    <tr>
                        <td class="descripcion">{{ $item_recibo_venta->Descripcion }}</td>
                        <td>{{ number_format($item_recibo_venta->Total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="descripcion">Importe a favor del cliente</td>
                    <td>{{ number_format(($recibo_venta->Total - $items_recibo_venta->sum('Total')), 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <br>
        <p>DETALLE DE PAGO</p>

        <table class="tabla-detalle">
            <thead>
                <tr>
                    <th>TIPO</th>
                    <th>DESCRIPCION</th>
                    <th>IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>

        <div id="footer">
            <div class="footer-separator"></div>

            <div class="pagina">
                PÁGINA 1/1
            </div>

            <table class="totales" style="float:right;">
                <tr><td>Retenciones:</td><td>{{ number_format(($recibo_venta->RetencionDREI + $recibo_venta->RetencionIIBB + $recibo_venta->RetencionIVA + $recibo_venta->RetencionGanancias + $recibo_venta->RetencionSUSS), 2, ',', '.') }}</td></tr>
                <tr><td>Importe:</td><td>{{ number_format($recibo_venta->Total, 2, ',', '.') }}</td></tr>
            </table>
        </div>

    </body>
</html>
