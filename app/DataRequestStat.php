<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataRequestStat extends Model
{
    protected $table = 'data_request_stat_day';
    public $primaryKey = ['day', 'client_id'];
    public $incrementing = false;
    public $timestamps = false;
    //protected $fillable = ['hit'];
}
