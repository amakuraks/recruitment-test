<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;

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
        return redirect()->route('token.index');
    }

    public function system()
    {
        return view('system');
    }

    public function log()
    {
        $logs = LogActivity::all();
        return view('log', compact('logs'));
    }

    public function info()
    {
        return phpinfo();
    }
}
