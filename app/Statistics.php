<?php

namespace App;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class Statistics
{
    public static function aggregateData($day_offset = 0)
    {
        $sql_day = self::to_days() + $day_offset;
        $redis_day = (empty($day_offset)) ? date("Ymd") : date("Ymd", strtotime(" - ".abs($day_offset)." days"));

        echo "\nStart Data Aggregating ... \n";
        foreach(DataClient::all() as $client)
        {

            $stat = Redis::hGetAll(Key::dataHash($client->id,$redis_day));
            echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
            echo "HASH: ".Key::dataHash($client->id,$redis_day)."\n";
            
            if(!empty($stat) && is_array($stat))
            {
                foreach($stat as $key => $inc)
                {
                    list($dmp_id, $tax_id) = explode("::", $key);

                    $statement = "INSERT INTO data_stat_day 
                                    SET day = :day,
                                        client_id = :client_id,
                                        dmp_id = :dmp_id,
                                        tax_id = :tax_id,
                                        hit = :hit
                                    ON DUPLICATE KEY 
                                    UPDATE hit = hit + :hit2;";
                    $params = [
                        "day" => $sql_day,
                        "client_id" => $client->id,
                        "dmp_id" => $dmp_id,
                        "tax_id" => $tax_id,
                        "hit" => $inc,
                        "hit2" => $inc,

                    ];

                    if(DB::statement($statement, $params))
                    {
                        Redis::hIncrBy(Key::dataHash($client->id,$redis_day), $key, ($inc * (-1)));
                        echo "Ok => Date:".$redis_day."/".$sql_day." Cl:".$client->id." DMP:".$dmp_id." Tax:".$tax_id."\n";
                    }
                }
            }
            else
            {
                echo "HASH is empty\n";
            }
        }
        echo "Ok\n";

        return true;
    }

    public static function aggregateRequests($day_offset = 0)
    {
        echo "\nStart Requests Aggregating ... \n";

        $sql_day = self::to_days() + $day_offset;
        $redis_day = (empty($day_offset)) ? date("Ymd") : date("Ymd", strtotime(" - ".abs($day_offset)." days"));
        $increments = [
            "request_count",
            "request_unique_count",
            "error_request_count",
            "response_count",
            "empty_response_count",
            "error_response_count",
        ];

        foreach(DataClient::all() as $client)
        {

            $stat = Redis::hGetAll(Key::requestsHash($client->id,$redis_day));
            echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
            echo "HASH: ".Key::requestsHash($client->id,$redis_day)."\n";
            if(!empty($stat) && is_array($stat))
            {
                // Create statement string
                $statement = "INSERT INTO data_request_stat_day 
                                    SET day = :day,
                                        client_id = :client_id, ";
                foreach($increments as $k => $field)
                    $statement .= " $field = :$field ".( $k < (count($increments)-1) ? ", " : " ");

                $statement .= "ON DUPLICATE KEY UPDATE ";
                foreach($increments as $k => $field)
                    $statement .= " $field = $field + :$field"."U".( $k < (count($increments)-1) ? ", " : ";");

                // Create params array
                $params = [];
                $params["day"] = $sql_day;
                $params["client_id"] = $client->id;
                foreach($increments as $field)
                {
                    $params[$field] = isset($stat[$field]) ? $stat[$field] : 0;
                    $params[$field."U"] = isset($stat[$field]) ? $stat[$field] : 0;
                }

                // Execute statement
                if(DB::statement($statement, $params))
                {
                    foreach($increments as $field)
                        if(isset($stat[$field]))
                            Redis::hIncrBy(Key::requestsHash($client->id,$redis_day), $field, ($stat[$field] * (-1)));

                    echo "Ok => Date:".$redis_day."/".$sql_day." Cl:".$client->id." ";
                    foreach($increments as $field)
                        if(isset($stat[$field]))
                            echo "[".$field." = ".$stat[$field]."] ";
                    echo "\n";
                }
            }
            else
            {
                echo "HASH is empty\n";
            }
        }
        echo "Ok\n";

        return true;
    }




