<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('user.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:25',
            'email' => 'required|string|lowercase|email|max:25|unique:'.User::class,
            'password' => 'required|max:25',
            'nomor_induk' => 'required|string|max:10|unique:'.User::class
        ]);

        User::create($request->all());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    { 
        $validated = $request->validate([
            'nama' => 'required|string|max:25',
            'email' => 'required|string|lowercase|email|max:25',
            'nomor_induk' => 'required|string|max:10',
        ]);

        $user = User::find($id);
        $user->update($request->all());

        return redirect('/petugas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back();
    }
}
