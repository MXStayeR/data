<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataRequestStat extends Model
{
    protected $table = 'data_request_stat_day';
    public $primaryKey = ['day', 'client_id'];
    public $incrementing = false;
    public $timestamps = false;


    public static $incrementers = [
        "request_count" => 0,
        "request_unique_count" => 0,
        "error_request_count" => 0,
        "response_count" => 0,
        "unique_response_count" => 0,
        "filled_response_count" => 0,
        "unique_filled_response_count" => 0,
        "error_response_count" => 0,
    ];

}
