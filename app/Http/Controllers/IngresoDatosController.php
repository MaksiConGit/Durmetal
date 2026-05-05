<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePremioRequest;
use App\Models\Certificado;
use App\Models\Email;
use App\Models\ItemPremio;
use App\Models\Premio;
use App\Models\Programacion;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class IngresoDatosController extends Controller
{
    public function index()
    {
        return view('produccion.ingreso-datos.index');
    }

    public function update(Request $request, Programacion $programacion)
    {
        $data = $request->all();

        $accion = $request->input('accion');

        if ($accion === 'aprobar') {
            foreach ($data['ProgramacionIds'] as $IdProgramacion) {

                $programacion = Programacion::find($IdProgramacion);

                if ($programacion) {

                    $programacion->update([
                        'DurezaMinima' => $data['DurezaMinima'][$IdProgramacion] ?? 0,
                        'DurezaMaxima' => $data['DurezaMaxima'][$IdProgramacion] ?? 0,
                        'Apto' => $data['ProcesoApto'][$IdProgramacion] ?? null,
                    ]);
                }

                $programacion->itemOrdenTrabajo->update([
                    'Estado' => 'APROBADO'
                ]);

            }

        }
        elseif ($accion === 'aceptar') {

            foreach ($data['ProgramacionIds'] as $IdProgramacion) {

                $programacion = Programacion::find($IdProgramacion);

                if ($programacion) {

                    $programacion->update([
                        'DurezaMinima' => $data['DurezaMinima'][$IdProgramacion] ?? 0,
                        'DurezaMaxima' => $data['DurezaMaxima'][$IdProgramacion] ?? 0,
                        'Apto' => $data['ProcesoApto'][$IdProgramacion] ?? null,
                    ]);
                }
                
            }

        }
    
        return redirect()->route('ingreso-datos.index');
    }

    public function pdf(Certificado $certificado)
    {
        // 🔹 Aumentar cantidad de impresiones
        $certificado->update([
            'CantidadImpresiones' => $certificado->CantidadImpresiones + 1
        ]);

        // // 🔹 Relaciones necesarias
        // $certificado->load([
        //     'itemOrdenTrabajo.ordenTrabajo.cliente',
        //     'itemOrdenTrabajo.material',
        //     'itemOrdenTrabajo.tratamiento',
        //     'responsableTecnico',
        // ]);

        // $item = $certificado->itemOrdenTrabajo;
        // $orden = $item->ordenTrabajo;
        // $cliente = $orden->cliente;

        // // 🔹 Fecha formateada
        // $fecha = Carbon::parse($certificado->Fecha)->format('d/m/Y');

        // // 🔹 Registro de trazabilidad (ejemplo)
        // $registro_trazabilidad = sprintf(
        //     'OT %s-%s',
        //     $orden->Numero,
        //     str_pad($item->ItemNumero, 4, '0', STR_PAD_LEFT)
        // );

        // 🔹 PDF
        $pdf = Pdf::loadView('produccion.ingreso-datos.pdf', [
            'certificado' => $certificado,
            // 'item' => $item,
            // 'orden' => $orden,
            // 'cliente' => $cliente,
            // 'fecha' => $fecha,
            // 'registro_trazabilidad' => $registro_trazabilidad,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('produccion.ingreso-datos.pdf');
    }

    public function email(Certificado $certificado, Request $request)
    {
        // 🔹 Obtener emails
        $ids = explode(',', $request->Emails ?? '');

        if (!$ids || count($ids) === 0 || $ids[0] === '') {
            // Emails del cliente (ajustá la relación si cambia)
            $emails = $certificado
                ->itemOrdenTrabajo
                ->ordenTrabajo
                ->cliente
                ->emails
                ->pluck('Email')
                ->toArray();
        } else {
            $emails = Email::whereIn('Id', $ids)->pluck('Email')->toArray();
        }

        // dd($emails);

        // 🔹 Contador de envíos por mail
        $certificado->CantidadEnviosPorCorreo =
            ($certificado->CantidadEnviosPorCorreo ?? 0) + 1;
        $certificado->save();

        // 🔹 Generar el MISMO PDF que el método pdf()
        $pdf = Pdf::loadView('produccion.ingreso-datos.pdf', [
            'certificado' => $certificado,
        ])->setPaper('A4');

        // 🔹 Enviar mail

        Mail::send('emails.certificado', [
            'certificado' => $certificado,
        ], function ($message) use ($emails, $pdf, $certificado) {

            $message->from('controldecalidad@durmetal.com.ar', 'controldecalidad');

            $message->to($emails)
                ->subject('CERTIFICADO DE TRATAMIENTO TERMICO')
                ->attachData(
                    $pdf->output(),
                    'certificado-' . $certificado->id . '.pdf',
                    ['mime' => 'application/pdf']
                );
        });

        return back()->with('success', 'Certificado enviado por correo correctamente.');
    }
}
