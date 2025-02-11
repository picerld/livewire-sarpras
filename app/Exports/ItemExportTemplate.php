<?php

namespace App\Exports;

use App\Models\Item;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemExportTemplate implements FromCollection, Responsable, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    public function headings(): array
    {
        return [
            'name',
            'merk',
            'color',
            'size',
            'type',
            'stock',
            'unit',
            'price',
            'minimum_stock',
            'category_id',
            'supplier_id',
            'description',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
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
            $item->unit,
            $item->price,
            $item->minimum_stock,
            $item->category->name,
            $item->supplier->name ?? 'N/A',
            $item->description
        ];
    }

    public function collection()
    {
        return Item::take(1)->get();
    }
}
