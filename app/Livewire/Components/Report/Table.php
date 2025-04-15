<?php

namespace App\Livewire\Components\Report;

use App\Models\Item;
use Carbon\Carbon;
use Livewire\Component;

class Table extends Component
{
    public $itemId;
    public $formattedItems;

    public $headers = [
        ['key' => 'no', 'label' => 'No'],
        ['key' => 'name', 'label' => 'Barang'],
        ['key' => 'incoming_date', 'label' => 'Tanggal Masuk'],
        ['key' => 'outgoing_date', 'label' => 'Tanggal Keluar'],
        ['key' => 'incoming_qty', 'label' => 'Jumlah Masuk'],
        ['key' => 'outgoing_qty', 'label' => 'Jumlah Keluar'],
    ];

    public bool $reportExportPdf = false;

    public function reportPdfModal()
    {
        $this->reportExportPdf = true;
    }

    public function mount($itemId): void
    {
        $this->itemId = $itemId;
    }

    public function items()
    {
        $items = Item::where('items.id', $this->itemId)
            ->select('items.name', 'items.unit', 'items.stock', 'items.id', 'incoming_item_detail.qty as incoming_qty', 'outgoing_item_detail.qty as outgoing_qty', 'incoming_item_detail.created_at as incoming_date', 'outgoing_item_detail.created_at as outgoing_date')
            ->join('incoming_item_detail', 'incoming_item_detail.item_code', '=', 'items.id')
            ->join('outgoing_item_detail', 'outgoing_item_detail.item_code', '=', 'items.id')
            ->get();

        $this->formattedItems = collect();

        foreach ($items as $item) {
            $incomingDate = Carbon::parse($item->incoming_date)->toDateString();
            $outgoingDate = Carbon::parse($item->outgoing_date)->toDateString();

            if ($incomingDate !== $outgoingDate) {
                $this->formattedItems->push((object) [
                    'id' => $item->id,
                    'name' => $item->name,
                    'unit' => $item->unit,
                    'stock' => $item->stock,
                    'incoming_qty' => $item->incoming_qty,
                    'outgoing_qty' => null,
                    'incoming_date' => $item->incoming_date,
                    'outgoing_date' => null,
                    'type' => 'incoming',
                ]);

                $this->formattedItems->push((object) [
                    'id' => $item->id,
                    'name' => $item->name,
                    'unit' => $item->unit,
                    'stock' => $item->stock,
                    'outgoing_qty' => $item->outgoing_qty,
                    'incoming_qty' => null,
                    'outgoing_date' => $item->outgoing_date,
                    'incoming_date' => null,
                    'type' => 'outgoing',
                ]);
            } else {
                $this->formattedItems->push((object) [
                    'id' => $item->id,
                    'name' => $item->name,
                    'unit' => $item->unit,
                    'stock' => $item->stock,
                    'incoming_qty' => $item->incoming_qty,
                    'outgoing_qty' => $item->outgoing_qty,
                    'incoming_date' => $item->incoming_date,
                    'outgoing_date' => $item->outgoing_date,
                    'type' => 'both',
                ]);
            }
        }

        return $this->formattedItems;
    }

    public function render()
    {
        $items = $this->items();

        return view('livewire.components.report.table', [
            'formattedItems' => $items,
            'headers' => $this->headers
        ]);
    }
}
