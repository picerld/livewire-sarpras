<?php

namespace App\Exports;

use App\Models\IncomingItemDetail;
use App\Models\OutgoingItemDetail;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OutgoingItemExport implements FromQuery, Responsable, WithHeadings, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Barang',
            'Jumlah',
            'Tanggal',
            'Keterangan',
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

    public function map($outgoingItemDetail): array
    {
        return [
            $outgoingItemDetail->item->name,
            $outgoingItemDetail->qty,
            $outgoingItemDetail->created_at->format('d/m/Y'),
        ];
    }

    public function query()
    {
        return OutgoingItemDetail::with('item')->orderBy('created_at', 'desc');
    }
}
