<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Auth::user()->role;
        
        if($role == 'admin' || $role == 'pengawas') {
            return view("pages.request.index");
        }

        return view('pages.request.unit.index');
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

        if($role == 'admin' || $role == 'pengawas') {
            return view('pages.request.show', [
                'requestCode' => $id
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
        $requests = ModelsRequest::select('request.*', 'users.username as user_name', 'request_detail.qty as qty_item', 'request_detail.qty_accepted as qty_approved', 'items.name as item_name')
            ->join('request_detail', 'request.id', '=', 'request_detail.request_code')
            ->join('items', 'request_detail.item_code', '=', 'items.id')
            ->join('users', 'request.nip', '=', 'users.nip')
            ->when($request->fromDate, fn($q) => $q->whereDate('request.created_at', '>=', $request->fromDate))
            ->when($request->toDate, fn($q) => $q->whereDate('request.created_at', '<=', $request->toDate))
            ->when($request->status, fn($q) => $q->where('request.status', $request->status))
            ->when($request->nip, fn($q) => $q->where('request.nip', $request->nip))
            ->get();

        return view('exports.requests', [
            'requests' => $requests,
            'fromDate' => $request->fromDate
        ]);
    }
}
