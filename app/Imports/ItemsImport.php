<?php

namespace App\Imports;

use App\Helpers\GenerateCodeHelper;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemsImport implements ToModel, WithHeadings, WithHeadingRow
{
    public function model(array $row)
    {
        return new Item([
            'id' => GenerateCodeHelper::handleGenerateCode(),
            'name' => $row['name'],
            'merk' => $row['merk'],
            'description' => $row['description'], // fix on this description
            'color' => $row['color'],
            'size' => $row['size'],
            'type' => $row['type'],
            'stock' => $row['stock'],
            'price' => $row['price'],
            'minimum_stock' => $row['minimum_stock'],
            'category_id' => Category::where('name', $row['category_id'])->first()->id,
            'supplier_id' => Supplier::where('name', $row['supplier_id'])->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function headings(): array
    {
        return [
            'name',
            'merk',
            'description',
            'color',
            'size',
            'type',
            'stock',
            'price',
            'minimum_stock',
            'supplier_id',
            'category_id',
        ];
    }
}
