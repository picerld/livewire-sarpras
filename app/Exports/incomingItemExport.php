<?php

namespace App\Exports;

use App\Models\IncomingItemDetail;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IncomingItemExport implements FromQuery, Responsable, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Barang',
            'Jumlah',
            'Tanggal',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'B' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
            'C' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
        ];
    }

    public function map($incomingItemDetail): array
    {
        return [
            $incomingItemDetail->item->name,
            $incomingItemDetail->qty,
            $incomingItemDetail->created_at->format('d/m/Y'),
        ];
    }

    public function query()
    {
        return IncomingItemDetail::with('item')->orderBy('created_at', 'desc');
    }
}
