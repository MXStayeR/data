<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class ClientIpAllow extends Model
{
    protected $table = 'client_ip_allow';
    public $primaryKey = ['client_id', 'ip'];
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['ip'];



    public function save(array $options = [])
    {
        Redis::sAdd(Key::clientSecurityItems($this->client_id, 'ip'), $this->ip);
        return parent::save($options);
    }

    public function delete()
    {
        Redis::sRem(Key::clientSecurityItems($this->client_id, 'ip'), $this->ip);
        return parent::delete();
    }
}
