<?php

namespace App\Exports;

use App\Models\ItemOrdenTrabajo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ReportesMaterialesExport implements FromCollection, WithHeadings
{
    public function __construct(
        private Collection $items
    ) {}

    public function collection()
    {
        return $this->items->map(function ($item) {

            $fila = [
                \Carbon\Carbon::parse($item->FechaCreacion)->format('j/n/Y'),
                $item->ordenTrabajo->cliente->id ?? '',
                number_format($item->Cantidad, 2, '.', ''),
                number_format($item->Peso, 2, '.', ''),
                $item->tratamiento->Nombre ?? '',
                $item->material->Nombre ?? '',
                $item->Descripcion,
                $item->dureza->Nombre ?? '',
            ];

            foreach ($item->programacion as $programacion) {
                $fila[] = $programacion->tipoProgramacion->Nombre ?? '';
                $fila[] = $programacion->Temperatura ?? '';
                $fila[] = $programacion->medioEnfriamiento->Nombre ?? '';
                $fila[] = $programacion
                    ? $programacion->DurezaMinima . '/' . $programacion->DurezaMaxima
                    : '';
                $fila[] = $programacion->DurezaMinima ?? '';
                $fila[] = $programacion->DurezaMaxima ?? '';
            }

            return $fila;
        });
    }


    public function headings(): array
    {
        return [
            'Fecha',
            'Cliente',
            'Cantidad',
            'Peso',
            'Tratamiento',
            'Material',
            'Descripción',
            'Dureza',
            'Programación',
            'T°',
            'Medio Enf.',
            'DMIN/DMAX',
            'DMIN',
            'DMAX',
        ];
    }
}