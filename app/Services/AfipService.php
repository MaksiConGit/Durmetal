<?php

namespace App\Services;

use Afip;
use App\Models\ConfiguracionGlobal;

class AfipService
{
    protected $afip;

    public function __construct()
    {
        $this->afip = new Afip([
            'CUIT' => env('AFIP_CUIT'),
            'access_token' => '6u8I7tcgUzD1YQZ65O55VVgLZaP4V8caATPiXuEBZZzjTBaukOio1oW7SBX3g3l1',
        ]);
    }

    public function getAfip()
    {
        return $this->afip;
    }

    public function obtenerCondicionesIvaReceptor()
    {
        return $this->afip->ElectronicBilling->ExecuteRequest('FEParamGetCondicionIvaReceptor');
    }

    public function crearFacturaA($body)
    {
        $afip = $this->afip;

        // =========================
        // 🔹 DATOS BASE
        // =========================
        $numero_de_documento = (int) ($body['numero_de_documento'] ?? 0);
        $tipo_de_documento = (int) ($body['tipo_de_documento'] ?? 80); // ⚠️ A = CUIT
        $importe_gravado = (float) ($body['importe_gravado'] ?? 100);
        $importe_exento_iva = (float) ($body['importe_exento_iva'] ?? 0);
        $importe_iva = (float) ($body['importe_iva'] ?? 21);
        $punto_de_venta = (int) ($body['punto_de_venta'] ?? 1);
        $concepto = (int) ($body['concepto'] ?? 1);
        $condicion_iva_receptor = (int) ($body['condicion_iva_receptor'] ?? 1);

        if ($importe_gravado <= 0) {
            throw new \Exception('El importe gravado debe ser mayor a 0');
        }

        // 🔥 FACTURA A
        $tipo_de_factura = 1;

        $lastVoucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_factura);
        $numero_de_factura = $lastVoucher + 1;

        $importe_total = $importe_gravado + $importe_iva + $importe_exento_iva;

        // =========================
        // 🧾 AFIP
        // =========================
        $data = [
            'CantReg' => 1,
            'PtoVta' => $punto_de_venta,
            'CbteTipo' => $tipo_de_factura,
            'Concepto' => $concepto,
            'DocTipo' => $tipo_de_documento,
            'DocNro' => $numero_de_documento,
            'CbteDesde' => $numero_de_factura,
            'CbteHasta' => $numero_de_factura,
            'CbteFch' => date('Ymd'),
            'ImpTotal' => $importe_total,
            'ImpTotConc' => 0,
            'ImpNeto' => $importe_gravado,
            'ImpOpEx' => $importe_exento_iva,
            'ImpIVA' => $importe_iva,
            'ImpTrib' => 0,
            'MonId' => 'PES',
            'MonCotiz' => 1,
            'CondicionIVAReceptorId' => $condicion_iva_receptor,
            'Iva' => [
                [
                    'Id' => 5,
                    'BaseImp' => $importe_gravado,
                    'Importe' => $importe_iva,
                ],
            ],
        ];

        $billResponse = $afip->ElectronicBilling->CreateVoucher($data);

        if (!isset($billResponse['CAE'])) {
            throw new \Exception('AFIP no devolvió CAE');
        }

        // =========================
        // 📅 FORMATEO
        // =========================
        $caeDue = $billResponse['CAEFchVto'] ?? '';
        if (str_contains($caeDue, '-')) {
            [$year, $month, $day] = explode('-', $caeDue);
            $caeDue = "$day/$month/$year";
        }

        $config = ConfiguracionGlobal::first();

        // =========================
        // 📄 TEMPLATE (FORMATO NUEVO)
        // =========================
        $templateParams = [
            "file_name" => 'factura-a-' . str_pad((string) $numero_de_factura, 8, '0', STR_PAD_LEFT) . '.pdf',
            "send_to" => $body['email'] ?? null,
            "template" => [
                "name" => "invoice-a",
                "params" => [

                    // Comprobante
                    "voucher_number" => $numero_de_factura,
                    "sales_point" => $punto_de_venta,
                    "issue_date" => date('d/m/Y'),
                    "cae_due_date" => $caeDue,
                    "cae" => (string) $billResponse['CAE'],

                    // Emisor
                    "issuer_cuit" => (int) env('AFIP_CUIT'),
                    "issuer_business_name" => $config->RazonSocialEmpresa,
                    "issuer_address" => $config->DomicilioEmpresa,
                    "issuer_iva_condition" => "Responsable Inscripto",
                    "issuer_gross_income" => $config->IIBBEmpresa,
                    "issuer_activity_start_date" => $this->formatearFecha(
                        $config->FechaInicioActividadesEmpresa
                    ),

                    // 🔥 Receptor (corregido para A)
                    "receiver_name" => $body['razon_social'] ?? 'Cliente',
                    "receiver_address" => $body['domicilio'] ?? '-',
                    "receiver_document_type" => $tipo_de_documento,
                    "receiver_document_number" => $numero_de_documento,
                    "receiver_iva_condition" => $body['condicion_iva'] ?? 'Responsable Inscripto',

                    // Factura
                    "sale_condition" => $body['condicion_venta'] ?? 'Contado',
                    "currency_id" => "ARS",
                    "currency_rate" => 1,
                    "concept" => $concepto,

                    // 🔥 Items (con vat_rate obligatorio)
                    "items" => !empty($body['items'])
                        ? array_map(function ($item, $index) {
                            return [
                                "code" => str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                                "description" => $item['description'] ?? 'Item',
                                "quantity" => $item['quantity'] ?? 1,
                                "unit_price" => $item['unit_price'] ?? 0, // SIN IVA
                                "subtotal" => $item['total'] ?? 0,
                                "vat_rate" => $item['vat_rate'] ?? 21
                            ];
                        }, $body['items'], array_keys($body['items']))
                        : [
                            [
                                "code" => "001",
                                "description" => "Servicio",
                                "quantity" => 1,
                                "unit_price" => $importe_gravado,
                                "subtotal" => $importe_gravado,
                                "vat_rate" => 21
                            ]
                        ],

                    // Totales
                    "vat_amount" => $importe_iva,
                    "tributes_amount" => 0,
                    "total_amount" => $importe_total,

                    // 🔥 Obligatorios A
                    "net_amount_taxed" => $importe_gravado,
                    "net_amount_untaxed" => 0,
                    "exempt_amount" => $importe_exento_iva,

                    "vat_breakdown" => [
                        [
                            "vat_rate_id" => 21,
                            "taxable_base" => $importe_gravado,
                            "vat_subtotal" => $importe_iva
                        ]
                    ],

                    // Fechas
                    "billing_from" => date('01/m/Y'),
                    "billing_to" => date('t/m/Y'),
                    "payment_due_date" => date('d/m/Y', strtotime('+10 days')),
                ]
            ]
        ];

