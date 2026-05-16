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
                font-weight: normal;
            }

            .cliente-info {
                font-size: 12px;
                width: 100%;
                margin-top: 0px; /* 🔼 sube la tabla */
            }

            .cliente-info td {
                padding: 2px 4px; /* 🔽 menos espacio vertical */
            }

            .cliente-info .label {
                width: 140px; /* 🔽 controla la distancia exacta */
                white-space: nowrap;
            }

            .tabla-detalle {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .tabla-detalle {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 10px; /* 🔽 letras más chicas */
            }

            .tabla-detalle th {
                background: #d6d6d6; /* gris más suave */
                padding: 5px;
                border: 1px solid #ffffff; /* gris uniforme */
                text-align: center;
            }

            .tabla-detalle td {
                padding: 5px;
                border: 1px solid #ffffff; /* sin contraste blanco */
                text-align: right;
            }

            .tabla-detalle td.descripcion {
                text-align: left;
            }

            .footer-separator {
                width: 100%;
                border-top: 1px solid #000;
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
                margin-bottom: 100px;
            }

            #footer {
                position: fixed;
                bottom: 40px; /* 🔼 sube todo el bloque */
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
                    style="vertical-align: top; text-align: left; padding-top: 0; position: relative; border-right: 0.5px solid #000;">
                    <div style="
                        position: absolute;
                        right: -15px;
                        width: 30px;
                        height: 30px;
                        border: 0.5px solid #000;
                        text-align: center;
                        font-size: 12px;
                        line-height: 20px;
                        background: #fff;
                    ">
                        A
                    </div>
                    <img src="{{ public_path('AdminLTE-3.2.0/dist/img/SRLComprimido.jpg') }}"
                        alt="logo"
                    style="width: 300px; display:block;">

                    <div style="
                        font-size:11px;
                        margin-top: 5px;
                        width: 300px;          /* mismo ancho que el logo */
                        text-align: center;
                        font-weight: bold;
                    ">
                        Ing. Miguel A. Caruana
                    </div>

                    <div style="
                        font-size:10px;
                        margin-top: 15px;
                        width: 300px;
                        text-align: left;
                    ">
                        {{ $configuracion_global->DomicilioEmpresa }}<br>
                        {{ $configuracion_global->LocalidadEmpresa }}, {{ $configuracion_global->ProvinciaEmpresa }}<br>
                        {{ $configuracion_global->TelefonoEmpresa }}<br>
                        IVA Responsable Inscripto
                    </div>

                </td>

                <td class="header-right"
                    style="
                        padding-top: 10px;    /* ↓ MÁS ABAJO */
                        vertical-align: top;
                        text-align: left;        /* ← TODO arranca desde la izquierda */
                        padding-left: 30px;      /* ← separación de la línea vertical */
                        padding-right: 20px;
                    ">

                    <span style="font-size:12px; font-weight:bold;">
                        NOTA DE DEBITO {{ $numero }}
                    </span>
                    <br><br>

                    <table style="width: 100%; font-size:10px;">
                        <tr>
                            <td style="width: 55%; text-align: left;">Fecha:</td>
                            <td style="width: 45%; text-align: left;">
                                {{ \Carbon\Carbon::parse($nota_debito->FechaEmision)->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">Vencimiento:</td>
                            <td style="text-align: left;">
                                {{ \Carbon\Carbon::parse($nota_debito->FechaVencimiento)->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table style="width: 100%; font-size:10px;">
                        <tr>
                            <td style="width: 55%; text-align: left;">C.U.I.T.:</td>
                            <td style="width: 45%; text-align: left;">
                                {{ $configuracion_global->CUITEmpresa }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">Ingresos brutos:</td>
                            <td style="text-align: left;">
                                {{ $configuracion_global->IIBBEmpresa }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">Inicio actividades:</td>
                            <td style="text-align: left;">
                                {{ \Carbon\Carbon::parse($configuracion_global->FechaInicioActividadesEmpresa)->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>

                </td>

            </tr>

            <tr>
                <td colspan="2" style="border-top: 0.5px solid #000;"></td>
            </tr>

        </table>

        <br>

        <table class="cliente-info">
            <tr>
                <td class="label">Razón social:</td>
                <td>{{ $nota_debito->RazonSocial }}</td>
            </tr>
            <tr>
                <td class="label">Dirección:</td>
                <td>{{ $nota_debito->Direccion }}, {{ $nota_debito->Localidad }}</td>
            </tr>
            <tr>
                <td class="label">Categoría IVA:</td>
                <td>{{ $nota_debito->condicionIVA->Nombre ?? "N/A" }}</td>
            </tr>
            <tr>
                <td class="label">DNI:</td>
                <td>
                    {{ $nota_debito->NumeroDocumentoCliente }}

                    <span style="margin-left:100px;">
                        Cbte asco.: {{ $nota_debito->NroFacturaNotaDebito }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="label">Condición de venta:</td>
                <td>{{ $nota_debito->CondicionVenta ?? "N/A" }}</td>
            </tr>
        </table>

        <table class="tabla-detalle">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>% IVA</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items_nota_debito as $item_nota_debito)

                    @php
                        $subtotal = $nota_debito->Neto + $nota_debito->IVA;
                    @endphp

                    <tr>
                        <td style="text-align:left;">{{ $item_nota_debito->id }}</td>
                        <td class="descripcion">{{ $item_nota_debito->Descripcion }}</td>
                        <td>{{ number_format($item_nota_debito->Cantidad, 2, ',', '.') }}</td>
                        <td>{{ number_format($item_nota_debito->PrecioUnitario, 2, ',', '.') }}</td>
                        <td>{{ number_format($item_nota_debito->AlicuotaIVA, 2, ',', '.') }}</td>
                        <td>{{ number_format($item_nota_debito->Neto, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div id="footer">
            <div class="footer-separator"></div>

            <table style="width:100%; margin-top:10px;">
                <tr>
                    
                    @if ($nota_debito->PuntoVenta == 5)
                        <!-- QR IZQUIERDA -->
                        <td style="width:50%; vertical-align: top;">
                            <img src="data:image/png;base64,{{ $qrBase64 }}" style="width: 200px;">
                        </td>
                    @endif

                    <!-- TOTALES DERECHA -->
                    <td style="width:50%; vertical-align: top;">
                        <table class="totales">
                            <tr><td>Exento:</td><td>{{ number_format($nota_debito->Exento, 2, ',', '.') }}</td></tr>
                            <tr><td>No Gravado:</td><td>{{ number_format($nota_debito->NetoNoGravado, 2, ',', '.') }}</td></tr>
                            <tr><td>Neto:</td><td>{{ number_format($nota_debito->Neto, 2, ',', '.') }}</td></tr>
                            <tr><td>IVA:</td><td>{{ number_format($nota_debito->IVA, 2, ',', '.') }}</td></tr>
                            <tr><td>Otros Tributos:</td><td>{{ number_format(0, 2, ',', '.') }}</td></tr>
                            <tr><td><strong>Total:</strong></td>
                                <td><strong>{{ number_format($subtotal, 2, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

    </body>
</html>
