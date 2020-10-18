<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $characters = Character::where('user_id', Auth::id())
            ->orderBy('owner')
            ->orderBy('name')
            ->get();

        return view('farm', compact('characters'));
    }
}
