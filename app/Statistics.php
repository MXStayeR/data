<?php

namespace App;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;


class Statistics
{
    public static function aggregateData($day_offset = 0)
    {
        $day = self::to_days() + $day_offset;
        $success = true;
        foreach(DataClient::all() as $client)
        {
            $stat = Redis::hGetAll("client::".$client->id."::data::stat::".$day);
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
                                    UPDATE hit = :hit2;";
                    $params = [
                        "day" => $day,
                        "client_id" => $client->id,
                        "dmp_id" => $dmp_id,
                        "tax_id" => $tax_id,
                        "hit" => $inc,
                        "hit2" => $inc,
                    ];

                    if(DB::statement($statement, $params))
                    {
                        $success = false;
                    }
                }
            }
        }

        return $success;
    }

    public static function aggregateRequests($day_offset = 0)
    {
        $day = self::to_days() + $day_offset;
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
            $stat = Redis::hGetAll("client::".$client->id."::stat::".$day);
            $success = true;
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
                    $statement .= " $field = :$field"."U".( $k < (count($increments)-1) ? ", " : ";");

                // Create params array
                $params = [];
                $params["day"] = $day;
                $params["client_id"] = $client->id;
                foreach($increments as $field)
                {
                    $params[$field] = isset($stat[$field]) ? $stat[$field] : 0;
                    $params[$field."U"] = isset($stat[$field]) ? $stat[$field] : 0;
                }

                // Execute statement
                if(!DB::statement($statement, $params))
                {
                    $success = false;
                }
            }
        }

        return $success;
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
}