    // Interface Statistics methods
    public static function getRequests(Request $r)
    {
        $day_start = $day_end = date("Y-m-d");
        $str_where = "";
        $client = "client_id, ";
        $str_group = "GROUP BY day, client_id";
        $increments = [
            "request_count",
            "request_unique_count",
            "error_request_count",
            "response_count",
            "empty_response_count",
            "error_response_count",
        ];

        // Обрабатываем данные из формы
        if($r->has('day_start'))
        {
            $day_start = date("Y-m-d", strtotime($r->day_start));
        }
        if($r->has('day_end'))
        {
            $day_end = date("Y-m-d", strtotime($r->day_end));
        }

        $params = [];
        $params['day_start'] = $day_start;
        $params['day_end'] = $day_end;

        if($r->has('client_id') && $r->client_id != 0)
        {
            $str_where = " AND client_id = :client_id ";
            $params['client_id'] = $r->client_id;
        }

        // Если выборка за один день иклиент не указан - бьем по всем клиентам
        if($day_start != $day_end && !($r->has('client_id') && $r->client_id != 0))
        {
            $client = "";
            $str_group = " GROUP BY day ";
        }

        $statement = "SELECT day, $client ";
        foreach($increments as $k => $field)
            $statement .= " sum($field) as $field".( $k < (count($increments)-1) ? ", " : " ");
        $statement .= "FROM data_request_stat_day
                        WHERE day BETWEEN to_days(:day_start) AND to_days(:day_end)
                        $str_where
                        $str_group
                        ORDER BY day DESC;
        ";

        return DB::select($statement, $params);

    }

    public static function getData(Request $r)
    {
        $day_start = $day_end = date("Y-m-d");
        $str_where = "";
        $client = "client_id, ";
        $str_group = "GROUP BY day, client_id, dmp_id, tax_id";

        // Обрабатываем данные из формы
        if($r->has('day_start'))
        {
            $day_start = date("Y-m-d", strtotime($r->day_start));
        }
        if($r->has('day_end'))
        {
            $day_end = date("Y-m-d", strtotime($r->day_end));
        }

        $params = [];
        $params['day_start'] = $day_start;
        $params['day_end'] = $day_end;

        if($r->has('client_id') && !empty($r->client_id))
        {
            $str_where .= " AND client_id = :client_id ";
            $params['client_id'] = $r->client_id;
        }

        if($r->has('dmp_id') && !empty($r->dmp_id))
        {
            $str_where .= " AND dmp_id = :dmp_id ";
            $params['dmp_id'] = $r->dmp_id;
        }

        // Если выборка за один день иклиент не указан - бьем по всем клиентам
        if($day_start != $day_end && !($r->has('client_id') && $r->client_id != 0))
        {
            $client = "";
            $str_group = " GROUP BY day, dmp_id, tax_id ";
        }

        $statement = "SELECT day, $client dmp_id, tax_id, sum(hit) as hit
                        FROM data_stat_day
                        WHERE day BETWEEN to_days(:day_start) AND to_days(:day_end)
                        $str_where
                        $str_group
                        ORDER BY day DESC;
        ";

        return DB::select($statement, $params);

    }

    
    public static function to_days ($time=0)
    {
        if (!$time)
            $time=time();

        $GMT = (int)date("Z");

        $days = ($time+$GMT) / (60 * 60 * 24);
        $days = (int)$days;

        if(!$days) return 0;
        return 719528+$days;
    }

    public static function from_days ($sql_day = false)
    {
        if (!$sql_day)
        {
            $time=time();
        }
        else
        {
            $GMT = (int)date("Z");
            $days = intval($sql_day) - 719528;
            $time = $days * 60 * 60 * 24 - $GMT;
        }

        return date("Y-m-d", $time);





    }
}
