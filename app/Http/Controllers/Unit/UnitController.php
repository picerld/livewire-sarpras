<?php

namespace App\Http\Controllers\unit;

use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function __invoke()
    {
        return view('pages.unit.index');
    }
}
