<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Venta</title>
</head>
<body style="margin:0; padding:0; background-color:#ffffff; font-family: Arial, Helvetica, sans-serif; color:#000000;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left" style="padding:40px 50px;">
                
                <p style="margin:0 0 24px 0; font-size:20px; line-height:1.6;">
                    Sr./Sres.
                </p>

                <p style="margin:0 0 24px 0; font-size:20px; line-height:1.6;">
                    {{ $nombre }}
                </p>

                <p style="margin:0 0 30px 0; font-size:22px; line-height:1.7;">
                    Enviamos en archivo adjunto el <strong>Recibo {{ $numero }}</strong>
                </p>

                <p style="margin:0 0 30px 0; font-size:20px; line-height:1.6;">
                    Saludos cordiales,
                </p>

                <p style="margin:0; font-size:20px; line-height:1.6;">
                    <strong>Administración Durmetal</strong>
                </p>

            </td>
        </tr>
    </table>
</body>
</html>
