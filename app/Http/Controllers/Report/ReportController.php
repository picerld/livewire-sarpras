<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.report.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.report.show', [
            'itemId' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(Request $request, $id)
    {
        $items = Item::where('items.id', $id)
            ->select('items.name', 'items.unit', 'items.stock', 'items.id', 'incoming_item_detail.qty as incoming_qty', 'outgoing_item_detail.qty as outgoing_qty', 'incoming_item_detail.created_at as incoming_date', 'outgoing_item_detail.created_at as outgoing_date')
            ->join('incoming_item_detail', 'incoming_item_detail.item_code', '=', 'items.id')
            ->join('outgoing_item_detail', 'outgoing_item_detail.item_code', '=', 'items.id')
            ->get();

        $formattedItems = collect();

        foreach ($items as $item) {
            $incomingDate = Carbon::parse($item->incoming_date)->toDateString();
            $outgoingDate = Carbon::parse($item->outgoing_date)->toDateString();

            if ($incomingDate !== $outgoingDate) {
                $formattedItems->push((object) [
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

                $formattedItems->push((object) [
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
                $formattedItems->push((object) [
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

        return view('exports.report', [
            'items' => $formattedItems
        ]);
    }
}
