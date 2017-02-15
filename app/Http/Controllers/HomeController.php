<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\DMP;
use App\Taxonomy;
use App\Statistics;


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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('home');
    }

    public function test()
    {
//        foreach(DMP::find(8)->taxonomies as $tax)
//        {
//            echo $tax->text."<br>";
//        }
//
//        //$tax = Taxonomy::where("id", "=", 22)->where("dmp_id", "=", 8)->first();
//        var_dump(Taxonomy::getDmpTaxonomy(8,20)->text); exit;

//        $increments = [
//            "request_count" => 11,
//            "request_unique_count" => 8,
//            "error_request_count" => 1,
//            "response_count" => 2,
//            "empty_response_count" => 7
//        ];
//        Redis::hMSet("client::6::stat::".Statistics::to_days(), $increments);
//        Statistics::aggregateRequests();
//        var_dump(Redis::hGetAll("client::6::stat::".Statistics::to_days()));

    }
    
}
