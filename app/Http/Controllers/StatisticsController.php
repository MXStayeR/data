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
    public  function data(Request $request)
    {
        return view('statistics/data')
            ->with('stat', Statistics::getData($request))
            ->with('request', $request);
    }
    public  function requests(Request $request)
    {
        return view('statistics/requests')
                ->with('stat', Statistics::getRequests($request))
                ->with('request', $request);
    }
}
