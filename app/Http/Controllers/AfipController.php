<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AfipService;

class AfipController extends Controller
{
    public function ultimaFacturaA(AfipService $afipService)
    {
        try {
            $puntoVenta = 1;
            $tipoFactura = 1;

            $factura = $afipService->obtenerUltimaFactura($puntoVenta, $tipoFactura);

            return response()->json($factura);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function ultimaFacturaB(AfipService $afipService)
    {
        try {
            $puntoVenta = 1;
            $tipoFactura = 6;

            $factura = $afipService->obtenerUltimaFactura($puntoVenta, $tipoFactura);

            return response()->json($factura);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function formularioCertificado()
    {
        return view('arca.certificado');
    }

    public function crearCertificadoProduccion(
        Request $request,
        AfipService $afipService
    ) {
        $request->validate([
            'cuit' => ['required', 'digits:11'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'alias' => ['nullable', 'string', 'max:100'],
        ]);

        try {
            $response = $afipService->crearCertificadoProduccion(
                $request->cuit,
                $request->username,
                $request->password,
                $request->alias ?? 'afipsdk'
            );

            return back()->with(
                'success',
                'Certificado de producción creado correctamente.'
            );

        } catch (\Throwable $e) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    'afip' => $e->getMessage()
                ]);
        }
    }
}
