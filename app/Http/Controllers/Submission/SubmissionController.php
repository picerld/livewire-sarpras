<?php

namespace App\Http\Controllers\Submission;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Auth::user()->role;

        if ($role == 'admin' || $role == 'pengawas') {
            return view('pages.submission.index');
        }

        return view('pages.submission.unit.index');
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
            return view('pages.submission.show', [
                'submissionCode' => $id
            ]);
        }

        // return view('pages.submission.unit.show', [
        //     'submissionCode' => $id
        // ]);

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
        $submissions = Submission::select('submission.*', 'submission_detail.qty as qty_item', 'submission_detail.qty_accepted as qty_approved', 'users.username as user_name', 'employees.name as pegawai_name', 'items.name as item_name')
            ->join('submission_detail', 'submission.id', '=', 'submission_detail.submission_code')
            ->join('items', 'submission_detail.item_code', '=', 'items.id')
            ->join('users', 'submission.nip', '=', 'users.nip')
            ->join('employees', 'employees.id', '=', 'submission.nip')
            ->when($request->fromDate, fn($q) => $q->whereDate('submission.created_at', '>=', $request->fromDate))
            ->when($request->toDate, fn($q) => $q->whereDate('submission.created_at', '<=', $request->toDate))
            ->when($request->status, fn($q) => $q->where('submission.status', $request->status))
            ->when($request->nip, fn($q) => $q->where('submission.nip', $request->nip))
            ->get();

        return view('exports.submissions', [
            'submissions' => $submissions,
            'fromDate' => $request->fromDate
        ]);
    }
}
