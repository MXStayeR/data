<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataClient extends Model
{
    protected $table = 'data_clients';
    public $primaryKey = 'id';
    public $timestamps = true;
}
