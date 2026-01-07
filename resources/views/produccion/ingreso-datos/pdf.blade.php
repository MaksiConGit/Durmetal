<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado de Tratamiento Térmico</title>

    <style>
        @page {
            size: A4;
            margin: 25mm;
        }

        body {
            font-family: "Courier New", Courier, monospace;
            font-size: 13px;
            color: #000;
        }

        .certificado {
            width: 100%;
        }

        .titulo {
            text-align: center;
            font-size: 18px;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }

        .fila {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .bloque {
            margin-bottom: 18px;
        }

        .subtitulo {
            font-weight: bold;
            margin-bottom: 6px;
        }

        .col {
            width: 48%;
        }

        .observaciones {
            height: 80px;
            border-bottom: 1px solid #000;
            margin-top: 20px;
        }

        .firmas {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
        }

        .firma {
            width: 45%;
            text-align: center;
        }

        .linea {
            border-top: 1px dotted #000;
            margin-bottom: 6px;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="certificado">

    <div class="titulo">
        CERTIFICADO DE TRATAMIENTO TERMICO
    </div>

    <div class="fila">
        <div>Registro de trazabilidad: {{ $certificado->itemOrdenTrabajo->ordenTrabajo->NumeroCompleto }}</div>
        <div>19/11/2025</div>
    </div>

    <div class="bloque">
        CLIENTE: {{ $certificado->itemOrdenTrabajo->ordenTrabajo->cliente->Nombre }}
    </div>

    <div class="bloque">
        <div class="subtitulo">DATOS IDENTIFICATORIOS DE LA PIEZA</div>
        <div>Descripción: {{ $certificado->itemOrdenTrabajo->Descripcion }}</div>
    </div>

    <div class="fila">
        <div class="col">Cantidad: {{ $certificado->Cantidad }}</div>
        <div class="col">Material: {{ $certificado->itemOrdenTrabajo->material->Nombre }}</div>
    </div>

    <div class="fila">
        <div class="col">Rto/OC del cliente N°:</div>
        <div class="col">Plano N°: {{ $certificado->NroPlano}}</div>
    </div>

    <div class="bloque">
        TRAT. EFECTUADO: {{ $certificado->itemOrdenTrabajo->tratamiento->Descripcion }}
    </div>

    <div class="fila">
        <div class="col">
            <div class="subtitulo">PROP. MECANICAS SOLICITADAS</div>
            <div>Mínimo: 0.00</div>
            <div>Máximo: 0.00</div>
            <div>Dureza Tipo: HRF</div>
        </div>

        <div class="col">
            <div class="subtitulo">RESULTADOS OBTENIDOS</div>
            <div>Mínimo: 0.00</div>
            <div>Máximo: 0.00</div>
            <div>Promedio: 0.00</div>
        </div>
    </div>

    <div class="bloque">
        <div class="subtitulo">OBSERVACIONES</div>
        <div class="observaciones"></div>
    </div>

    <div class="firmas">
        <div class="firma">
            Responsable técnico: Caruana Miguel Angel
        </div>

        <div class="firma">
            <div class="linea"></div>
            Firma responsable técnico
        </div>
    </div>

</div>

</body>
</html>
