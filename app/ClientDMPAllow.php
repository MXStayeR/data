<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class ClientDMPAllow extends Model
{
    protected $table = 'client_dmp_allow';
    public $primaryKey = ['client_id', 'dmp_id'];
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['dmp_id'];



    public function save(array $options = [])
    {
        Redis::sAdd(Key::clientAllowedDMPs($this->client_id), $this->dmp_id);
        return parent::save($options);
    }

    public function delete()
    {
        Redis::sRem(Key::clientAllowedDMPs($this->client_id), $this->dmp_id);
        return parent::delete();
    }
}
