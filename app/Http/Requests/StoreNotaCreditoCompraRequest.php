<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotaCreditoCompraRequest extends FormRequest
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
            'IdFacturaCompra' => 'nullable|exists:facturacompra,id',
            'Letra' => 'required|string|max:1',
            'PuntoVenta' => 'required|integer',
            'Numero' => 'required|integer',
            'NumeroCompleto' => 'required|string',
            'FechaEmision' => 'required|date',
            'FechaRegistro' => 'required|date',
            'FechaVencimiento' => 'required|date',
            'TipoOperacion' => 'nullable|string',
            'IdProveedor' => 'nullable|exists:proveedor,id',
            'IdCondicionIva' => 'nullable|exists:condicion_iva,id',
            'NumeroDocumentoProveedor' => 'required|string',
            'Neto' => 'nullable|numeric',
            'AjusteNeto' => 'nullable|numeric',
            'IVA' => 'nullable|numeric',
            'AjusteIVA' => 'nullable|numeric',
            'ImpuestoInterno' => 'nullable|numeric',
            'ImpuestoCombustible' => 'nullable|numeric',
            'ImpuestoTV' => 'nullable|numeric',
            'ConceptosNoGravados' => 'nullable|numeric',
            'PercepcionIIBB' => 'nullable|numeric',
            'PercepcionIVA' => 'nullable|numeric',
            'PercepcionGanancias' => 'nullable|numeric',
            'Sellados' => 'nullable|numeric',
            'Bonificacion' => 'nullable|numeric',
            'Recargo' => 'nullable|numeric',
            'AjustePorRedondeo' => 'nullable|numeric',
            'Total' => 'nullable|numeric',
            'Estado' => 'required|string',
            'CAE' => 'nullable|integer',
            'FechaVencimientoCAE' => 'nullable|date',
            'Observaciones' => 'nullable|string',
            'NumeroTurno' => 'required|integer',
            'ReferenciaTurno' => 'required|integer',
            'FechaCreacion' => 'nullable|date',
            'CreadoPor' => 'nullable|exists:users,id',
            'FechaActualizacion' => 'nullable|date',
            'ActualizadoPor' => 'nullable|exists:users,id',
            'Activo' => 'required|boolean',
            'LetraPuntoVentaNumeroIdProveedor2' => 'required|string',
        ];
    }
}
