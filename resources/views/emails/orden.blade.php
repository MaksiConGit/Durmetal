<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ORDEN DE TRABAJO 0001-00064263</title>
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
                        <p style="margin: 0 0 15px 0;">Estimado cliente {{ $orden_trabajo->cliente->Nombre }},</p>

                        {{-- <p style="margin: 0 0 15px 0;">{{ $certificado->itemOrdenTrabajo->ordenTrabajo->cliente->Nombre }}</p> --}}

                        <p style="margin: 0 0 15px 0;">
                            Enviamos la <strong>Orden de Trabajo {{ $orden_trabajo->NumeroCompleto }}</strong> en el archivo adjunto. 
                        </p>

                        <p style="margin: 0 0 15px 0;">Gracias por confiar en nosotros</p>
                        
                        <p style="margin: 0 0 15px 0;">Saludos cordiales.</p>

                        <p style="margin: 0 0 15px 0;">Administracion Durmetal</p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
