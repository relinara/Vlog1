<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GPC_SSL_ALERT;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SSLController extends Controller
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
    public function viewssls()
    {
 
        $selected = array();
        $ssls = GPC_SSL_ALERT::paginate(10);

        /* It's checking POST Datas */
        if(isset($_POST["ssl_name"]) && isset($_POST["created-date"]) && isset($_POST["expiry-date"]) && $_SERVER['REQUEST_METHOD'] === 'POST') {

            $selected = $_POST["ssl_name"];
            $created_date = $_POST["created-date"];
            $expiry_date = $_POST["expiry-date"];
            DB::table('GPC_SSL_ALERT')->insert(
                ["system_name" => "$selected", "from" => "$created_date", "to" => "$expiry_date"]
            );
        }

        return view('ssls')->with('ssls', $ssls)->with('selected', $selected);
    }

    public function add_ssl() {

        /* It's checking POST Datas */
        if(isset($_POST["ssl_name"]) && isset($_POST["created-date"]) && isset($_POST["expiry-date"]) && $_SERVER['REQUEST_METHOD'] === 'POST') {

            $selected = $_POST["ssl_name"];
            $created_date = $_POST["created-date"];
            $expiry_date = $_POST["expiry-date"];
            DB::table('GPC_SSL_ALERT')->insert(
                ["system_name" => "$selected", "from" => "$created_date", "to" => "$expiry_date"]
            );
        }

        header('Location: test.php');
        return view('ssls');
    }
}
