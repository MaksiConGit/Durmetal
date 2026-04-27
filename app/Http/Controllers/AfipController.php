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
}
