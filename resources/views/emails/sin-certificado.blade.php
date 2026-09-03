<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado de Tratamiento Térmico</title>
</head>
<body style="
    font-family: Arial, Helvetica, sans-serif;
    color: #000;
    background-color: #ffffff;
    margin: 0;
    padding: 0;
">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0">

                <!-- CUERPO -->
                <tr>
                    <td style="padding: 10px 0;">
                        <p style="margin: 0 0 15px 0;">Sr/res</p>

                        <p style="margin: 0 0 15px 0;">{{ $item->ordenTrabajo->cliente->Nombre }}</p>

                        <p style="margin: 0 0 15px 0;">
                            Enviamos en archivo adjunto el certificado de tratamiento térmico correspondiente a:
                        </p>

                        <p style="margin: 0 0 15px 0;">
                            OT {{ $item->ordenTrabajo->Numero }}/{{ $item->ItemNumero }}
                        </p>

                        <p style="margin: 0 0 20px 0;">
                            {{ number_format($cantidad ?? $item->Cantidad, 2, ',', '.') }}
                            &nbsp;
                            {{ $item->Descripcion ?? '' }}
                            &nbsp;
                            {{ $item->material->Nombre ?? '' }}
                        </p>

                        <p style="color: red; font-weight: bold; margin: 0 0 20px 0;">
                            Por favor no responder a esta casilla de correo.
                        </p>

                        <p style="margin: 0 0 10px 0;">
                            Gracias por confiar en nosotros.
                        </p>

                        <p style="margin: 0 0 20px 0;">
                            Un cordial saludo.
                        </p>

                        <p style="margin: 0;">
                            Producción <strong>Durmetal</strong>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
