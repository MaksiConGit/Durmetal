<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportesPesosResumidoExport implements FromCollection, WithHeadings
{
    public function __construct(
        private Collection $items
    ) {}

    public function collection()
    {
        return $this->items->map(function ($item) {

            return [
                $item->tratamiento->Nombre ?? '',
                $item->CodigoComplejidad ?? '',
                number_format($item->Peso, 2, '.', ''),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tratamiento',
            'CC',
            'Total',
        ];
    }
}