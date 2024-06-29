<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __invoke()
    {
        $users = User::inRandomOrder();
        $items = Item::inRandomOrder();

        // if(request('search')) {
        //     $users->whereAny(['nama', 'role', 'email'], 'like', '%' . request('search') . '%');
        // }

        return view('admin.index', [
            'users' => $users->paginate(3),
            'items' => $items->paginate(3)
        ]);
    }
}
