<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConfiguracionGlobalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'RazonSocialEmpresa'           => 'required|string|max:255',
            'DomicilioEmpresa'             => 'required|string|max:255',
            'TelefonoEmpresa'              => 'required|string|max:50',
            'CUITEmpresa'                  => 'required|string|max:20',
            'IIBBEmpresa'                  => 'required|string|max:20',
            'FechaInicioActividadesEmpresa'=> 'required|date',
            'LocalidadEmpresa'             => 'required|string|max:100',
            'ProvinciaEmpresa'             => 'required|string|max:100',
            'CodigoSucursal'               => 'required|integer',
            'ImporteMinimoRetencionIIBB'  => 'required|numeric|min:0',
            'CodigoPostalEmpresa'          => 'required|integer',
            'NroAgenteEmpresa'             => 'required|integer',
            'EsAgenteRetencionGanancias'   => 'required|boolean',
            'EsAgenteRetencionIIBB'        => 'required|boolean',
            'CuentaEmailMembretes'         => 'required|string|max:255',
            'CuentaEmail'                  => 'required|string|max:255',
            'ServidorSMTP'                 => 'required|string|max:255',
            'PuertoSMTP'                   => 'required|string|max:10',
            'UsuarioSMTP'                  => 'required|string|max:255',
            'ClaveSMTP'                    => 'required|string|max:255',
            'TiempoDeEsperaSMTP'           => 'required|integer|min:0',
            'OpcionSMTP'                   => 'required|integer',
            'CuentaEmailCCO'               => 'nullable|string|max:255',
            'RemitenteCCO'                 => 'required|boolean',
            'XMLLoginTicketRequest'        => 'required|string|max:255',
            'MofoOperacionFE'              => 'required|string|max:255',
            'RutaCertificadoFE'            => 'required|string|max:255',
            'ClaveCertificadoFE'           => 'required|string|max:255',
            'ClaveForzarValidacionCtaCteCliente' => 'required|string|max:255',
            'FechaCreacion'                => 'nullable|date',
            'CreadoPor'                    => 'nullable|integer|exists:users,id',
            'FechaActualizacion'           => 'nullable|date',
            'ActualizadoPor'               => 'nullable|integer|exists:users,id',
            'Activo'                       => 'required|boolean',
            'CuentaEmailCertificados'      => 'required|string|max:255',
            'ServidorSMTPCertificados'     => 'required|string|max:255',
            'PuertoSMTPCertificados'       => 'required|integer',
            'UsuarioSMTPCertificados'      => 'required|string|max:255',
            'ClaveSMTPCertificados'        => 'required|string|max:255',
            'TiempoDeEsperaSMTPCertificados' => 'required|integer|min:0',
            'OpcionSMTPCertificados'       => 'required|integer',
            'CuentaEmailCCOCertificados'   => 'nullable|string|max:255',
            'RemitenteCCOCertificados'     => 'required|boolean',
            'ValidarProgramacionesSinDatosDurezas' => 'required|boolean',
            'NombreLogo'                   => 'required|string|max:255',
            'PlazoVencimientoFactura'      => 'required|integer|min:0',
            'USD_ARS'                      => 'required|numeric|min:0',
            'FechaActualizacionUSD_ARS'    => 'required|date',
            'FechaEmisionValidaDesde'      => 'required|integer',
            'FechaEmisionValidaHasta'      => 'required|integer',
        ];
    }
}
