<?php

namespace App\Http\Controllers;

use App\Statistics;
use Illuminate\Http\Request;
use App\DataRequestStat;
use Illuminate\Support\Facades\DB;
class StatisticsController extends Controller
{
    public  function index()
    {
        return redirect("/");
    }
    public  function data()
    {
        return redirect("/");
    }
    public  function requests(Request $r)
    {
        return view('statistics/requests')
                ->with('stat', Statistics::getRequests($r))
                ->with('request', $r);
    }
}
