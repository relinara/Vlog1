<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Jira;
use App\JIRA_KPI;

class JiraController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $dba;
    private $saa;
    private $tua;

    public function __construct()
    {
        $this->middleware('auth');

        $this->dba = 10306;
        $this->saa = 10206;
        $this->tua = 10319;
    }

    public function get_jiras() 
    {
        return view('jiras');
    }

    public function post_jiras(Request $request)
    {
        $jiralist = new JIRA_KPI();
        $jira_lists = $jiralist->orderBy('created', 'desc')->get();
        
        $count = $jira_lists->count();
        
        $result = array();
        $result["iTotalRecords"] = $count;
        $result["iTotalDisplayRecords"] = $count;
        $result["sEcho"] = 0;
        $result["sColumns"] = "";

        $data = array();
        foreach($jira_lists as $jira)
        {
            $eachdata = [];
            $eachdata['projectname'] = $jira['projectname'];
            $eachdata['type'] = $jira['type'];
            $eachdata['typename'] = $jira['typename'];
            $eachdata['compname'] = $jira['compname'];
            $eachdata['jiranum'] = $jira['jiranum'];
            $eachdata['status'] = $jira['status'];
            $eachdata['created'] = $jira['created'];
            $eachdata['l_resolutiondate'] = $jira['l_resolutiondate'];
            $eachdata['diff_time'] = $jira['diff_time'];
            $eachdata['maxtime'] = $jira['maxtime'];
            $eachdata['error'] = $jira['error'];
            $eachdata['assignee'] = $jira['assignee'];
            $eachdata['assigneename'] = $jira['assigneename'];
            $eachdata['projectid'] = $jira['projectid'];

            array_push($data, $eachdata);
        }

        $result["aaData"] = $data;

        return response()->json( $result );
    }

    public function post_jira_statistic(Request $request)
    {
        $jiralist = new JIRA_KPI();

        // Хугацаа шаардагдахгүй шийдвэрлэсэн JIRA
        $resolved_easy = $jiralist->select('projectid')->where('MAXTIME','<=',8)->whereIn('status', ['10001-Шийдвэрлэсэн','10219-Хаагдсан']);
        // Хугацаа шаардагдахгүй бүх JIRA
        $easy = $jiralist->select('projectid')->where('MAXTIME','<=',8);

        // Хугацаа шаардагдах шийдвэрлэсэн JIRA
        $solved_hard = $jiralist->select('projectid')->where('MAXTIME','>',8)->whereIn('status', ['10001-Шийдвэрлэсэн','10219-Хаагдсан']);
        // Хугацаа шаардагдах бүх JIRA
        $hard = $jiralist->select('projectid')->where('MAXTIME','>',8);

        // Стандарт хугацаандаа шийдвэрлэсэн JIRA (Хугацаа шаардагдахгүй)
        $normal_easy = $jiralist->select('projectid')->where('MAXTIME','<=',8)->where('DIFF_TIME','<=','MAXTIME')->whereIn('status', ['10001-Шийдвэрлэсэн','10219-Хаагдсан']);
        
        // Стандарт хугацаандаа шийдвэрлэсэн JIRA (Хугацаа шаардагдах)
        $normal_hard = $jiralist->select('projectid')->where('MAXTIME','>',8)->where('DIFF_TIME','<=','MAXTIME')->whereIn('status', ['10001-Шийдвэрлэсэн','10219-Хаагдсан']);

        
    }
}