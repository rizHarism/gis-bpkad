<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
        return view('maps');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function inventaris_kib_a()
    {
        return view('inventaris_kib_a');
    }
}
