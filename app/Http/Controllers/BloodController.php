<?php

namespace App\Http\Controllers;

use App\Don;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BloodController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $notifications = Auth::user()->Dons;

        return view('home',compact('notifications'));
    }
}
