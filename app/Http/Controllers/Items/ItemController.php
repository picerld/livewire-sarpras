<?php

namespace App\Http\Controllers\Items;

use App\Exports\ItemsExport;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.items.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

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
        return view("pages.items.show", [
            "itemId" => $id
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

    public function export()
    {
        $items = Item::all();

        $pdf = Pdf::loadView('exports.items', [
            'items' => $items
        ]);

        return $pdf->download('Laporan Barang-' . Date::now()->format('m-Y') . '.pdf');
    }
}
