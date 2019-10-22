<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GPC_SYSTEM;

class RegisterController extends Controller
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
    public function viewsystems()
    {
        $systems = GPC_SYSTEM::paginate(10);

        return view('systems')->with('systems', $systems);
    }
}