        // =========================
        // 📄 PDF
        // =========================
        $pdfResponse = $afip->ElectronicBilling->CreatePDF($templateParams);

        if (!$pdfResponse || !isset($pdfResponse['file'])) {
            throw new \Exception('Error al generar el PDF');
        }

        return [
            'file' => $pdfResponse['file'],
            'cae' => $billResponse['CAE'],
            'cae_vencimiento' => $billResponse['CAEFchVto'],
            'numero' => $numero_de_factura
        ];
    }

    public function crearFacturaB($body)
    {
        $afip = $this->afip;

        // =========================
        // 📥 INPUTS
        // =========================
        $punto_de_venta = (int) ($body['punto_de_venta'] ?? 1);
        $concepto = (int) ($body['concepto'] ?? 1);
        $tipo_de_documento = (int) ($body['tipo_de_documento'] ?? 99);
        $numero_de_documento = (int) ($body['numero_de_documento'] ?? 0);
        $importe_gravado = (float) ($body['importe_gravado'] ?? 100);
        $importe_exento_iva = (float) ($body['importe_exento_iva'] ?? 0);
        $importe_iva = (float) ($body['importe_iva'] ?? 21);
        $condicion_iva_receptor = (int) ($body['condicion_iva_receptor'] ?? 5);

        if ($importe_gravado <= 0) {
            throw new \Exception('El importe gravado debe ser mayor a 0');
        }

        // =========================
        // 🧾 FACTURA B
        // =========================
        $tipo_de_factura = 6;

        $last_voucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_factura);
        $numero_de_factura = $last_voucher + 1;

        $fecha = date('Y-m-d');
        $importe_total = $importe_gravado + $importe_iva + $importe_exento_iva;

        // =========================
        // 📅 FECHAS SERVICIO
        // =========================
        if ($concepto === 2 || $concepto === 3) {
            $fecha_servicio_desde = intval(date('Ymd'));
            $fecha_servicio_hasta = intval(date('Ymd'));
            $fecha_vencimiento_pago = intval(date('Ymd'));
        } else {
            $fecha_servicio_desde = null;
            $fecha_servicio_hasta = null;
            $fecha_vencimiento_pago = null;
        }

        // =========================
        // 📡 AFIP WSFE
        // =========================
        $data = [
            'CantReg' => 1,
            'PtoVta' => $punto_de_venta,
            'CbteTipo' => $tipo_de_factura,
            'Concepto' => $concepto,
            'DocTipo' => $tipo_de_documento,
            'DocNro' => $numero_de_documento,
            'CbteDesde' => $numero_de_factura,
            'CbteHasta' => $numero_de_factura,
            'CbteFch' => intval(str_replace('-', '', $fecha)),
            'FchServDesde' => $fecha_servicio_desde,
            'FchServHasta' => $fecha_servicio_hasta,
            'FchVtoPago' => $fecha_vencimiento_pago,
            'ImpTotal' => $importe_total,
            'ImpTotConc' => 0,
            'ImpNeto' => $importe_gravado,
            'ImpOpEx' => $importe_exento_iva,
            'ImpIVA' => $importe_iva,
            'ImpTrib' => 0,
            'MonId' => 'PES',
            'MonCotiz' => 1,
            'CondicionIVAReceptorId' => $condicion_iva_receptor,
            'Iva' => [
                [
                    'Id' => 5,
                    'BaseImp' => $importe_gravado,
                    'Importe' => $importe_iva,
                ],
            ],
        ];

        $billResponse = $afip->ElectronicBilling->CreateVoucher($data);

        if (!isset($billResponse['CAE'])) {
            throw new \Exception('AFIP no devolvió CAE');
        }

        // =========================
        // 📅 FORMATEOS
        // =========================
        $caeDue = $billResponse['CAEFchVto'] ?? '';
        if (str_contains($caeDue, '-')) {
            [$year, $month, $day] = explode('-', $caeDue);
            $caeDue = "$day/$month/$year";
        }

        $config = ConfiguracionGlobal::first();

        // =========================
        // 📄 TEMPLATE (FACTURA B)
        // =========================
        $templateParams = [
            "file_name" => 'factura-b-' . str_pad((string)$numero_de_factura, 8, '0', STR_PAD_LEFT) . '.pdf',
            "send_to" => $body['email'] ?? null,
            "template" => [
                "name" => "invoice-b",
                "params" => [

                    // 🧾 Comprobante
                    "voucher_number" => $numero_de_factura,
                    "sales_point" => $punto_de_venta,
                    "issue_date" => date('d/m/Y'),
                    "cae_due_date" => $caeDue,
                    "cae" => (string) $billResponse['CAE'],

                    // 🧑‍💼 Emisor
                    "issuer_cuit" => (int) env('AFIP_CUIT'),
                    "issuer_business_name" => $config->RazonSocialEmpresa,
                    "issuer_address" => $config->DomicilioEmpresa,
                    "issuer_iva_condition" => "Responsable Inscripto",
                    "issuer_gross_income" => $config->IIBBEmpresa,
                    "issuer_activity_start_date" => $this->formatearFecha($config->FechaInicioActividadesEmpresa),

                    // 👤 Receptor
                    "receiver_name" => $body['razon_social'] ?? "CONSUMIDOR FINAL",
                    "receiver_address" => $body['domicilio'] ?? "-",
                    "receiver_document_type" => $tipo_de_documento,
                    "receiver_document_number" => $numero_de_documento,
                    "receiver_iva_condition" => "Consumidor Final",

                    // 💰 Factura
                    "sale_condition" => $body['condicion_venta'] ?? "Contado",
                    "currency_id" => "ARS",
                    "currency_rate" => 1,
                    "concept" => $concepto,

                    // 🧾 Items (IVA INCLUIDO)
                    "items" => !empty($body['items'])
                        ? array_map(function ($item, $index) {
                            return [
                                "code" => str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                                "description" => $item['description'] ?? $item['descripcion'] ?? 'Item',
                                "quantity" => $item['quantity'] ?? 1,
                                "unit_price" => $item['unit_price'] ?? 0, // ⚠️ CON IVA
                                "subtotal" => $item['total'] ?? 0
                            ];
                        }, $body['items'], array_keys($body['items']))
                        : [
                            [
                                "code" => "001",
                                "description" => "Producto/Servicio",
                                "quantity" => 1,
                                "unit_price" => $importe_total,
                                "subtotal" => $importe_total
                            ]
                        ],

                    // 💸 Totales
                    "vat_amount" => $importe_iva,
                    "tributes_amount" => 0,
                    "total_amount" => $importe_total,

                    // 📅 Fechas servicio
                    "billing_from" => date('d/m/Y'),
                    "billing_to" => date('d/m/Y'),
                    "payment_due_date" => date('d/m/Y'),
                ]
            ]
        ];

        // =========================
        // 📄 PDF
        // =========================
        $pdfResponse = $afip->ElectronicBilling->CreatePDF($templateParams);

        if (!$pdfResponse || !isset($pdfResponse['file'])) {
            throw new \Exception('Error al generar el PDF');
        }

        return [
            'file' => $pdfResponse['file'],
            'cae' => $billResponse['CAE'],
            'cae_vencimiento' => $billResponse['CAEFchVto'],
            'numero' => $numero_de_factura
        ];
    }

    public function crearNotaCreditoA($body)
    {
        $afip = $this->afip;

        // =========================
        // 🔹 DATOS BASE
        // =========================
        $numero_de_documento = (int) ($body['numero_de_documento'] ?? 0);
        $tipo_de_documento = (int) ($body['tipo_de_documento'] ?? 80);

        $importe_gravado = (float) ($body['importe_gravado'] ?? 100);
        $importe_exento_iva = (float) ($body['importe_exento_iva'] ?? 0);
        $importe_iva = (float) ($body['importe_iva'] ?? 21);

        $punto_de_venta = (int) ($body['punto_de_venta'] ?? 1);
        $concepto = (int) ($body['concepto'] ?? 1);
        $condicion_iva_receptor = (int) ($body['condicion_iva_receptor'] ?? 1);

        // 🔥 FACTURA ASOCIADA (OBLIGATORIO)
        $tipo_factura_asociada = (int) ($body['tipo_factura_asociada'] ?? 1); // Factura A
        $punto_factura_asociada = (int) ($body['punto_factura_asociada'] ?? $punto_de_venta);
        $numero_factura_asociada = (int) ($body['numero_factura_asociada'] ?? 0);

        if ($numero_factura_asociada <= 0) {
            throw new \Exception('La Nota de Crédito requiere una factura asociada válida');
        }

        if ($importe_gravado <= 0) {
            throw new \Exception('El importe gravado debe ser mayor a 0');
        }

        // 🔥 NOTA DE CRÉDITO A
        $tipo_de_nota = 3;

        $lastVoucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_nota);
        $numero_de_nota = $lastVoucher + 1;

        $importe_total = $importe_gravado + $importe_iva + $importe_exento_iva;

        // =========================
        // 🧾 AFIP
        // =========================
        $data = [
            'CantReg' => 1,
            'PtoVta' => $punto_de_venta,
            'CbteTipo' => $tipo_de_nota,
            'Concepto' => $concepto,
            'DocTipo' => $tipo_de_documento,
            'DocNro' => $numero_de_documento,
            'CbteDesde' => $numero_de_nota,
            'CbteHasta' => $numero_de_nota,
            'CbteFch' => date('Ymd'),

            'ImpTotal' => $this->formatearNumero($importe_total),
            'ImpTotConc' => 0,
            'ImpNeto' => $this->formatearNumero($importe_gravado),
            'ImpOpEx' => $this->formatearNumero($importe_exento_iva),
            'ImpIVA' => $this->formatearNumero($importe_iva),
            'ImpTrib' => 0,

            'MonId' => 'PES',
            'MonCotiz' => 1,
            'CondicionIVAReceptorId' => $condicion_iva_receptor,

            // 🔥 FACTURA ASOCIADA
            'CbtesAsoc' => [
                [
                    'Tipo' => $tipo_factura_asociada,
                    'PtoVta' => $punto_factura_asociada,
                    'Nro' => $numero_factura_asociada,
                ]
            ],

            'Iva' => [
                [
                    'Id' => 5,
                    'BaseImp' => $importe_gravado,
                    'Importe' => $importe_iva,
                ]
            ],
        ];
        
        $billResponse = $afip->ElectronicBilling->CreateVoucher($data);

        if (!isset($billResponse['CAE'])) {
            throw new \Exception('AFIP no devolvió CAE');
        }

        // =========================
        // 📅 FORMATEO
        // =========================
        $caeDue = $billResponse['CAEFchVto'] ?? '';
        if (str_contains($caeDue, '-')) {
            [$year, $month, $day] = explode('-', $caeDue);
            $caeDue = "$day/$month/$year";
        }

        $config = ConfiguracionGlobal::first();

        // =========================
        // 📄 TEMPLATE (NOTA DE CRÉDITO)
        // =========================
        $templateParams = [
            "file_name" => 'nc-a-' . str_pad((string) $numero_de_nota, 8, '0', STR_PAD_LEFT) . '.pdf',
            "send_to" => $body['email'] ?? null,
            "template" => [
                "name" => "credit-note-a",
                "params" => [

                    // Comprobante
                    "voucher_number" => $numero_de_nota,
                    "sales_point" => $punto_de_venta,
                    "issue_date" => date('d/m/Y'),
                    "cae_due_date" => $caeDue,
                    "cae" => (string) $billResponse['CAE'],

                    // Emisor
                    "issuer_cuit" => (int) env('AFIP_CUIT'),
                    "issuer_business_name" => $config->RazonSocialEmpresa,
                    "issuer_address" => $config->DomicilioEmpresa,
                    "issuer_iva_condition" => "Responsable Inscripto",
                    "issuer_gross_income" => $config->IIBBEmpresa,
                    "issuer_activity_start_date" => $this->formatearFecha(
                        $config->FechaInicioActividadesEmpresa
                    ),

                    // Receptor
                    "receiver_name" => $body['razon_social'] ?? 'Cliente',
                    "receiver_address" => $body['domicilio'] ?? '-',
                    "receiver_document_type" => $tipo_de_documento,
                    "receiver_document_number" => $numero_de_documento,
                    "receiver_iva_condition" => $body['condicion_iva'] ?? 'Responsable Inscripto',

                    // Factura
                    "sale_condition" => $body['condicion_venta'] ?? 'Contado',
                    "currency_id" => "ARS",
                    "currency_rate" => 1,
                    "concept" => $concepto,

                    // Items
                    "items" => !empty($body['items'])
                        ? array_map(function ($item, $index) {
                            return [
                                "code" => str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                                "description" => $item['description'] ?? 'Item',
                                "quantity" => $item['quantity'] ?? 1,
                                "unit_price" => $item['unit_price'] ?? 0,
                                "subtotal" => $item['total'] ?? 0,
                                "vat_rate" => $item['vat_rate'] ?? 21
                            ];
                        }, $body['items'], array_keys($body['items']))
                        : [
                            [
                                "code" => "001",
                                "description" => "Nota de crédito",
                                "quantity" => 1,
                                "unit_price" => $importe_total,
                                "subtotal" => $importe_total,
                                "vat_rate" => 21
                            ]
                        ],

                    // Totales
                    "vat_amount" => $importe_iva,
                    "tributes_amount" => 0,
                    "total_amount" => $importe_total,

                    "net_amount_taxed" => $importe_gravado,
                    "net_amount_untaxed" => 0,
                    "exempt_amount" => $importe_exento_iva,

                    "vat_breakdown" => [
                        [
                            "vat_rate_id" => 21,
                            "taxable_base" => $importe_gravado,
                            "vat_subtotal" => $importe_iva
                        ]
                    ],

                    // 🔥 FACTURA ASOCIADA EN PDF
                    "associated_vouchers" => [
                        [
                            "voucher_type" => $tipo_factura_asociada,
                            "point_of_sale" => $punto_factura_asociada,
                            "voucher_number" => $numero_factura_asociada,
                            "issue_date" => date('d/m/Y')
                        ]
                    ],

                    // 🔥 MOTIVO
                    "credit_note_reason" => $body['motivo'] ?? 'Anulación',

                    // Fechas
                    "billing_from" => date('01/m/Y'),
                    "billing_to" => date('t/m/Y'),
                    "payment_due_date" => date('d/m/Y', strtotime('+10 days')),
                ]
            ]
        ];

        // =========================
        // 📄 PDF
        // =========================
        $pdfResponse = $afip->ElectronicBilling->CreatePDF($templateParams);

        if (!$pdfResponse || !isset($pdfResponse['file'])) {
            throw new \Exception('Error al generar el PDF');
        }

        return [
            'file' => $pdfResponse['file'],
            'cae' => $billResponse['CAE'],
            'cae_vencimiento' => $billResponse['CAEFchVto'],
            'numero' => $numero_de_nota
        ];
    }

    public function crearNotaCreditoB($body)
    {
        $afip = $this->afip;

        // =========================
        // 🔹 DATOS BASE
        // =========================
        $numero_de_documento = (int) ($body['numero_de_documento'] ?? 0);
        $tipo_de_documento = (int) ($body['tipo_de_documento'] ?? 99);

        $importe_gravado = (float) ($body['importe_gravado'] ?? 100);
        $importe_exento_iva = (float) ($body['importe_exento_iva'] ?? 0);
        $importe_iva = (float) ($body['importe_iva'] ?? 21);

        $punto_de_venta = (int) ($body['punto_de_venta'] ?? 1);
        $concepto = (int) ($body['concepto'] ?? 1);
        $condicion_iva_receptor = (int) ($body['condicion_iva_receptor'] ?? 5);

        // 🔥 FACTURA ASOCIADA (B)
        $tipo_factura_asociada = 6;
        $punto_factura_asociada = (int) ($body['punto_factura_asociada'] ?? $punto_de_venta);
        $numero_factura_asociada = (int) ($body['numero_factura_asociada'] ?? 0);

        if ($numero_factura_asociada <= 0) {
            throw new \Exception('La Nota de Crédito B requiere una factura asociada válida');
        }

        // 🔥 TIPO NOTA B
        $tipo_de_nota = 8;

        $lastVoucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_nota);
        $numero_de_nota = $lastVoucher + 1;

        $importe_total = $importe_gravado + $importe_iva + $importe_exento_iva;

        // =========================
        // 🧾 AFIP
        // =========================
        $data = [
            'CantReg' => 1,
            'PtoVta' => $punto_de_venta,
            'CbteTipo' => $tipo_de_nota,
            'Concepto' => $concepto,
            'DocTipo' => $tipo_de_documento,
            'DocNro' => $numero_de_documento,
            'CbteDesde' => $numero_de_nota,
            'CbteHasta' => $numero_de_nota,
            'CbteFch' => date('Ymd'),

            'ImpTotal' => $this->formatearNumero($importe_total),
            'ImpTotConc' => 0,
            'ImpNeto' => $this->formatearNumero($importe_gravado),
            'ImpOpEx' => $this->formatearNumero($importe_exento_iva),
            'ImpIVA' => $this->formatearNumero($importe_iva),
            'ImpTrib' => 0,

            'MonId' => 'PES',
            'MonCotiz' => 1,
            'CondicionIVAReceptorId' => $condicion_iva_receptor,

            'CbtesAsoc' => [
                [
                    'Tipo' => $tipo_factura_asociada,
                    'PtoVta' => $punto_factura_asociada,
                    'Nro' => $numero_factura_asociada,
                ]
            ],

            'Iva' => [
                [
                    'Id' => 5,
                    'BaseImp' => $this->formatearNumero($importe_gravado),
                    'Importe' => $this->formatearNumero($importe_iva),
                ]
            ],
        ];

        $billResponse = $afip->ElectronicBilling->CreateVoucher($data);

        if (!isset($billResponse['CAE'])) {
            throw new \Exception('AFIP no devolvió CAE');
        }

        // =========================
        // 📅 FORMATEO
        // =========================
        $caeDue = $billResponse['CAEFchVto'] ?? '';
        if (str_contains($caeDue, '-')) {
            [$year, $month, $day] = explode('-', $caeDue);
            $caeDue = "$day/$month/$year";
        }

        $config = ConfiguracionGlobal::first();

        // =========================
        // 📄 TEMPLATE B
        // =========================
        $templateParams = [
            "file_name" => 'nc-b-' . str_pad((string) $numero_de_nota, 8, '0', STR_PAD_LEFT) . '.pdf',
            "send_to" => $body['email'] ?? null,
            "template" => [
                "name" => "credit-note-b",
                "params" => [

                    // Comprobante
                    "voucher_number" => $numero_de_nota,
                    "sales_point" => $punto_de_venta,
                    "issue_date" => date('d/m/Y'),
                    "cae_due_date" => $caeDue,
                    "cae" => (string) $billResponse['CAE'],

                    // Emisor
                    "issuer_cuit" => (int) env('AFIP_CUIT'),
                    "issuer_business_name" => $config->RazonSocialEmpresa,
                    "issuer_address" => $config->DomicilioEmpresa,
                    "issuer_iva_condition" => "Responsable Inscripto",
                    "issuer_gross_income" => $config->IIBBEmpresa,
                    "issuer_activity_start_date" => $this->formatearFecha(
                        $config->FechaInicioActividadesEmpresa
                    ),

                    // Receptor
                    "receiver_name" => $body['razon_social'] ?? 'Consumidor Final',
                    "receiver_address" => $body['domicilio'] ?? '-',
                    "receiver_document_type" => $tipo_de_documento,
                    "receiver_document_number" => $numero_de_documento,
                    "receiver_iva_condition" => $body['condicion_iva'] ?? 'Consumidor Final',

                    // Factura
                    "sale_condition" => $body['condicion_venta'] ?? 'Contado',
                    "currency_id" => "ARS",
                    "currency_rate" => 1,
                    "concept" => $concepto,

                    // 🔥 ITEMS (CON IVA INCLUIDO)
                    "items" => !empty($body['items'])
                        ? array_map(function ($item, $index) {
                            $total = (float) ($item['total'] ?? 0);

                            return [
                                "code" => str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                                "description" => $item['description'] ?? 'Item',
                                "quantity" => $item['quantity'] ?? 1,
                                "unit_price" => $this->formatearNumero($total),
                                "subtotal" => $this->formatearNumero($total),
                            ];
                        }, $body['items'], array_keys($body['items']))
                        : [
                            [
                                "code" => "001",
                                "description" => "Nota de crédito",
                                "quantity" => 1,
                                "unit_price" => $this->formatearNumero($importe_total),
                                "subtotal" => $this->formatearNumero($importe_total),
                            ]
                        ],

                    // Totales
                    "vat_amount" => $this->formatearNumero($importe_iva),
                    "tributes_amount" => 0,
                    "total_amount" => $this->formatearNumero($importe_total),

                    // Factura asociada
                    "associated_vouchers" => [
                        [
                            "voucher_type" => $tipo_factura_asociada,
                            "point_of_sale" => $punto_factura_asociada,
                            "voucher_number" => $numero_factura_asociada,
                            "issue_date" => date('d/m/Y')
                        ]
                    ],

                    // Motivo
                    "credit_note_reason" => $body['motivo'] ?? 'Anulación',

                    // Fechas
                    "billing_from" => date('01/m/Y'),
                    "billing_to" => date('t/m/Y'),
                    "payment_due_date" => date('d/m/Y', strtotime('+10 days')),
                ]
            ]
        ];

        $pdfResponse = $afip->ElectronicBilling->CreatePDF($templateParams);

        if (!$pdfResponse || !isset($pdfResponse['file'])) {
            throw new \Exception('Error al generar el PDF');
        }

        return [
            'file' => $pdfResponse['file'],
            'cae' => $billResponse['CAE'],
            'cae_vencimiento' => $billResponse['CAEFchVto'],
            'numero' => $numero_de_nota
        ];
    }

    public function crearNotaDebitoA($body)
    {
        $afip = $this->afip;

        // =========================
        // 🔹 DATOS BASE
        // =========================
        $numero_de_documento = (int) ($body['numero_de_documento'] ?? 0);
        $tipo_de_documento = (int) ($body['tipo_de_documento'] ?? 80);

        $importe_gravado = (float) ($body['importe_gravado'] ?? 0);
        $importe_exento_iva = (float) ($body['importe_exento_iva'] ?? 0);
        $importe_iva = (float) ($body['importe_iva'] ?? 0);

        $punto_de_venta = (int) ($body['punto_de_venta'] ?? 1);
        $concepto = (int) ($body['concepto'] ?? 1);
        $condicion_iva_receptor = (int) ($body['condicion_iva_receptor'] ?? 1);

        // 🔥 FACTURA ASOCIADA (OBLIGATORIO)
        $tipo_factura_asociada = (int) ($body['tipo_factura_asociada'] ?? 1);
        $punto_factura_asociada = (int) ($body['punto_factura_asociada'] ?? $punto_de_venta);
        $numero_factura_asociada = (int) ($body['numero_factura_asociada'] ?? 0);

        if ($numero_factura_asociada <= 0) {
            throw new \Exception('La Nota de Débito requiere una factura asociada válida');
        }

        if ($importe_gravado <= 0) {
            throw new \Exception('El importe gravado debe ser mayor a 0');
        }

        // 🔥 NOTA DE DÉBITO A
        $tipo_de_nota = 2;

        $lastVoucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_nota);
        $numero_de_nota = $lastVoucher + 1;

        $importe_total = $importe_gravado + $importe_iva + $importe_exento_iva;

        // =========================
        // 🧾 AFIP
        // =========================
        $data = [
            'CantReg' => 1,
            'PtoVta' => $punto_de_venta,
            'CbteTipo' => $tipo_de_nota,
            'Concepto' => $concepto,
            'DocTipo' => $tipo_de_documento,
            'DocNro' => $numero_de_documento,
            'CbteDesde' => $numero_de_nota,
            'CbteHasta' => $numero_de_nota,
            'CbteFch' => date('Ymd'),

            'ImpTotal' => $this->formatearNumero($importe_total),
            'ImpTotConc' => 0,
            'ImpNeto' => $this->formatearNumero($importe_gravado),
            'ImpOpEx' => $this->formatearNumero($importe_exento_iva),
            'ImpIVA' => $this->formatearNumero($importe_iva),
            'ImpTrib' => 0,

            'MonId' => 'PES',
            'MonCotiz' => 1,
            'CondicionIVAReceptorId' => $condicion_iva_receptor,

            // 🔥 FACTURA ASOCIADA
            'CbtesAsoc' => [
                [
                    'Tipo' => $tipo_factura_asociada,
                    'PtoVta' => $punto_factura_asociada,
                    'Nro' => $numero_factura_asociada,
                ]
            ],

            'Iva' => [
                [
                    'Id' => 5,
                    'BaseImp' => $this->formatearNumero($importe_gravado),
                    'Importe' => $this->formatearNumero($importe_iva),
                ]
            ],
        ];

        $billResponse = $afip->ElectronicBilling->CreateVoucher($data);

        if (!isset($billResponse['CAE'])) {
            throw new \Exception('AFIP no devolvió CAE');
        }

        // =========================
        // 📅 FORMATEO
        // =========================
        $caeDue = $billResponse['CAEFchVto'] ?? '';
        if (str_contains($caeDue, '-')) {
            [$year, $month, $day] = explode('-', $caeDue);
            $caeDue = "$day/$month/$year";
        }

        $config = ConfiguracionGlobal::first();

        // =========================
        // 📄 TEMPLATE
        // =========================
        $templateParams = [
            "file_name" => 'nd-a-' . str_pad((string) $numero_de_nota, 8, '0', STR_PAD_LEFT) . '.pdf',
            "send_to" => $body['email'] ?? null,
            "template" => [
                "name" => "debit-note-a",
                "params" => [

                    // Comprobante
                    "voucher_number" => $numero_de_nota,
                    "sales_point" => $punto_de_venta,
                    "issue_date" => date('d/m/Y'),
                    "cae_due_date" => $caeDue,
                    "cae" => (string) $billResponse['CAE'],

                    // Emisor
                    "issuer_cuit" => (int) env('AFIP_CUIT'),
                    "issuer_business_name" => $config->RazonSocialEmpresa,
                    "issuer_address" => $config->DomicilioEmpresa,
                    "issuer_iva_condition" => "Responsable Inscripto",
                    "issuer_gross_income" => $config->IIBBEmpresa,
                    "issuer_activity_start_date" => $this->formatearFecha(
                        $config->FechaInicioActividadesEmpresa
                    ),

                    // Receptor
                    "receiver_name" => $body['razon_social'] ?? 'Cliente',
                    "receiver_address" => $body['domicilio'] ?? '-',
                    "receiver_document_type" => $tipo_de_documento,
                    "receiver_document_number" => $numero_de_documento,
                    "receiver_iva_condition" => $body['condicion_iva'] ?? 'Responsable Inscripto',

                    // Factura
                    "sale_condition" => $body['condicion_venta'] ?? 'Contado',
                    "currency_id" => "ARS",
                    "currency_rate" => 1,
                    "concept" => $concepto,

                    // Items (igual que A)
                    "items" => !empty($body['items'])
                        ? array_map(function ($item, $index) {
                            return [
                                "code" => str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                                "description" => $item['description'] ?? 'Item',
                                "quantity" => $item['quantity'] ?? 1,
                                "unit_price" => $item['unit_price'] ?? 0,
                                "subtotal" => $item['total'] ?? 0,
                                "vat_rate" => $item['vat_rate'] ?? 21
                            ];
                        }, $body['items'], array_keys($body['items']))
                        : [
                            [
                                "code" => "001",
                                "description" => "Nota de débito",
                                "quantity" => 1,
                                "unit_price" => $importe_gravado,
                                "subtotal" => $importe_gravado,
                                "vat_rate" => 21
                            ]
                        ],

                    // Totales
                    "vat_amount" => $this->formatearNumero($importe_iva),
                    "tributes_amount" => 0,
                    "total_amount" => $this->formatearNumero($importe_total),

                    "net_amount_taxed" => $importe_gravado,
                    "net_amount_untaxed" => 0,
                    "exempt_amount" => $importe_exento_iva,

                    "vat_breakdown" => [
                        [
                            "vat_rate_id" => 21,
                            "taxable_base" => $this->formatearNumero($importe_gravado),
                            "vat_subtotal" => $this->formatearNumero($importe_iva)
                        ]
                    ],

                    // 🔥 FACTURA ASOCIADA
                    "associated_vouchers" => [
                        [
                            "voucher_type" => $tipo_factura_asociada,
                            "point_of_sale" => $punto_factura_asociada,
                            "voucher_number" => $numero_factura_asociada,
                            "issue_date" => date('d/m/Y')
                        ]
                    ],

                    // 🔥 MOTIVO
                    "debit_note_reason" => $body['motivo'] ?? 'Ajuste',

                    // Fechas
                    "billing_from" => date('01/m/Y'),
                    "billing_to" => date('t/m/Y'),
                    "payment_due_date" => date('d/m/Y', strtotime('+10 days')),
                ]
            ]
        ];

        $pdfResponse = $afip->ElectronicBilling->CreatePDF($templateParams);

        if (!$pdfResponse || !isset($pdfResponse['file'])) {
            throw new \Exception('Error al generar el PDF');
        }

        return [
            'file' => $pdfResponse['file'],
            'cae' => $billResponse['CAE'],
            'cae_vencimiento' => $billResponse['CAEFchVto'],
            'numero' => $numero_de_nota
        ];
    }

    public function crearNotaDebitoB($body)
    {
        $afip = $this->afip;

        // =========================
        // 🔹 DATOS BASE
        // =========================
        $numero_de_documento = (int) ($body['numero_de_documento'] ?? 0);
        $tipo_de_documento = (int) ($body['tipo_de_documento'] ?? 99); // B suele ser consumidor final por defecto

        $importe_gravado = (float) ($body['importe_gravado'] ?? 0);
        $importe_exento_iva = (float) ($body['importe_exento_iva'] ?? 0);
        $importe_iva = (float) ($body['importe_iva'] ?? 0);

        $punto_de_venta = (int) ($body['punto_de_venta'] ?? 1);
        $concepto = (int) ($body['concepto'] ?? 1);
        $condicion_iva_receptor = (int) ($body['condicion_iva_receptor'] ?? 5);

        // 🔥 FACTURA ASOCIADA (OBLIGATORIO)
        $tipo_factura_asociada = (int) ($body['tipo_factura_asociada'] ?? 6);
        $punto_factura_asociada = (int) ($body['punto_factura_asociada'] ?? $punto_de_venta);
        $numero_factura_asociada = (int) ($body['numero_factura_asociada'] ?? 0);

        // =========================
        // 🔥 VALIDACIONES
        // =========================
        if ($importe_gravado <= 0) {
            throw new \Exception('El importe gravado debe ser mayor a 0');
        }

        // =========================
        // 🔥 NOTA DE DÉBITO B
        // =========================
        $tipo_de_nota = 7;

        $lastVoucher = $afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_nota);
        $numero_de_nota = $lastVoucher + 1;

        $importe_total = $importe_gravado + $importe_iva + $importe_exento_iva;

        // =========================
        // 🧾 AFIP
        // =========================
        $data = [
            'CantReg' => 1,
            'PtoVta' => $punto_de_venta,
            'CbteTipo' => $tipo_de_nota,
            'Concepto' => $concepto,
            'DocTipo' => $tipo_de_documento,
            'DocNro' => $numero_de_documento,
            'CbteDesde' => $numero_de_nota,
            'CbteHasta' => $numero_de_nota,
            'CbteFch' => date('Ymd'),

            'ImpTotal' => $this->formatearNumero($importe_total),
            'ImpTotConc' => 0,
            'ImpNeto' => $this->formatearNumero($importe_gravado),
            'ImpOpEx' => $this->formatearNumero($importe_exento_iva),
            'ImpIVA' => $this->formatearNumero($importe_iva),
            'ImpTrib' => 0,

            'MonId' => 'PES',
            'MonCotiz' => 1,
            'CondicionIVAReceptorId' => $condicion_iva_receptor,

            'CbtesAsoc' => [
                [
                    'Tipo' => $tipo_factura_asociada,
                    'PtoVta' => $punto_factura_asociada,
                    'Nro' => $numero_factura_asociada,
                ]
            ],

            'Iva' => [
                [
                    'Id' => 5,
                    'BaseImp' => $this->formatearNumero($importe_gravado),
                    'Importe' => $this->formatearNumero($importe_iva),
                ]
            ],
        ];

        $billResponse = $afip->ElectronicBilling->CreateVoucher($data);

        if (!isset($billResponse['CAE'])) {
            throw new \Exception('AFIP no devolvió CAE');
        }

        // =========================
        // 📅 FORMATO FECHA CAE
        // =========================
        $caeDue = $billResponse['CAEFchVto'] ?? '';
        if (str_contains($caeDue, '-')) {
            [$y, $m, $d] = explode('-', $caeDue);
            $caeDue = "$d/$m/$y";
        }

        $config = ConfiguracionGlobal::first();

        // =========================
        // 📄 TEMPLATE PDF
        // =========================
        $templateParams = [
            "file_name" => 'nd-b-' . str_pad((string)$numero_de_nota, 8, '0', STR_PAD_LEFT) . '.pdf',
            "send_to" => $body['email'] ?? null,
            "template" => [
                "name" => "debit-note-b",
                "params" => [

                    // Comprobante
                    "voucher_number" => $numero_de_nota,
                    "sales_point" => $punto_de_venta,
                    "issue_date" => date('d/m/Y'),
                    "cae_due_date" => $caeDue,
                    "cae" => (string) $billResponse['CAE'],

                    // Emisor
                    "issuer_cuit" => (int) env('AFIP_CUIT'),
                    "issuer_business_name" => $config->RazonSocialEmpresa,
                    "issuer_address" => $config->DomicilioEmpresa,
                    "issuer_iva_condition" => "Responsable Inscripto",
                    "issuer_gross_income" => $config->IIBBEmpresa,
                    "issuer_activity_start_date" => $this->formatearFecha($config->FechaInicioActividadesEmpresa),

                    // Receptor (B = flexible)
                    "receiver_name" => $body['razon_social'] ?? 'CONSUMIDOR FINAL',
                    "receiver_address" => $body['domicilio'] ?? '-',
                    "receiver_document_type" => $tipo_de_documento,
                    "receiver_document_number" => $numero_de_documento,
                    "receiver_iva_condition" => $body['condicion_iva'] ?? 'Consumidor Final',

                    // Factura
                    "sale_condition" => $body['condicion_venta'] ?? 'Contado',
                    "currency_id" => "ARS",
                    "currency_rate" => 1,
                    "concept" => $concepto,

                    // Items
                    "items" => !empty($body['items'])
                        ? array_map(function ($item, $index) {
                            return [
                                "code" => str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                                "description" => $item['description'] ?? 'Item',
                                "quantity" => $item['quantity'] ?? 1,
                                "unit_price" => $item['unit_price'] ?? 0,
                                "subtotal" => $item['total'] ?? 0,
                                "vat_rate" => $item['vat_rate'] ?? 21,
                            ];
                        }, $body['items'], array_keys($body['items']))
                        : [
                            [
                                "code" => "001",
                                "description" => "Nota de débito",
                                "quantity" => 1,
                                "unit_price" => $importe_gravado,
                                "subtotal" => $importe_gravado,
                                "vat_rate" => 21,
                            ]
                        ],

                    // Totales
                    "vat_amount" => $this->formatearNumero($importe_iva),
                    "tributes_amount" => 0,
                    "total_amount" => $this->formatearNumero($importe_total),

                    // Factura asociada
                    "associated_vouchers" => [
                        [
                            "voucher_type" => $tipo_factura_asociada,
                            "point_of_sale" => $punto_factura_asociada,
                            "voucher_number" => $numero_factura_asociada,
                            "issue_date" => date('d/m/Y')
                        ]
                    ],

                    "net_amount_taxed" => $importe_gravado,
                    "net_amount_untaxed" => 0,
                    "exempt_amount" => $importe_exento_iva,

                    "vat_breakdown" => [
                        [
                            "vat_rate_id" => 21,
                            "taxable_base" => $this->formatearNumero($importe_gravado),
                            "vat_subtotal" => $this->formatearNumero($importe_iva),
                        ]
                    ],

                    // Motivo
                    "debit_note_reason" => $body['motivo'] ?? 'Interés / Ajuste',

                    // Fechas
                    "billing_from" => date('01/m/Y'),
                    "billing_to" => date('t/m/Y'),
                    "payment_due_date" => date('d/m/Y', strtotime('+10 days')),
                ]
            ]
        ];

        // =========================
        // 📄 PDF
        // =========================
        $pdfResponse = $afip->ElectronicBilling->CreatePDF($templateParams);

        if (!$pdfResponse || !isset($pdfResponse['file'])) {
            throw new \Exception('Error al generar el PDF');
        }

        return [
            'file' => $pdfResponse['file'],
            'cae' => $billResponse['CAE'],
            'cae_vencimiento' => $billResponse['CAEFchVto'],
            'numero' => $numero_de_nota
        ];
    }

    public function obtenerUltimaFactura($puntoVenta, $tipoFactura)
    {
        $afip = $this->afip;

        $lastVoucher = $afip->ElectronicBilling->GetLastVoucher($puntoVenta, $tipoFactura);

        if (!$lastVoucher) {
            throw new \Exception('No se pudo obtener el último comprobante');
        }

        $voucherInfo = $afip->ElectronicBilling->GetVoucherInfo(
            $lastVoucher,
            $puntoVenta,
            $tipoFactura
        );

        return $voucherInfo;
    }

    private function formatearFecha($fecha)
    {
        if (!$fecha) {
            return date('d/m/Y');
        }

        return date('d/m/Y', strtotime(str_replace('/', '-', $fecha)));
    }

    private function formatearNumero($value)
    {
        return number_format((float)$value, 2, '.', '');
    }

    public function crearCertificadoProduccion($cuit, $username, $password, $alias = 'afipsdk')
    {
        $data = [
            'cuit' => $cuit,
            'username' => $username,
            'password' => $password,
            'alias' => $alias,
        ];

        return $this->afip->CreateAutomation(
            'create-cert-prod',
            $data,
            true
        );
    }
}