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

                    <img src="{{ public_path('AdminLTE-3.2.0/dist/img/SRLComprimido.jpg') }}"
                        alt="logo"
                    style="width: 300px; display:block; margin-top: 60px;">

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

            </tr>

        </table>

        <br><br>

        <div style="text-align:center; font-size:16px; font-weight:bold;">
            RESUMEN DE CUENTA CORRIENTE
        </div>

        <br>

        <table class="cliente-info">
            <tr>
                <td><strong>Razón social:</strong></td>
                <td>({{ $cliente->id }}) {{ $cliente->Nombre }}</td>
            </tr>
            <tr>
                <td></td>
                <td>{{ $cliente->Domicilio ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>{{ $cliente->localidad->Nombre ?? '' }}</td>
            </tr>
            
            <br>

            <tr>
                <td colspan="2">
                    <strong>Fecha desde - hasta:</strong>
                    {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }}
                    -
                    {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}
                </td>
            </tr>
        </table>

        <table class="tabla-detalle">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Fecha vencimiento</th>
                    <th>Conceptos</th>
                    <th>Debe</th>
                    <th>Haber</th>
                    <th>Saldo</th>
                </tr>
            </thead>

            <tbody>
                @php $saldoActual = $cliente->Saldo; @endphp

                <tr>
                    <td colspan="3" class="descripcion"><strong>SALDO ANTERIOR</strong></td>
                    <td></td>
                    <td>{{ number_format($saldoActual, 2, ',', '.') }}</td>
                    <td>{{ number_format($saldoActual, 2, ',', '.') }}</td>
                </tr>

                @foreach($documentos as $item)
                    @php
                        $doc = $item['documento'];

                        if (in_array($item['tipo'], ['factura', 'debito'])) {
                            $debe = $doc->Total;
                            $haber = '';
                            $saldoActual += $doc->Total;
                        } else {
                            $debe = '';
                            $haber = $doc->Total;
                            $saldoActual -= $doc->Total;
                        }
                    @endphp

                    <tr>
                        <td>{{ \Carbon\Carbon::parse($doc->FechaEmision)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($doc->FechaVencimiento)->format('d/m/Y') }}</td>
                        <td class="descripcion">{{ $doc->NumeroCompleto }}</td>
                        <td>{{ $debe !== '' ? number_format($debe, 2, ',', '.') : '' }}</td>
                        <td>{{ $haber !== '' ? number_format($haber, 2, ',', '.') : '' }}</td>
                        <td>{{ number_format($saldoActual, 2, ',', '.') }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="5" class="descripcion"><strong>Total saldo</strong></td>
                    <td><strong>{{ number_format($saldoActual, 2, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

    </body>
</html>
