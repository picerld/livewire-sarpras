<?php

namespace App\Exports;

use App\Models\IncomingItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class IncomingItemExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // TEST
        return IncomingItem::query()
            ->with('users', 'suppliers', 'incomingItemDetail')
            ->get();
    }
}
