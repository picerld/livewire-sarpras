<?php

namespace App\Exports;

use App\Models\Item;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemsExport implements FromQuery, Responsable, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Nama',
            'Merk',
            'Warna',
            'Size',
            'Tipe',
            'Stok',
            'Unit',
            'Harga',
            'Stok Minimum',
            'Kategori',
            'Supplier',
            'Tanggal',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            // optional ALIGNMENT HORIZONTAL CENTER
            'D' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'G' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
        ];
    }

    public function map($item): array
    {
        return [
            $item->name,
            $item->merk,
            $item->color,
            $item->size,
            $item->type,
            $item->stock,
            strtoupper($item->unit),
            'Rp. ' . number_format($item->price, 0, ',', '.'),
            $item->minimum_stock,
            $item->category->name,
            $item->supplier->name ?? 'N/A',
            $item->created_at->format('d/m/Y'),
        ];
    }

    public function query()
    {
        return Item::query()
            ->select('name', 'merk', 'color', 'size', 'type', 'stock', 'unit', 'price', 'minimum_stock', 'category_id', 'supplier_id', 'created_at')
            ->orderBy('created_at', 'desc');
    }
}
