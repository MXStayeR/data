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

        $day1 = '2017-02-15';
        $day2 = '2017-02-15';
        $day2 = '2017-02-15';

        $stat = DataRequestStat::whereBetween( 'day', [Statistics::to_days(), Statistics::to_days()] )
            ->orderBy('client_id')
            ->get();


        //var_dump($data); exit;
        return view('statistics/requests')
                ->with('stat', $stat);
    }
}
