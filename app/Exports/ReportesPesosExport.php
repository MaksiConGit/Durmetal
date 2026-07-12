<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class ReportesPesosExport implements FromCollection, WithHeadings
{
    public function __construct(
        private Collection $items
    ) {}

    public function collection()
    {
        $total_acumulado = 0;

        return $this->items->map(function ($item) use (&$total_acumulado) {

            $total_acumulado += $item->Peso;

            return [
                Carbon::parse($item->FechaCreacion)->format('j/n/Y'),
                $item->tratamiento->Nombre ?? '',
                $item->material->Nombre ?? '',
                $item->Descripcion ?? '',
                number_format($item->Cantidad, 2, '.', ''),
                number_format($item->Peso, 2, '.', ''),
                $item->CodigoComplejidad ?? '',
                number_format($total_acumulado, 2, '.', ''),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Trat.',
            'Material',
            'Descripcion',
            'Cant.',
            'Peso',
            'CC',
            'Total Acumulado',
        ];
    }
}