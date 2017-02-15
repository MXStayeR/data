<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataStat extends Model
{
    protected $table = 'data_stat_day';
    public $primaryKey = ['day', 'client_id', 'dmp_id', 'tax_id'];
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['hit'];
}
