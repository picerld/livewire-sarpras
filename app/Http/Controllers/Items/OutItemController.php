<?php

namespace App\Http\Controllers\Items;

use App\Exports\OutgoingItemExport;
use App\Http\Controllers\Controller;
use App\Models\OutgoingItemDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;

class OutItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 'admin' || $role == 'pengawas') {
            return view("pages.outItems.index");
        }

        return view('pages.outItems.unit.index');
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
        $role = Auth::user()->role;
        if ($role == 'admin' || $role == 'pengawas') {
            return view('pages.outItems.show', [
                'outgoingItemCode' => $id
            ]);
        }

        return redirect()->back();
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

    public function export(Request $request)
    {
        $outItems = OutgoingItemDetail::query()
            ->when($request->fromDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $request->fromDate))
            ->when($request->toDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $request->toDate))
            ->get();

        return view('exports.outItems', [
            'outItems' => $outItems,
            'fromDate' => $request->fromDate,
        ]);
    }
}
