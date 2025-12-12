<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #000; line-height: 1.6;">

    <h2 style="margin-bottom: 5px; font-weight: bold;">
        FACTURA {{ $numero }}
    </h2>

    <p>Estimado cliente</p>

    <p style="font-weight: bold; font-size: 17px;">
        {{ $factura->cliente->Nombre ?? 'Cliente' }},
    </p>

    <p>
        Enviamos en archivo adjunto la 
        <strong>Factura Número {{ $numero }}</strong>  
        y su respectiva nota de envío con el detalle de los trabajos realizados.
    </p>

    <p>Solicitamos nos den la confirmación de recibido.</p>

    <p style="background:#d7f37b; padding:4px;">
        <strong>Los pagos deberán efectuarse mediante transferencia, echeq y cheques entregados en Durmetal.</strong>
    </p>

    <p style="background:#d7f37b; padding:4px;">
        <strong>Al hacer el pago, por favor háganos llegar el comprobante escaneado por mail en forma legible, en formato PDF.
        No hacerlo por favor en formato JPG (foto), ni por Whatsapp.</strong>
    </p>

    <p style="background:#d7f37b; padding:4px;">
        <strong>CONDICIONES DE PAGO: COMO ESTÁ ESTABLECIDO EN LA FACTURA.<br>
        Pagos fuera de término serán sujetos a Nota de Débito.</strong>
    </p>

    <p style="background:#d7f37b; padding:4px;">
        <strong>Solicitamos mantener sus saldos de cuenta corriente al día. Nos ayudará como proveedores y ayudará a ustedes como clientes.</strong>
    </p>

    <br>

    <p style="font-size: 16px;">
        <strong>Correo electrónico:</strong> 
        <a href="mailto:durmetal@durmetal.com.ar">durmetal@durmetal.com.ar</a>
    </p>

    <p>Un cordial saludo.</p>

    <p style="font-weight: bold; font-size: 16px;">
        Administración <span style="color: #000;">Durmetal</span>
    </p>

</body>
</html>